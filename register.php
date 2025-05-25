<?php 
session_start();
require 'vendor/autoload.php';
include 'helpers/functions.php';

use Aries\MiniFrameworkStore\Models\User;
use Carbon\Carbon;

$user = new User();

if(isset($_POST['submit'])) {
    $registered = $user->register([
        'name' => $_POST['full-name'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
        'created_at' => Carbon::now('Asia/Manila'),
        'updated_at' => Carbon::now('Asia/Manila')
    ]);
}

if(isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | France Adolf P. Borja</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .register-container {
            background: #ffffff;
            padding: 60px 50px;
            border-radius: 18px;
            width: 100%;
            max-width: 540px;
            box-shadow: 0 30px 60px rgba(0,0,0,0.4);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 800;
            color: #2c3e50;
        }

        .form-control {
            border-radius: 10px;
            padding: 14px;
            font-size: 1rem;
        }

        .btn-register {
            background: #2980b9;
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 10px;
            padding: 14px;
            margin-top: 15px;
            width: 100%;
            transition: 0.3s ease-in-out;
        }

        .btn-register:hover {
            background: #1f6390;
        }

        .login-link {
            margin-top: 25px;
            text-align: center;
            font-size: 0.95rem;
            color: #555;
        }

        .login-link a {
            color: #2980b9;
            font-weight: 600;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .alert {
            text-align: center;
            padding: 10px 15px;
            font-size: 0.95rem;
            margin-bottom: 20px;
        }

        @media (max-width: 600px) {
            .register-container {
                padding: 40px 25px;
            }
        }
    </style>
</head>
<body>

<div class="register-container">
    <h2>Create Your Account</h2>

    <?php if (isset($registered) && $registered): ?>
        <div class="alert alert-success">
            You have successfully registered! You may now <a href="login.php">login</a>.
        </div>
    <?php endif; ?>

    <form action="register.php" method="POST">
        <div class="mb-3">
            <label for="full-name" class="form-label">Full Name</label>
            <input name="full-name" type="text" class="form-control" placeholder="Juan Dela Cruz" required>
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input name="email" type="email" class="form-control" placeholder="you@example.com" required>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input name="password" type="password" class="form-control" placeholder="Choose a password" required>
        </div>
        <button type="submit" name="submit" class="btn btn-register">Register</button>
    </form>

    <div class="login-link">
        Already have an account? <a href="login.php">Login here</a>
    </div>
</div>

</body>
</html>
