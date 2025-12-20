<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $con->prepare("SELECT email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($useremail);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>QuizFusion | Categories</title>

<!-- CSS -->
<link rel="stylesheet" href="css/categories.css">

</head>

<body>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="logo">QuizFusion</div>

    <button class="menu-toggle" id="menuToggle">☰</button>

    <ul class="nav-links" id="navLinks">
        <li><a href="homepage.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="categories.php" class="active">Categories</a></li>
        <li><a href="feedback.php">Feedback</a></li>
        <li><a href="leaderboard.php">Leaderboard</a></li>
        <li><a href="user_report.php">User Report</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>

    <div class="nav-user">
        <span class="email-text">Hello 👋 <?= htmlspecialchars($useremail) ?></span>
        <a href="profile.php" class="profile-btn">Profile</a>
    </div>
</nav>

<!-- MAIN -->
<main class="main-container">
    <h1 class="section-title">Select a Quiz Category</h1>

    <div class="categories">
        <div class="card">
            <div class="icon">🎧</div>
            <h3>Audio Quiz</h3>
            <p>Guess the sound or voice.</p>
            <a href="audio.php" class="cat-btn">Start</a>
        </div>

        <div class="card">
            <div class="icon">🖼</div>
            <h3>Pictionary</h3>
            <p>Guess the object shown.</p>
            <a href="pictionary.php" class="cat-btn">Start</a>
        </div>

        <div class="card">
            <div class="icon">📘</div>
            <h3>General Knowledge</h3>
            <p>Test your awareness.</p>
            <a href="gk.php" class="cat-btn">Start</a>
        </div>

        <div class="card">
            <div class="icon">💻</div>
            <h3>Technical Quiz</h3>
            <p>Programming & tech.</p>
            <a href="technical.php" class="cat-btn">Start</a>
        </div>

        <div class="card">
            <div class="icon">🧠</div>
            <h3>Maths & Logic</h3>
            <p>Puzzles & reasoning.</p>
            <a href="math_logic.php" class="cat-btn">Start</a>
        </div>
    </div>
</main>

<footer>
    © 2025 QuizFusion | All Rights Reserved
</footer>

<!-- JS -->
<script src="js/categories.js"></script>

</body>
</html>
