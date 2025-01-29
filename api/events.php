<?php
require '../config.php';

header('Content-Type: application/json');

$result = $conn->query("SELECT * FROM events");
$events = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($events);
?>
