<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Get logged-in user email and role for navbar
$user_id = intval($_SESSION['user_id']);
$stmt = $con->prepare("SELECT email, role FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($useremail, $role);
$stmt->fetch();
$stmt->close();

// Fetch all users' quiz results
$stmt = $con->prepare("SELECT * FROM quiz_results ORDER BY taken_on DESC");
$stmt->execute();
$result = $stmt->get_result();
$scores = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>QuizFusion | Leaderboard</title>
<style>
:root{--brand:#1a73e8;--card:#ffffff;}

/* BODY WITH BACKGROUND IMAGE */
html, body{
    margin:0;
    padding:0;
    height:100%;
    font-family:Poppins,sans-serif;
    display:flex;
    flex-direction:column;
    background: url('https://thumbs.dreamstime.com/b/gaming-online-video-game-entertainment-funnel-icons-show-streaming-interactive-play-supports-esports-community-digital-408145830.jpg') no-repeat center center fixed;
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
nav .logo{font-weight:700;font-size:22px;}
.nav-links{display:flex;gap:18px;list-style:none;padding:0;margin:0;flex-wrap:wrap;}
.nav-links a{color:white;text-decoration:none;font-weight:600;}
.nav-links a:hover{text-decoration:underline;}
.email-text{color:#ffeb3b;font-weight:600;}

/* MAIN CONTENT */
.container{
    flex:1;
    padding:40px;
    max-width:1000px;
    margin:auto;
    background: rgba(255,255,255,0.95); /* semi-transparent white */
    border-radius:10px;
}
h1{text-align:center;margin-bottom:30px;color:var(--brand);}
table{
    width:100%;
    border-collapse:collapse;
    background:white;
    border-radius:10px;
    overflow:hidden;
    box-shadow:0 4px 12px rgba(0,0,0,0.1);
}
th, td{padding:12px 15px;text-align:center;border-bottom:1px solid #ddd;font-size:16px;}
th{background:var(--brand);color:white;}
tr:last-child td{border-bottom:none;}
tr:hover{background:#f1f5f9;}

/* FOOTER */
footer{
    background:var(--brand);
    color:white;
    text-align:center;
    padding:12px;
    margin-top:auto;
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
    <div class="email-text">Hello👋<?= htmlspecialchars($useremail) ?></div>
</nav>

<!-- MAIN CONTENT -->
<div class="container">
    <h1>Quiz Scores</h1>

    <?php if (count($scores) === 0): ?>
        <p style="text-align:center; font-size:18px;">No quiz attempts found.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>id</th>
                <th>User Email</th>
                <th>Quiz Name / Category</th>
                <th>Total Questions</th>
                <th>Score</th>
                <th>Date Taken</th>
            </tr>

            <?php foreach ($scores as $index => $row): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['category']) ?></td>
                <td><?= htmlspecialchars($row['total_questions']) ?></td>
                <td><?= htmlspecialchars($row['score']) ?></td>
                <td><?= htmlspecialchars($row['taken_on']) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>

<!-- FOOTER -->
<footer>
    © 2025 QuizFusion | All Rights Reserved
</footer>

</body>
</html>
