<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    // Fetch event details
    $stmt = $conn->prepare("SELECT name, description, max_capacity, current_attendees FROM events WHERE id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $event = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$event) {
        echo "Event not found.";
        exit;
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];

        // Check if the event is full
        if ($event['current_attendees'] >= $event['max_capacity']) {
            $error = "This event has reached its maximum capacity.";
        } else {
            // Register attendee
            $stmt = $conn->prepare("INSERT INTO event_registrations (event_id, name, email) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $event_id, $name, $email);

            if ($stmt->execute()) {
                // Update current attendee count
                $stmt = $conn->prepare("UPDATE events SET current_attendees = current_attendees + 1 WHERE id = ?");
                $stmt->bind_param("i", $event_id);
                $stmt->execute();

                // Redirect to the dashboard with a success message
                $_SESSION['success_message'] = "You have successfully registered for the event!";
                header("Location: dashboard.php");
                exit;
            } else {
                $error = "Failed to register. Please try again.";
            }

            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Register for Event</title>
</head>
<body>
    <header>Event Management System - Register for Event</header>
    <div class="container">
        <h2>Register for: <?= htmlspecialchars($event['name']) ?></h2>
        <p><?= htmlspecialchars($event['description']) ?></p>
        <p><strong>Capacity:</strong> <?= $event['current_attendees'] ?>/<?= $event['max_capacity'] ?></p>

        <?php if (isset($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST">
            <label for="name">Your Name</label>
            <input type="text" name="name" id="name" placeholder="Enter your name" required>
            
            <label for="email">Your Email</label>
            <input type="email" name="email" id="email" placeholder="Enter your email" required>
            
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
