<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['event_name'];
    $description = $_POST['event_desc'];
    $event_date = $_POST['event_date'];
    $max_capacity = $_POST['max_capacity'];

    // Insert event into the database
    $stmt = $conn->prepare("INSERT INTO events (event_name, event_desc, event_date, max_capacity, current_attendees, created_by) VALUES (?, ?, ?, ?, 0, ?)");
    $stmt->bind_param("sssii", $name, $description, $event_date, $max_capacity, $_SESSION['user_id']); // Assuming user_id is stored in session

    if ($stmt->execute()) {
        $_SESSION['message'] = "Event added successfully!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Failed to add event. Please try again.";
        $_SESSION['message_type'] = "danger";
    }

    $stmt->close();
    $conn->close();

    header("Location: events.php");
    exit;
}
?>
