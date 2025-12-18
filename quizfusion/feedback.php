<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = intval($_SESSION['user_id']);

// Fetch name, email, role
$stmt = $con->prepare("SELECT name, email, role FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $useremail, $role);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>QuizFusion | Feedback</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/feedback.css">
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
        <li><a href="feedback.php" class="active">Feedback</a></li>
        <li><a href="leaderboard.php">Leaderboard</a></li>
        <li><a href="user_report.php">User Report</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
    <div class="nav-user">
        <span class="email-text">Hello 👋<?= htmlspecialchars($useremail) ?></span>
        <a href="profile.php" class="profile-btn">Profile</a>
    </div>
</nav>

<!-- Feedback Form -->
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-14">
            <div class="card shadow-lg p-4">
                <h2 class="text-center mb-4 text-primary">Feedback</h2>
                <form id="feedbackForm" novalidate>
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($username) ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" value="<?= htmlspecialchars($useremail) ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <select name="rating" id="rating" class="form-select" required>
                            <option value="">-- Select Rating --</option>
                            <option value="5">Excellent</option>
                            <option value="4">Very Good</option>
                            <option value="3">Good</option>
                            <option value="2">Average</option>
                            <option value="1">Poor</option>
                        </select>
                        <div class="invalid-feedback">Please select a rating.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Comments</label>
                        <textarea name="comments" id="comments" rows="5" class="form-control" placeholder="Share your feedback..." required></textarea>
                        <div class="invalid-feedback">Comments cannot be empty.</div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Submit Feedback</button>
                </form>
                <div id="successMsg" class="alert alert-success mt-3 d-none">
                    Thank you! Your feedback has been submitted.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-primary text-white text-center py-3">
    © 2025 QuizFusion | All Rights Reserved
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/feedback.js"></script>
</body>
</html>
