<?php
require 'config.php';

if (isset($_POST['attendee_name']) && isset($_POST['attendee_email']) && isset($_POST['event_id'])) {
    $attendee_name = $_POST['attendee_name'];
    $attendee_email = $_POST['attendee_email'];
    $event_id = $_POST['event_id'];

    // Check if the max capacity is reached
    $stmt = $conn->prepare("SELECT COUNT(*) AS total_attendees FROM attendees WHERE event_id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $total_attendees = $row['total_attendees'];

    // Fetch max capacity for the event
    $stmt = $conn->prepare("SELECT max_capacity FROM events WHERE id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $max_capacity = $row['max_capacity'];

    if ($total_attendees >= $max_capacity) {
        echo "Max capacity reached! Cannot add more attendees.";
    } else {
        // Add attendee to the database
        $stmt = $conn->prepare("INSERT INTO attendees (name, email, event_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $attendee_name, $attendee_email, $event_id);
        if ($stmt->execute()) {
            echo "Attendee added successfully!";
        } else {
            echo "Error adding attendee.";
        }
    }
}
?>
