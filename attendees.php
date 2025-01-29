<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require 'config.php'; // Database connection

// Search functionality
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Pagination functionality
$limit = 10; // Number of entries per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Sorting functionality
$sort_column = isset($_GET['sort']) ? $_GET['sort'] : 'id';
$sort_order = isset($_GET['order']) && $_GET['order'] == 'desc' ? 'DESC' : 'ASC';

// Fetch all attendees with search, pagination, and sorting
$stmt = $conn->prepare("SELECT a.id, a.name, a.email, e.event_name, a.event_id FROM attendees a JOIN events e ON a.event_id = e.id WHERE a.name LIKE ? ORDER BY $sort_column $sort_order LIMIT ? OFFSET ?");
$search_param = "%$search%";
$stmt->bind_param('sii', $search_param, $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();

// Fetch total number of attendees for pagination
$total_stmt = $conn->prepare("SELECT COUNT(*) as total FROM attendees WHERE name LIKE ?");
$total_stmt->bind_param('s', $search_param);
$total_stmt->execute();
$total_result = $total_stmt->get_result();
$total_attendees = $total_result->fetch_assoc()['total'];

// Check if CSV download is requested
if (isset($_GET['download']) && $_GET['download'] == 'csv') {
    // Set headers for CSV download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="attendees_list.csv"');
    
    // Open output stream
    $output = fopen('php://output', 'w');
    
    // Add CSV header
    fputcsv($output, ['ID', 'Attendee Name', 'Email', 'Event']);
    
    // Add rows to CSV
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, [$row['id'], $row['name'], $row['email'], $row['event_name']]);
    }
    
    // Close output stream
    fclose($output);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Manage Attendees - Event Management</title>
    <style>
        body {
            background:url('assets/images/manage-attandees.jpg') no-repeat center center fixed;
            font-family: 'Arial', sans-serif;
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
        .pagination-container {
            margin-top: 20px;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
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
                    <a class="nav-link" href="events.php">Manage Events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Page Content -->
<div class="container">
    <h1 class="text-center mb-4">Manage Attendees</h1>

    <!-- Search Form -->
    <form method="GET" action="attendees.php" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search attendees" value="<?= htmlspecialchars($search) ?>">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>

    <!-- CSV Download Button -->
    <div class="text-end mb-3">
        <a href="attendees.php?download=csv" class="btn btn-success">Download Attendees List (CSV)</a>
    </div>

    <div class="table-container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th><a href="?search=<?= $search ?>&sort=id&order=<?= $sort_order == 'ASC' ? 'desc' : 'asc' ?>">ID</a></th>
                    <th><a href="?search=<?= $search ?>&sort=name&order=<?= $sort_order == 'ASC' ? 'desc' : 'asc' ?>">Attendee Name</a></th>
                    <th><a href="?search=<?= $search ?>&sort=email&order=<?= $sort_order == 'ASC' ? 'desc' : 'asc' ?>">Email</a></th>
                    <th><a href="?search=<?= $search ?>&sort=event_name&order=<?= $sort_order == 'ASC' ? 'desc' : 'asc' ?>">Event</a></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['event_name']) ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="openEditModal(<?= $row['id'] ?>, '<?= htmlspecialchars($row['name']) ?>', '<?= htmlspecialchars($row['email']) ?>')">Edit</button>
                        <a href="delete_attendee.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this attendee?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="pagination-container">
        <nav>
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= ceil($total_attendees / $limit); $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="?search=<?= $search ?>&sort=<?= $sort_column ?>&order=<?= $sort_order ?>&page=<?= $i ?>"><?= $i ?></a>
                </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <h2>Edit Attendee</h2>
        <form id="editForm" method="POST" action="update_attendee.php">
            <input type="hidden" name="id" id="editId">
            <div class="mb-3">
                <label for="editName" class="form-label">Name</label>
                <input type="text" class="form-control" id="editName" name="name" required>
            </div>
            <div class="mb-3">
                <label for="editEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="editEmail" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function openEditModal(id, name, email) {
        document.getElementById('editId').value = id;
        document.getElementById('editName').value = name;
        document.getElementById('editEmail').value = email;
        document.getElementById('editModal').style.display = 'block';
    }

    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }
</script>
</body>
</html>
