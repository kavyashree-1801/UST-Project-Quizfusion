<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = intval($_SESSION['user_id']);
$stmt = $con->prepare("SELECT email FROM users WHERE id=?");
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
<title>QuizFusion | Leaderboard</title>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/leaderboard.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <div class="logo">QuizFusion</div>
    <ul class="nav-links" id="navLinks">
        <li><a href="homepage.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="categories.php">Categories</a></li>
        <li><a href="feedback.php">Feedback</a></li>
        <li><a href="leaderboard.php" class="active">Leaderboard</a></li>
        <li><a href="user_report.php">User Report</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>

    <div class="nav-user">
        <span class="email-text">Hello 👋<?= htmlspecialchars($useremail) ?></span>
        <a href="profile.php" class="profile-btn">Profile</a>
    </div>
</nav>

<!-- Main Container -->
<div class="container my-5">
  <h1 class="text-center mb-4">Leaderboard</h1>

  <!-- Category Filter -->
  <div class="row mb-3">
    <div class="col-md-4 offset-md-4">
        <select id="categoryFilter" class="form-select">
          <option value="all">All Categories</option>
        </select>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table table-striped table-bordered" id="leaderboardTable">
      <thead class="table-primary">
        <tr>
          <th>#</th>
          <th>User Email</th>
          <th>Category</th>
          <th>Total Questions</th>
          <th>Score</th>
          <th>Date Taken</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>
</div>

<!-- Footer -->
<footer class="bg-primary text-white text-center py-3">
  © 2025 QuizFusion | All Rights Reserved
</footer>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/leaderboard.js"></script>
</body>
</html>
