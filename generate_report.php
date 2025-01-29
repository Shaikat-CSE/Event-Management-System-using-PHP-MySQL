<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feature Coming Soon - Event Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('assets/images/generate-report.jpg') no-repeat center center fixed;
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
        .container {
            margin-top: 100px;
            text-align: center;
        }
        .btn-custom {
            background-color: #2196f3;
            color: white;
            border: none;
        }
        .btn-custom:hover {
            background-color: #1976d2;
        }
        .coming-soon-message {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
        }
        .description {
            font-size: 1.2rem;
            color: #555;
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
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Coming Soon Section -->
<div class="container">
    <h1 class="coming-soon-message">Feature Coming Soon!</h1>
    <p class="description">We are currently working on this feature. Stay tuned for updates!</p>
    <a href="dashboard.php" class="btn btn-custom mt-4">Back to Dashboard</a>
</div>

</body>
</html>
