<?php
session_start();
require 'config.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get user inputs from the registration form
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $email = $_POST['email'];

    // Prepare and execute the query to insert the new user
    $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $email);

    if ($stmt->execute()) {
        echo "Account created successfully!";
        // Redirect to login page after successful registration
        header("Location: login.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
