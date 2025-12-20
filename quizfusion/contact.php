<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = (int)$_SESSION['user_id'];
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
<title>Contact | QuizFusion</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSS -->
<link rel="stylesheet" href="css/contact.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- ===== NAVBAR ===== -->
<nav class="navbar">
    <div class="logo">QuizFusion</div>

    <ul class="nav-links">
        <li><a href="homepage.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="contact.php" class="active">Contact</a></li>
        <li><a href="categories.php">Categories</a></li>
        <li><a href="feedback.php">Feedback</a></li>
        <li><a href="leaderboard.php">Leaderboard</a></li>
        <li><a href="user_report.php">User Report</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>

    <div class="nav-user">
        <span class="email-text">
            Hello 👋<?= htmlspecialchars($useremail) ?>
        </span>
        <a href="profile.php" class="profile-btn">Profile</a>
    </div>
</nav>

<!-- ===== CONTACT FORM ===== -->
<div class="container my-5 flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4 shadow">

                <h4 class="text-center mb-3">Contact Us</h4>

                <div id="msgBox" class="alert d-none"></div>

                <form id="contactForm">

                    <input type="text"
                           name="name"
                           id="name"
                           class="form-control mb-3"
                           placeholder="Your Name"
                           required>

                    <input type="email"
                           name="email"
                           id="email"
                           class="form-control mb-3"
                           value="<?= htmlspecialchars($useremail) ?>"
                           readonly>

                    <textarea name="message"
                              id="message"
                              class="form-control mb-3"
                              placeholder="Your Message"
                              required></textarea>

                    <button type="submit" class="btn btn-primary w-100">
                        Send Message
                    </button>

                </form>

            </div>
        </div>
    </div>
</div>

<!-- ===== FOOTER (NEW) ===== -->
<footer class="site-footer">
    <p>© <?= date('Y') ?> QuizFusion | All Rights Reserved.</p>
</footer>

<!-- JS -->
<script src="js/contact.js"></script>
</body>
</html>
