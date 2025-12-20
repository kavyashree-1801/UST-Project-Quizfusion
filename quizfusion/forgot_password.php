<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Forgot Password | Quizfusion</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/forgot.css">
</head>
<body>

<div class="container">
    <h2>Forgot Password</h2>
    <p class="subtitle">Verify using your security question</p>

    <div class="error" id="error"></div>
    <div class="success" id="success"></div>

    <!-- STEP 1 -->
    <div id="step1">
        <input type="email" id="email" placeholder="Enter your email">
        <button type="button" onclick="getQuestion()">Next</button>
    </div>

    <!-- STEP 2 -->
    <div id="step2" style="display:none;">
        <p id="question" style="font-weight:bold;"></p>
        <input type="text" id="answer" placeholder="Your answer">

        <div class="password-box">
            <input type="password" id="newPassword" placeholder="New password">
            <span class="eye" onclick="togglePassword('newPassword')">👁</span>
        </div>

        <button type="button" onclick="resetPassword()">Reset Password</button>
    </div>

    <div class="links">
        <a href="login.php">Back to Login</a>
    </div>
</div>

<script src="js/forgot_password.js"></script>
</body>
</html>
