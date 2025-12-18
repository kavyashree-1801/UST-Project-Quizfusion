<?php 
session_start();
if(!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Include database connection
include 'config.php'; // make sure $con is defined

$user_id = intval($_SESSION['user_id']);

// Fetch user email and name
$stmt = $con->prepare("SELECT email, name FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows === 0){
    session_destroy();
    header('Location: login.php');
    exit;
}

$user = $result->fetch_assoc();
$useremail = $user['email'];
$username = $user['name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>QuizFusion | Profile</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/profile.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav>
    <div class="logo">QuizFusion</div>

    <ul class="nav-links" id="navLinks">
        <li><a href="homepage.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="categories.php">Categories</a></li>
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

<div class="main">
    <div class="card">
        <h1>My Profile</h1>

        <div class="success-msg" id="successMsg"></div>
        <div class="error-msg" id="errorMsg"></div>

        <!-- Profile Form -->
        <label>Name:</label>
        <input type="text" id="name" value="<?= htmlspecialchars($username) ?>" required>

        <label>Email:</label>
        <input type="email" id="email" value="<?= htmlspecialchars($useremail) ?>" required>

        <button id="updateProfile">Update Profile</button>

        <hr>

        <label>Old Password:</label>
        <div class="pass-wrapper">
            <input type="password" id="old_password" placeholder="Old Password">
            <span class="toggle-pass" onclick="togglePass('old_password', this)">👁</span>
        </div>

        <label>New Password:</label>
        <div class="pass-wrapper">
            <input type="password" id="new_password" placeholder="New Password">
            <span class="toggle-pass" onclick="togglePass('new_password', this)">👁</span>
        </div>

        <button id="updatePassword">Update Password</button>
    </div>
</div>

<footer>© <?= date('Y') ?> QuizFusion</footer>

<script src="js/profile.js"></script>
</body>
</html>
