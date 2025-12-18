<?php
session_start();
if(!isset($_SESSION['forgot_email'])){
    header("Location: forgot_password.php");
    exit;
}
$email = $_SESSION['forgot_email'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Verify Security Question | QuizFusion</title>
<link rel="stylesheet" href="css/forgot_password.css">
</head>
<body>

<div class="box">
    <h2>Security Question</h2>
    <div id="error" class="error"></div>

    <p><b>Security Question:</b><br><span id="questionText"></span></p>
    <div class="input-group" style="position:relative;">
        <input type="password" id="answer" placeholder="Enter Security Answer">
        <span id="toggleAnswer" class="toggle-pass">👁</span>
    </div>
    <button type="button" id="verifyBtn">Verify</button>
</div>

<script src="js/verify_security.js"></script>
</body>
</html>
