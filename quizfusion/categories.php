<?php
session_start();
require 'config.php';

// CHECK LOGIN
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// FETCH USER EMAIL
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
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>QuizFusion | Categories</title>

<style>
:root {
    --brand:#1a73e8;
    --card:#ffffff;
    --bg-overlay: rgba(0,0,0,0.5);
}

*{box-sizing:border-box;}
html, body{
    margin:0;
    padding:0;
    font-family: 'Poppins', sans-serif;
    min-height:100%;
    display:flex;
    flex-direction:column;
    background: url('https://img.freepik.com/free-vector/flat-national-science-day-background_23-2149283132.jpg?semt=ais_hybrid&w=740&q=80') center/cover fixed;
    color:#111827;
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
nav .logo{font-weight:700; font-size:20px;}
.nav-links{display:flex; gap:20px; list-style:none; padding:0; margin:0; flex-wrap:wrap;}
.nav-links a{color:white; text-decoration:none; font-weight:600;}
.nav-links a:hover{text-decoration:underline;}
.email-text{color:#ffeb3b; font-weight:600;}

/* MAIN */
.main-container{
    background: var(--bg-overlay);
    padding: 28px;
    border-radius: 15px;
    max-width: 1200px;
    margin: 28px auto;
    backdrop-filter: blur(3px);
    color:#fff;
    flex:1; /* Makes container grow to fill space */
}

/* Horizontal categories (wrap instead of scroll) */
.categories{
    display:flex;
    gap:20px;
    flex-wrap:wrap;
    justify-content:center;
    margin-top:20px;
}

.card{
    background: var(--card);
    color:#000;
    padding:22px;
    border-radius:14px;
    text-align:center;
    width:260px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.25);
    transition:0.3s;
}
.card:hover { transform:translateY(-5px); }
.icon{ font-size:42px; margin-bottom:10px; }
.cat-btn{
    background: var(--brand);
    color:#fff;
    padding:8px 14px;
    border-radius:10px;
    text-decoration:none;
    font-weight:600;
    display:inline-block;
}
h1.section-title{ text-align:center; margin-bottom:28px; color:#fff; }

/* FOOTER FIXED TO BOTTOM */
footer{
    background: var(--brand);
    padding:12px;
    text-align:center;
    color:white;
    flex-shrink:0;
}
</style>
</head>

<body>

<!-- NAVBAR -->
<nav>
    <div class="logo">QuizFusion</div>
    <ul class="nav-links">
        <li><a href="homepage.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="categories.php">Categories</a></li>
        <li><a href="feedback.php">Feedback</a></li>
        <li><a href="leaderboard.php">Leaderboard</a></li>
        <li><a href="user_report.php">User Report</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
    <div class="email-text"><?= htmlspecialchars($useremail) ?></div>
</nav>

<!-- MAIN CATEGORY SECTION -->
<div class="main-container">
    <h1 class="section-title">Select a Quiz Category</h1>
    <div class="categories">
        <div class="card">
            <div class="icon">🎧</div>
            <h3>Audio Quiz</h3>
            <p>Guess the sound or voice.</p>
            <a class="cat-btn" href="audio.php">Start</a>
        </div>
        <div class="card">
            <div class="icon">🖼</div>
            <h3>Pictionary</h3>
            <p>Guess the object shown in the pictures.</p>
            <a class="cat-btn" href="pictionary.php">Start</a>
        </div>
        <div class="card">
            <div class="icon">📘</div>
            <h3>General Knowledge</h3>
            <p>Test your overall awareness.</p>
            <a class="cat-btn" href="gk.php">Start</a>
        </div>
        <div class="card">
            <div class="icon">💻</div>
            <h3>Technical Quiz</h3>
            <p>Programming and tech concepts.</p>
            <a class="cat-btn" href="technical.php">Start</a>
        </div>
        <div class="card">
            <div class="icon">🧠</div>
            <h3>Maths & Logic</h3>
            <p>Puzzles and logical challenges.</p>
            <a class="cat-btn" href="math_logic.php">Start</a>
        </div>
    </div>
</div>

<footer>
    © 2025 QuizFusion | All Rights Reserved
</footer>

</body>
</html>
