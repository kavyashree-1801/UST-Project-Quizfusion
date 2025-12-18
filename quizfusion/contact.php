<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = intval($_SESSION['user_id']);
$stmt = $con->prepare("SELECT email, role FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($useremail, $role);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact Us | QuizFusion</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/contact.css">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="logo">QuizFusion</div>

    <ul class="nav-links" id="navLinks">
        <li><a href="homepage.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="contact.php" class="active">Contact</a></li>
        <li><a href="categories.php">categories</a></li>
        <li><a href="feedback.php">Feedback</a></li>
        <li><a href="leaderboard.php">Leaderboard</a></li>
        <li><a href="user_report.php">User Report</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>

    <div class="nav-user">
        <span class="email-text">Hello 👋<?= htmlspecialchars($useremail) ?></span>
        <a href="profile.php" class="profile-btn">Profile</a>
    </div>
</nav>

<!-- CONTACT FORM -->
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg p-4">

                <h2 class="text-center text-primary mb-3">Contact Us</h2>

                <div id="msgBox" class="alert d-none"></div>

                <form id="contactForm" class="needs-validation" novalidate>

                    <div class="mb-3">
                        <label>Your Name</label>
                        <input type="text" name="name" class="form-control" required>
                        <div class="invalid-feedback">Name required</div>
                    </div>

                    <div class="mb-3">
                        <label>Your Email</label>
                        <input type="email" name="email" class="form-control"
                               value="<?= htmlspecialchars($useremail) ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label>Message</label>
                        <textarea name="message" class="form-control" rows="4" required></textarea>
                        <div class="invalid-feedback">Message required</div>
                    </div>

                    <button class="btn btn-primary w-100">Send Message</button>
                </form>

            </div>
        </div>
    </div>
</div>
<footer class=" bg-primary text-white text-center">
    © 2025 QuizFusion | All Rights Reserved
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/contact.js"></script>
</body>
</html>
