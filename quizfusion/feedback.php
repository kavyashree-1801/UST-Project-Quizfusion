<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to submit feedback.");
}

$user_id = intval($_SESSION['user_id']);

// Fetch email, name, and role
$stmt = $con->prepare("SELECT name, email, role FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $useremail, $role);
$stmt->fetch();
$stmt->close();

// Check for success message
$success = isset($_GET['success']) && $_GET['success'] == 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>QuizFusion | Feedback</title>
<style>
:root{--brand:#1a73e8;--card:#ffffff;}
html, body{
    margin:0;
    padding:0;
    height:100%;
    font-family:Poppins,sans-serif;
    display:flex;
    flex-direction:column;
    background: url('https://media.istockphoto.com/id/1356554393/photo/businessman-holding-smile-icon-for-the-best-evaluation-customer-satisfaction-concept.jpg?s=612x612&w=0&k=20&c=HXPwCqokplAtW8p8U2B9qLX2swWO5sPyrrA5a02TKDg=') no-repeat center center fixed;
    background-size: cover;
}

/* NAVBAR */
nav{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:14px 28px;
    background:var(--brand);
    color:white;
    flex-wrap:wrap;
}
nav .logo{font-weight:700;font-size:20px;}
.nav-links{display:flex;gap:20px;list-style:none;padding:0;margin:0;flex-wrap:wrap;}
.nav-links a{color:white;text-decoration:none;font-weight:600;}
.nav-links a:hover{text-decoration:underline;}
.email-text{color:#ffeb3b;font-weight:600;}

/* MAIN */
.main{
    flex:1;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:40px;
}
form{
    width:100%;
    max-width:500px;
    background: rgba(255,255,255,0.95);
    padding:30px;
    border-radius:12px;
    box-shadow:0 4px 12px rgba(0,0,0,0.15);
    display:flex;
    flex-direction:column;
}
h1{
    font-size:32px;
    margin-bottom:20px;
    color:var(--brand);
    text-align:center;
}
input, select, textarea{
    width:100%;
    padding:10px;
    margin-bottom:16px;
    border-radius:6px;
    border:1px solid #ccc;
    font-size:14px;
}
input[readonly]{
    background-color:#e9ecef;
    cursor:not-allowed;
}
button{
    background:var(--brand);
    color:#fff;
    border:none;
    padding:12px;
    border-radius:6px;
    font-size:16px;
    cursor:pointer;
    transition:0.3s;
}
button:hover{background:#155ab6;}
.success-msg{
    background:#d4edda;
    color:#155724;
    border:1px solid #c3e6cb;
    padding:12px;
    border-radius:8px;
    text-align:center;
    margin-bottom:20px;
}

/* FOOTER */
footer{
    background:var(--brand);
    color:white;
    text-align:center;
    padding:12px;
    flex-shrink:0;
}
</style>
</head>
<body>

<!-- NAVBAR -->
<nav>
    <div class="logo">QuizFusion</div>

    <ul class="nav-links">
        <?php if($role==='user'): ?>
            <li><a href="homepage.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="categories.php">Categories</a></li>
            <li><a href="feedback.php">Feedback</a></li>
            <li><a href="leaderboard.php">Leaderboard</a></li>
            <li><a href="user_report.php">User Report</a></li>
            <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
            <li><a href="homepage.php">Home</a></li>
            <li><a href="manage_users.php">Manage Users</a></li>
            <li><a href="manage_quiz.php">Manage Quiz</a></li>
            <li><a href="manage_leaderboard.php">Manage Leaderboard</a></li>
            <li><a href="contact_messages.php">Contact</a></li>
            <li><a href="feedback_list.php">Feedback</a></li>
            <li><a href="logout.php">Logout</a></li>
        <?php endif; ?>
    </ul>

    <!-- EMAIL + PROFILE BUTTON -->
    <div style="display:flex; align-items:center; gap:12px;">
        <div class="email-text">Hello👋<?= htmlspecialchars($useremail) ?></div>

        <a href="profile.php"
           style="
                background:white;
                color:#1a73e8;
                padding:6px 14px;
                border-radius:6px;
                font-weight:600;
                text-decoration:none;
                border:1px solid #fff;
                transition:0.3s;
           "
           onmouseover="this.style.background='#e2e2e2'"
           onmouseout="this.style.background='white'"
        >Profile</a>
    </div>
</nav>

<!-- MAIN FEEDBACK FORM -->
<div class="main">
    <form action="feedback_submit.php" method="post">
        <h1>Feedback</h1>

        <?php if($success): ?>
            <div class="success-msg">Thank you! Your feedback has been submitted.</div>
        <?php endif; ?>

        <input type="text" name="name" value="<?= htmlspecialchars($username) ?>" readonly>
        <input type="email" name="email" value="<?= htmlspecialchars($useremail) ?>" readonly>

        <select name="rating" required>
            <option value="">-- Select Rating --</option>
            <option value="5">Excellent</option>
            <option value="4">Very Good</option>
            <option value="3">Good</option>
            <option value="2">Average</option>
            <option value="1">Poor</option>
        </select>

        <textarea name="comments" rows="5" required placeholder="Share your feedback..."></textarea>

        <button type="submit">Submit Feedback</button>
    </form>
</div>

<!-- FOOTER -->
<footer>
    © 2025 QuizFusion | All Rights Reserved
</footer>

</body>
</html>
