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
<link rel="stylesheet" href="css/about.css">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="logo">QuizFusion</div>

    <ul class="nav-links">
        <li><a href="homepage.php">Home</a></li>
        <li><a href="about.php" class="active">About</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="categories.php">Categories</a></li>
        <li><a href="feedback.php">Feedback</a></li>
        <li><a href="leaderboard.php">Leaderboard</a></li>
        <li><a href="user_report.php">User Report</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>

    <div class="nav-user">
        <span class="email-text">Hello 👋<?= htmlspecialchars($user_email) ?></span>
        <a href="profile.php" class="profile-btn">Profile</a>
    </div>
</nav>

<!-- MAIN CONTENT -->
<div class="container">
    <h1 class="section-title">About QuizFusion</h1>

    <p>
        QuizFusion is your ultimate platform for interactive quizzes and knowledge challenges.
        Whether you want to sharpen your general knowledge, improve your technical skills,
        or test your logic and reasoning, QuizFusion offers a variety of categories designed
        for learners of all levels.
    </p>

    <p>
        Our mission is to make learning fun and engaging, allowing users to compete,
        track their progress, and challenge themselves with new quizzes every day.
        We aim to create a vibrant community where knowledge meets entertainment.
    </p>

    <p>
        Join us and explore the world of quizzes, gain new skills,
        and enjoy the thrill of testing your knowledge!
    </p>
</div>

<!-- FOOTER -->
<footer>
    © <?= date("Y") ?> QuizFusion | All Rights Reserved
</footer>

</body>
</html>
