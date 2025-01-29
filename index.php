<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Welcome to Event Management System</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background: url('assets/images/index.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Arial', sans-serif;
            position: relative;
            overflow: hidden;
        }
        .welcome-container {
            background: rgba(255, 255, 255, 0.57);
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 500px;
            width: 100%;
            z-index: 1;
            transition: transform 0.3s ease, background 0.3s ease;
        }
        .welcome-container:hover {
            transform: scale(1.05);
            background: rgb(255, 255, 255);
        }
        .welcome-container h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color:rgb(76, 116, 175);
        }
        .welcome-container p {
            font-size: 1.1rem;
            color: #555;
            margin-bottom: 30px;
        }
        .btn-custom {
            padding: 10px 20px;
            font-size: 1.1rem;
            border-radius: 30px;
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            transform: scale(1.05);
        }
        .btn-register {
            background:rgb(76, 116, 175);
            color: white;
            border: none;
        }
        .btn-register:hover {
            background:rgb(76, 116, 175);
        }
        .btn-login {
            background: white;
            color:rgb(76, 116, 175);
            border: 2px rgb(76, 116, 175);
        }
        .btn-login:hover {
            background:rgb(76, 116, 175);
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <h1>Welcome to Event Management</h1>
        <p>Manage your events effortlessly with our modern system. Join us to create, register, and manage events like never before!</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="register.php" class="btn btn-custom btn-register">Register</a>
            <a href="login.php" class="btn btn-custom btn-login">Login</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>