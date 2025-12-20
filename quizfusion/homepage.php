<?php
session_start();
include 'config.php';

/* -------- AUTH & ROLE -------- */
$isLoggedIn = isset($_SESSION['user_id']);

if ($isLoggedIn) {
    $user_id = (int) $_SESSION['user_id'];
    $stmt = $con->prepare("SELECT email, role FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($useremail, $role);
    $stmt->fetch();
    $stmt->close();
} else {
    $useremail = "Guest";
    $role = "guest";
}

/* -------- GREETING -------- */
$hour = date("H");
if ($hour < 12) $greeting = "Good Morning";
elseif ($hour < 17) $greeting = "Good Afternoon";
else $greeting = "Good Evening";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>QuizFusion | Home</title>

<link rel="stylesheet" href="css/homepage.css">
</head>
<body>

<!-- ===== NAVBAR (ROLE BASED) ===== -->
<nav>
    <div class="logo">QuizFusion</div>

    <ul class="nav-links">
        <li><a href="homepage.php">Home</a></li>

        <?php if ($role === 'guest'): ?>

        <?php elseif ($role === 'user'): ?>
            <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="categories.php">Categories</a></li>
            <li><a href="feedback.php">Feedback</a></li>
            <li><a href="leaderboard.php">Leaderboard</a></li>
            <li><a href="user_report.php">User Report</a></li>
            <li><a href="logout.php">Logout</a></li>

        <?php else: /* admin */ ?>
            <li><a href="manage_contact.php">Manage Contact</a></li>
            <li><a href="manage_feedback.php">Manage Feedback</a></li>
            <li><a href="manage_leaderboard.php">Manage Leaderboard</a></li>
            <li><a href="manage_users.php">Manage Users</a></li>
            <li><a href="manage_quiz.php">Manage Quiz</a></li>
            <li><a href="logout.php">Logout</a></li>
        <?php endif; ?>
    </ul>

    <div class="right-section">
        <?php if ($role === 'guest'): ?>
            <span class="welcome-text">Welcome Guest</span>
            <a href="login.php" class="btn">Login</a>
            <a href="register.php" class="btn">Register</a>
        <?php else: ?>
            <span class="welcome-text">Hello 👋 <?= htmlspecialchars($useremail) ?></span>
            <a href="profile.php" class="btn">Profile</a>
        <?php endif; ?>
    </div>
</nav>

<!-- ===== MAIN ===== -->
<div class="main-container">
    <div class="hero-wrapper">
        <div class="hero">
            <h1><?= $greeting ?>, <?= htmlspecialchars($useremail) ?></h1>
            <p>
                <?php if ($role === 'guest'): ?>
                    Please login or register to start quizzes.
                <?php elseif ($role === 'user'): ?>
                    Ready for your next quiz challenge?
                <?php else: ?>
                    Manage quizzes, users and reports.
                <?php endif; ?>
            </p>

            <a class="start-btn"
               href="<?= $role === 'guest' ? 'login.php' : ($role === 'user' ? 'categories.php' : 'manage_quiz.php') ?>">
               <?= $role === 'guest' ? 'Login to Start' : ($role === 'user' ? 'Start Quiz' : 'Admin Panel') ?>
            </a>
        </div>
    </div>

    <div class="cards">
        <?php if ($role === 'guest'): ?>
            <div class="card"><div class="icon">🔒</div><div class="title">Login Required</div></div>
            <div class="card"><div class="icon">ℹ️</div><div class="title">About</div></div>
            <div class="card"><div class="icon">📝</div><div class="title">Register</div></div>

        <?php elseif ($role === 'user'): ?>
            <div class="card"><div class="icon">📘</div><div class="title">General Knowledge</div></div>
            <div class="card"><div class="icon">🎨</div><div class="title">Pictionary</div></div>
            <div class="card"><div class="icon">💻</div><div class="title">Technical</div></div>
            <div class="card"><div class="icon">🧠</div><div class="title">Maths & Logic</div></div>

        <?php else: ?>
            <div class="card"><div class="icon">👤</div><div class="title">Manage Users</div></div>
            <div class="card"><div class="icon">📚</div><div class="title">Manage Quiz</div></div>
            <div class="card"><div class="icon">🏆</div><div class="title">Leaderboard</div></div>
        <?php endif; ?>
    </div>
</div>

<footer>© 2025 QuizFusion | All Rights Reserved</footer>

<script src="js/homepage.js"></script>
</body>
</html>
