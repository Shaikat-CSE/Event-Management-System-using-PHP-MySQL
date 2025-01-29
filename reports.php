<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - Event Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('assets/images/reportsBg.jpg') no-repeat center center fixed;
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
        .chart-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
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
                    <a class="nav-link" href="attendees.php">Manage Attendees</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout_process.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Page Content -->
<div class="container">
    <h1 class="text-center mb-4">Event Reports</h1>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-md-6">
            <input type="date" class="form-control" placeholder="Start Date">
        </div>
        <div class="col-md-6">
            <input type="date" class="form-control" placeholder="End Date">
        </div>
    </div>

    <!-- Report Sections -->
    <div class="chart-container">
        <h4>Event Summary</h4>
        <!-- Insert a bar chart here for event summary -->
    </div>

    <div class="chart-container mt-4">
        <h4>Attendee Analytics</h4>
        <!-- Insert a pie chart here for attendee analytics -->
    </div>

    <div class="chart-container mt-4">
        <h4>Event Performance</h4>
        <!-- Insert a bar chart here for event performance -->
    </div>

    <div class="chart-container mt-4">
        <h4>Revenue Report</h4>
        <!-- Insert a line chart here for revenue trends -->
    </div>

    <!-- Export Button -->
    <div class="text-end mb-3">
        <a href="generate_report.php?type=summary" class="btn btn-success">Export Event Summary</a>
        <a href="generate_report.php?type=attendance" class="btn btn-success">Export Attendance Data</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
