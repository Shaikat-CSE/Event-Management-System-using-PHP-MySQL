<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require 'config.php'; // Database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Dashboard - Event Management</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url('assets/images/dashboard.jpg') no-repeat center center fixed;
            background-size: cover;
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
            font-size: 1.1rem;
        }
        .hero-section {
            background: rgba(22, 30, 37, 0.4);
            color: white;
            padding: 50px 20px;
            text-align: center;
        }
        .hero-section h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        .hero-section p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }
        .hero-section .btn {
            background-color: #fff;
            color: #2196f3;
            border: none;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 25px;
        }
        .hero-section .btn:hover {
            background-color: #f4f4f4;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card img {
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }
        .card-body {
            text-align: center;
        }
        .card-title {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #2196f3;
        }
        .card-text {
            font-size: 1rem;
            color: #555;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="#">Event Management</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="logout_process.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<div class="hero-section">
    <h1>Welcome to Your Dashboard</h1>
    <p>Manage your events, attendees, and reports effortlessly.</p>
    <a href="events.php" class="btn">Get Started</a>
</div>

<!-- Dashboard Features -->
<div class="container my-5">
    <div class="row g-4">
        <!-- Manage Events -->
        <div class="col-md-4">
            <div class="card">
                <img src="assets/images/events.jpg" class="card-img-top" alt="Manage Events">
                <div class="card-body">
                    <h5 class="card-title">Manage Events</h5>
                    <p class="card-text">Create, update, and delete events with ease.</p>
                    <a href="events.php" class="btn btn-primary">Go to Events</a>
                </div>
            </div>
        </div>
        <!-- Manage Attendees -->
        <div class="col-md-4">
            <div class="card">
                <img src="assets/images/attendees.jpg" class="card-img-top" alt="Manage Attendees">
                <div class="card-body">
                    <h5 class="card-title">Manage Attendees</h5>
                    <p class="card-text">View and manage event attendees efficiently.</p>
                    <a href="attendees.php" class="btn btn-primary">Go to Attendees</a>
                </div>
            </div>
        </div>
        <!-- Reports -->
        <div class="col-md-4">
            <div class="card">
                <img src="assets/images/reports.jpg" class="card-img-top" alt="Reports">
                <div class="card-body">
                    <h5 class="card-title">Generate Reports</h5>
                    <p class="card-text">Download event reports and attendee lists.</p>
                    <a href="reports.php" class="btn btn-primary">Go to Reports</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
