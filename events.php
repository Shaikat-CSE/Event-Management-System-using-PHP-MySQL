<?php
// filepath: /c:/xampp/htdocs/event_management/events.php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require 'config.php'; // Database connection

// Pagination variables
$limit = 10; // Number of entries per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Sorting variables
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'event_date';
$sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';

// Filtering variables
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';

// Fetch events from the database with pagination, sorting, and filtering
$stmt = $conn->prepare("SELECT e.*, (SELECT COUNT(*) FROM attendees a WHERE a.event_id = e.id) AS registered_guests FROM events e WHERE e.event_name LIKE ? ORDER BY $sort_by $sort_order LIMIT ?, ?");
$filter_param = "%$filter%";
$stmt->bind_param("sii", $filter_param, $start, $limit);
$stmt->execute();
$result = $stmt->get_result();

// Fetch total number of events for pagination
$total_stmt = $conn->prepare("SELECT COUNT(*) FROM events WHERE event_name LIKE ?");
$total_stmt->bind_param("s", $filter_param);
$total_stmt->execute();
$total_result = $total_stmt->get_result();
$total_events = $total_result->fetch_row()[0];
$total_pages = ceil($total_events / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Manage Events - Event Management</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url('assets/images/eventBg.jpg') no-repeat center center fixed;
            background-size: cover;
            position: relative;
            overflow: hidden;
        }
        .navbar {
            background-color: #2196f3;
        }
        .navbar-brand {
            color: #fff !important;
            font-weight: bold;
            font-size: 1.5rem;
        }
        .navbar-nav .nav-link {
            color: #fff !important;
        }
        .container {
            margin-top: 40px;
        }
        .btn-custom {
            background-color: #2196f3;
            color: white;
            border: none;
        }
        .btn-custom:hover {
            background-color: #1976d2;
        }
        .table-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .modal-header {
            background-color: #2196f3;
            color: white;
        }
        .pagination {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">Event Management</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="attendees.php">Manage Attendees</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Display Feedback Messages -->
<div class="container">
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-<?= $_SESSION['message_type']; ?> alert-dismissible fade show" role="alert">
            <?= $_SESSION['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
    <?php endif; ?>
</div>

<!-- Page Content -->
<div class="container">
    <h1 class="text-center mb-4">Manage Events</h1>
    <div class="mb-3 d-flex">
        <input type="text" id="filter" class="form-control me-2" placeholder="Filter by event name" value="<?= htmlspecialchars($filter) ?>">
        <button id="searchButton" class="btn btn-custom">Search</button>
    </div>
    <button class="btn btn-custom mb-3" data-bs-toggle="modal" data-bs-target="#addEventModal">Add New Event</button>
    
    <div class="table-container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th><a href="#" class="sort" data-sort="id">ID</a></th>
                    <th><a href="#" class="sort" data-sort="event_name">Event Name</a></th>
                    <th>Description</th>
                    <th><a href="#" class="sort" data-sort="event_date">Date</a></th>
                    <th>Max Capacity</th>
                    <th>Registered Guests</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['event_name']) ?></td>
                    <td><?= htmlspecialchars($row['event_desc']) ?></td>
                    <td><?= $row['event_date'] ?></td>
                    <td><?= $row['max_capacity'] ?></td>
                    <td><?= $row['registered_guests'] ?></td>
                    <td>
                        <a href="edit_event.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete_event.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this event?')">Delete</a>
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#attendeesModal" data-eventid="<?= $row['id'] ?>" data-eventname="<?= htmlspecialchars($row['event_name']) ?>">Manage Attendees</button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <nav>
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>&sort_by=<?= $sort_by ?>&sort_order=<?= $sort_order ?>&filter=<?= htmlspecialchars($filter) ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>

<!-- Add Event Modal -->
<div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="add_event.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEventModalLabel">Add New Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="event_name" class="form-label">Event Name</label>
                        <input type="text" class="form-control" id="event_name" name="event_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="event_desc" class="form-label">Description</label>
                        <textarea class="form-control" id="event_desc" name="event_desc" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="event_date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="event_date" name="event_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="max_capacity" class="form-label">Max Capacity</label>
                        <input type="number" class="form-control" id="max_capacity" name="max_capacity" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-custom">Add Event</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Attendees Modal -->
<div class="modal fade" id="attendeesModal" tabindex="-1" aria-labelledby="attendeesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="attendeesModalLabel">Manage Attendees</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Add Attendee Form -->
                <form id="addAttendeeForm">
                    <div class="mb-3">
                        <label for="attendee_name" class="form-label">Attendee Name</label>
                        <input type="text" class="form-control" id="attendee_name" name="attendee_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="attendee_email" class="form-label">Attendee Email</label>
                        <input type="email" class="form-control" id="attendee_email" name="attendee_email" required>
                    </div>
                    <input type="hidden" id="event_id" name="event_id">
                    <button type="submit" class="btn btn-primary">Add Attendee</button>
                </form>

                <!-- List of Attendees -->
                <div id="attendeesList"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('searchButton').addEventListener('click', function() {
        const filter = document.getElementById('filter').value;
        window.location.href = `?filter=${filter}`;
    });

    document.querySelectorAll('.sort').forEach(function(element) {
        element.addEventListener('click', function(event) {
            event.preventDefault();
            const sort_by = this.getAttribute('data-sort');
            const sort_order = (new URLSearchParams(window.location.search).get('sort_order') === 'ASC') ? 'DESC' : 'ASC';
            window.location.href = `?sort_by=${sort_by}&sort_order=${sort_order}&filter=${document.getElementById('filter').value}`;
        });
    });
});

function removeAttendee(attendeeId, eventId) {
    if (confirm('Are you sure you want to remove this attendee?')) {
        fetch('remove_attendee.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `attendee_id=${attendeeId}&event_id=${eventId}`
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            location.reload(); // Reload to show updated attendee list
        });
    }
}
</script>

</body>
</html>