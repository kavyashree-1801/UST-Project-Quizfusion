<?php
session_start();
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Forgot Password | QuizFusion</title>
<link rel="stylesheet" href="css/forgot_password.css">
</head>
<body>

<div class="box">
    <h2>Forgot Password</h2>
    <div id="error" class="error"></div>

    <div id="stepEmail">
        <input type="email" id="email" placeholder="Enter Email" required>
        <button type="button" id="nextBtn">Next</button>
    </div>
</div>

<script src="js/forgot_password.js"></script>
</body>
</html>
