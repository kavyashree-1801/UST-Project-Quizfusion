<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>QuizFusion | Login</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link rel="stylesheet" href="css/login.css">
</head>

<body class="d-flex justify-content-center align-items-center min-vh-100">

<div class="card shadow login-card p-4">
    <h3 class="text-center mb-3">Login</h3>

    <div id="errorBox" class="alert alert-danger d-none"></div>

    <form id="loginForm" class="needs-validation" novalidate>

        <!-- EMAIL -->
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
            <div class="invalid-feedback">Enter a valid email</div>
        </div>

        <!-- PASSWORD -->
        <div class="mb-2 position-relative">
            <label class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required minlength="6">
            <span id="togglePassword">👁</span>
            <div class="invalid-feedback">Minimum 6 characters</div>
        </div>

        <!-- FORGOT PASSWORD -->
        <div class="text-end mb-3">
            <a href="forgot_password.php" class="text-decoration-none small fw-semibold">
                Forgot password?
            </a>
        </div>

        <!-- CAPTCHA -->
        <div class="mb-2 fw-bold">
            CAPTCHA: <span id="captchaQuestion" class="text-primary"></span>
        </div>

        <div class="mb-3">
            <input type="number" name="captcha" class="form-control" required>
            <div class="invalid-feedback">Solve CAPTCHA</div>
        </div>

        <button class="btn btn-primary w-100">Login</button>
    </form>

    <!-- REGISTER -->
    <div class="text-center mt-4">
        <span class="text-muted">New User?</span>
        <a href="register.php" class="fw-semibold text-decoration-none">
            Create an account
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/login.js"></script>
</body>
</html>
