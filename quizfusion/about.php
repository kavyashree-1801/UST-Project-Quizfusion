<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = intval($_SESSION['user_id']);
$stmt = $con->prepare("SELECT email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$user_email = $user['email'] ?? "";
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>QuizFusion | About Us</title>
<style>
:root {
    --brand:#1a73e8;
    --card:#ffffff;
}
*{box-sizing:border-box;}

/* BODY AS FLEX CONTAINER */
body {
    margin:0;
    font-family:'Poppins',sans-serif;
    background: url('https://media.istockphoto.com/id/1221653457/photo/close-up-of-a-touchscreen-social-media-concept.jpg?s=612x612&w=0&k=20&c=thcgiLGWFoRNMrMiDXDGUGPy50i9jhXhiHSy-vokyqI=') center/cover fixed;
    min-height:100vh;
    display:flex;
    flex-direction:column;
}

/* NAVBAR */
nav{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:14px 28px;
    background:var(--brand);
    color:white;
}
nav .logo{font-weight:700;font-size:20px;}
.nav-links{display:flex;gap:20px; list-style:none; padding:0; margin:0; align-items:center;}
.nav-links a{color:white; text-decoration:none; font-weight:600;}
.nav-links a:hover{text-decoration:underline;}
.email-text{color:#ffeb3b;font-weight:600;}

/* MAIN CONTENT FLEXIBLE */
.container{
    max-width:1100px;
    width:100%;
    margin:28px auto;
    padding:28px;
    background: rgba(255,255,255,0.9);
    border-radius:10px;
    box-shadow:0 8px 30px rgba(2,6,23,0.08);
    flex:1; /* allows container to grow and push footer down */
}
h1.section-title{ text-align:center; margin:0 0 22px 0; color:var(--brand);}
p{font-size:16px; line-height:1.7; color:#333; text-align:justify;}

/* FOOTER FIXED AT BOTTOM */
footer{
    padding:12px;
    text-align:center;
    color:#ffffff;
    background:var(--brand);
}
</style>
</head>
<body>

<!-- NAVBAR -->
<nav>
    <div class="logo">QuizFusion</div>
    <ul class="nav-links">
        <li><a href="homepage.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="categories.php">Categories</a></li>
        <li><a href="feedback.php">Feedback</a></li>
        <li><a href="leaderboard.php">Leaderboard</a></li>
        <li><a href="user_report.php">User Report</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
    <div class="email-text">Hello👋<?= htmlspecialchars($user_email) ?></div>
</nav>

<!-- MAIN CONTENT -->
<div class="container">
    <h1 class="section-title">About QuizFusion</h1>
    <p>QuizFusion is your ultimate platform for interactive quizzes and knowledge challenges. Whether you want to sharpen your general knowledge, improve your technical skills, or test your logic and reasoning, QuizFusion offers a variety of categories designed for learners of all levels.</p>
    <p>Our mission is to make learning fun and engaging, allowing users to compete, track their progress, and challenge themselves with new quizzes every day. We aim to create a vibrant community where knowledge meets entertainment.</p>
    <p>Join us and explore the world of quizzes, gain new skills, and enjoy the thrill of testing your knowledge!</p>
</div>

<!-- FOOTER -->
<footer>
    © <?= date("Y") ?> QuizFusion | All Rights Reserved
</footer>

</body>
</html>
