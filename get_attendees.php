<?php
require 'config.php';

if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    $stmt = $conn->prepare("SELECT * FROM attendees WHERE event_id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $attendees = [];
    while ($row = $result->fetch_assoc()) {
        $attendees[] = $row;
    }

    echo json_encode($attendees);
}
?>
