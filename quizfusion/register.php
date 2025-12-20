<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register | QuizFusion</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/register.css">
</head>

<body class="d-flex justify-content-center align-items-center min-vh-100">

<div class="card register-card shadow-lg p-4">
<h4 class="text-center mb-3">Create Account</h4>

<div id="msgBox" class="alert d-none"></div>

<form id="registerForm" novalidate>

<input class="form-control mb-3" name="name" placeholder="Full Name" required>

<input class="form-control mb-3" type="email" name="email" placeholder="Email" required>

<!-- PASSWORD -->
<div class="mb-2 position-relative">
<input class="form-control" type="password" id="password" name="password" placeholder="Password" required>
<span class="eye" id="togglePassword">👁</span>
</div>

<!-- STRENGTH -->
<div class="progress mb-3">
  <div id="strengthBar" class="progress-bar"></div>
</div>

<!-- CONFIRM PASSWORD -->
<div class="mb-3 position-relative">
<input class="form-control" type="password" id="confirm_password" placeholder="Confirm Password" required>
<span class="eye" id="toggleConfirm">👁</span>
</div>

<!-- SECURITY QUESTION -->
<div class="mb-3">
    <label for="security_question" class="form-label">Security Question</label>
    <select name="security_question" id="security_question" class="form-select" required>
        <option value="">-- Select a security question --</option>
        <option value="What is your pet's name?">What is your pet's name?</option>
        <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
        <option value="What was your first school?">What was your first school?</option>
        <option value="What is your favorite color?">What is your favorite color?</option>
    </select>
</div>


<!-- SECURITY ANSWER -->
<div class="mb-3">
  <label for="security_answer" class="form-label fw-bold">Security Answer</label>
  <input class="form-control" type="text" id="security_answer" name="security_answer" placeholder="Enter the answer" required>
</div>

<!-- CAPTCHA -->
<div class="mb-1 fw-bold">
CAPTCHA: <span id="captchaQuestion" class="text-warning"></span>
</div>

<input class="form-control mb-3" type="number" name="captcha" placeholder="Enter CAPTCHA" required>

<button class="btn btn-success w-100">Register</button>

</form>

<!-- ✅ LOGIN LINK -->
<div class="text-center mt-3">
    Already have an account?
    <a href="login.php" class="fw-semibold text-decoration-none">Login</a>
</div>

</div>

<script src="js/register.js"></script>
</body>
</html>
