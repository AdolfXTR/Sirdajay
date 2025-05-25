<?php 
session_start();
require 'vendor/autoload.php';
include 'helpers/functions.php';

use Aries\MiniFrameworkStore\Models\User;

$user = new User();

if(isset($_POST['submit'])) {
    $user_info = $user->login([
        'email' => $_POST['email'],
    ]);

    if($user_info && password_verify($_POST['password'], $user_info['password'])) {
        $_SESSION['user'] = $user_info;
        header('Location: my-account.php');
        exit;
    } else {
        $message = 'Invalid email or password';
    }
}

if(isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    header('Location: my-account.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | France Adolf P. Borja</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #0f2027, #203a43, #2c5364); /* BOLD DARK BLUES */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background: #ffffff;
            padding: 60px 50px;
            border-radius: 18px;
            width: 100%;
            max-width: 520px;
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

        .btn-login {
            background: #27ae60;
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 10px;
            padding: 14px;
            margin-top: 15px;
            width: 100%;
            transition: 0.3s ease-in-out;
        }

        .btn-login:hover {
            background: #219150;
        }

        .register-link {
            margin-top: 25px;
            text-align: center;
            font-size: 0.95rem;
            color: #555;
        }

        .register-link a {
            color: #27ae60;
            font-weight: 600;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .alert {
            text-align: center;
            padding: 10px 15px;
            font-size: 0.95rem;
            margin-bottom: 20px;
        }

        @media (max-width: 600px) {
            .login-container {
                padding: 40px 25px;
            }
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Login to Your Account</h2>

    <?php if (isset($message)): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input name="email" type="email" class="form-control" placeholder="you@example.com" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input name="password" type="password" class="form-control" placeholder="Your password" required>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember">
            <label class="form-check-label" for="remember">Remember me</label>
        </div>
        <button type="submit" name="submit" class="btn btn-login">Login</button>
    </form>

    <div class="register-link">
        Don't have an account? <a href="register.php">Register here</a>
    </div>
</div>

</body>
</html>
