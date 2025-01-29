<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require 'config.php';

if (isset($_GET['id'])) {
    $attendee_id = $_GET['id'];

    // Delete attendee from the database
    $stmt = $conn->prepare("DELETE FROM attendees WHERE id = ?");
    $stmt->bind_param("i", $attendee_id);
    $stmt->execute();

    // Redirect back to the attendees page
    header("Location: attendees.php");
    exit;
} else {
    // Redirect if no ID is passed
    header("Location: attendees.php");
    exit;
}
?>
