<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require 'config.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    // Update attendee details
    $stmt = $conn->prepare("UPDATE attendees SET name = ?, email = ? WHERE id = ?");
    $stmt->bind_param('ssi', $name, $email, $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Attendee updated successfully!";
    } else {
        $_SESSION['message'] = "Failed to update attendee.";
    }

    header("Location: attendees.php");
    exit;
} else {
    header("Location: attendees.php");
    exit;
}
?>
