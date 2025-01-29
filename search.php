<?php
require 'config.php';

if (isset($_GET['query'])) {
    $query = "%" . $_GET['query'] . "%";

    $stmt = $conn->prepare("SELECT * FROM events WHERE name LIKE ? OR description LIKE ?");
    $stmt->bind_param("ss", $query, $query);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($event = $result->fetch_assoc()) {
        echo "<div style='margin: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 4px;'>
                <h3>" . htmlspecialchars($event['name']) . "</h3>
                <p>" . htmlspecialchars($event['description']) . "</p>
              </div>";
    }

    $stmt->close();
}
?>
