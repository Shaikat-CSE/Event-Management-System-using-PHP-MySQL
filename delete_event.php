<?php
require 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    $stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
    $stmt->bind_param("i", $event_id);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>
