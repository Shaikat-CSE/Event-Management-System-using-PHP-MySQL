<?php
require 'config.php';

if (isset($_POST['attendee_id']) && isset($_POST['event_id'])) {
    $attendee_id = $_POST['attendee_id'];
    $event_id = $_POST['event_id'];

    // Delete attendee from the event
    $stmt = $conn->prepare("DELETE FROM attendees WHERE id = ? AND event_id = ?");
    $stmt->bind_param("ii", $attendee_id, $event_id);
    $stmt->execute();

    echo "Attendee removed successfully!";
}
?>
