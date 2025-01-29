<?php
require 'config.php';

if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    $stmt = $conn->prepare("SELECT users.name, users.email FROM event_registrations 
                            JOIN users ON event_registrations.user_id = users.id 
                            WHERE event_registrations.event_id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();

    header("Content-Type: text/csv");
    header("Content-Disposition: attachment; filename=attendees.csv");

    $output = fopen("php://output", "w");
    fputcsv($output, ['Name', 'Email']);

    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }

    fclose($output);
    exit;
}
?>
