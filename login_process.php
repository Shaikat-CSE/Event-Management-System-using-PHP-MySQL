<?php
session_start();
require 'config.php';  // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the user exists in the database
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    if ($user && password_verify($password, $user['password'])) {
        // Correct password, create session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $email;
        
        // Redirect to dashboard
        header("Location: dashboard.php");
        exit;
    } else {
        // Invalid credentials
        $error = "Invalid email or password.";
    }
    $stmt->close();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Login - Event Management</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #2196f3, #64b5f6);
            font-family: 'Arial', sans-serif;
        }
        .form-container {
            background: #fff;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        .form-container h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #2196f3;
        }
        .form-container label {
            float: left;
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
        }
        .form-container .btn-custom {
            padding: 10px 20px;
            font-size: 1.1rem;
            border-radius: 30px;
            transition: all 0.3s ease;
            margin-top: 15px;
        }
        .btn-login {
            background: #2196f3;
            color: white;
            border: none;
        }
        .btn-login:hover {
            background: #1e88e5;
        }
        .error-message {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Login</h2>
        <?php if (isset($error)): ?>
            <p class="error-message"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form action="login_process.php" method="POST">
            <div class="mb-3">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="mb-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn btn-custom btn-login">Login</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
