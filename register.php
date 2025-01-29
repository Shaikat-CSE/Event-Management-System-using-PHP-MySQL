<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Register - Event Management</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background: url('assets/images/register.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Arial', sans-serif;
            position: relative;
            overflow: hidden;
        }
        .form-container {
            background: rgba(255, 255, 255, 0.73);
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
            transition: transform 0.3s ease, background 0.3s ease;
        }
        .form-container:hover {
            transform: scale(1.05);
            background: rgba(255, 255, 255, 0.9);
        }
        .form-container h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            color:rgb(0, 140, 255);
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
        .btn-register {
            background:rgb(0, 140, 255);
            color: white;
            border: none;
        }
        .btn-register:hover {
            background:rgb(0, 140, 255);
        }
        .btn-home {
            background: #fff;
            color:rgb(0, 140, 255);
            border: 2px solidrgb(0, 140, 255);
            margin-top: 10px;
        }
        .btn-home:hover {
            background: #f9f9f9;
        }
        .login-link {
            margin-top: 20px;
            display: block;
            color:rgb(0, 140, 255);
            font-weight: bold;
        }
        .login-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Register</h2>
        <form action="register_process.php" method="POST">
            <div class="mb-3">
                <label for="name">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
            </div>
            <div class="mb-3">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="mb-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn btn-custom btn-register">Register</button>
        </form>
        <a href="index.php" class="btn btn-custom btn-home">Home</a>
        <a href="login.php" class="login-link">Already have an account? Login</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>