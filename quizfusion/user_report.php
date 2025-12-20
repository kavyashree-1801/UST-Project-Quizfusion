<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = intval($_SESSION['user_id']);
include 'config.php';

// Fetch user email for navbar
$stmt = $con->prepare("SELECT email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();
$user_email = $user['email'] ?? "";
$stmt->close();
$con->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>QuizFusion | User Report</title>
<link rel="stylesheet" href="css/user_report.css">
</head>
<body>

<!-- NAVBAR -->
<nav>
    <div class="logo">QuizFusion</div>
    <ul class="nav-links">
        <li><a href="homepage.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="categories.php">categories</a></li>
        <li><a href="feedback.php">Feedback</a></li>
        <li><a href="leaderboard.php">Leaderboard</a></li>
        <li><a href="user_report.php"class="active">User Report</a></li>
        <li><a href="logout.php">Logout</a></li> 
    </ul>
    <div class="nav-user">
    <span class="email-text">Hello 👋 <?= htmlspecialchars($user_email) ?></span>
    <a href="profile.php" class="profile-btn">Profile</a>
</div>

</div>

</nav>

<!-- MAIN CONTENT -->
<div class="container">
    <h2 class="section-title">User Report</h2>

    <div class="cards">
        <div class="card">
            <h3>Total Quizzes Attempted</h3>
            <p id="totalQuizzes">0</p>
        </div>
        <div class="card">
            <h3>Top Category</h3>
            <p id="topCategory">—</p>
        </div>
        <div class="card">
            <h3>Latest Score</h3>
            <p id="latestScore">—</p>
        </div>
        <div class="card">
            <h3>Highest Score</h3>
            <p id="highestScore">—</p>
        </div>
    </div>

    <div class="flex-row">
        <div class="chart-box">
            <h3>Category Distribution</h3>
            <canvas id="pieChart" width="400" height="400"></canvas>
        </div>

        <div class="table-box">
            <h3>Latest Attempts</h3>
            <table>
                <thead>
                    <tr>
                        <th>Quiz ID</th>
                        <th>Category</th>
                        <th>Score</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody id="attemptTable">
                </tbody>
            </table>
        </div>
    </div>
</div>

<footer>© <?= date("Y") ?> QuizFusion | All Rights Reserved</footer>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="js/user_report.js"></script>
</body>
</html>
