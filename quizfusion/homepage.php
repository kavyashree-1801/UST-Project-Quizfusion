<?php
session_start();
include 'config.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = intval($_SESSION['user_id']);

// Fetch user email and role
$stmt = $con->prepare("SELECT email, role FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($useremail, $role);
$stmt->fetch();
$stmt->close();

// Determine greeting
$hour = date("H");
if ($hour < 12) {
    $greeting = "Good Morning";
} elseif ($hour < 17) {
    $greeting = "Good Afternoon";
} else {
    $greeting = "Good Evening";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>QuizFusion | Home</title>

<style>
:root { --brand:#1a73e8; --card:#ffffff; }

html, body {
    margin:0;
    padding:0;
    font-family:'Poppins',sans-serif;

    /* 🔥 FULL PAGE BACKGROUND IMAGE */
    background: 
        linear-gradient(rgba(255,255,255,0.2), rgba(255,255,255,0.2)),
        url('https://media.istockphoto.com/id/466873090/vector/education-icons-on-gray-background-pattern.jpg?s=612x612&w=0&k=20&c=q4fAGF4qsNXuCK39Q22y18L6DaJVVs3Gnqo8KDCFDNQ=') 
        center/cover no-repeat fixed;

    height:100%;
    overflow:hidden; /* REMOVE SCROLL */
}

/* NAVBAR */
nav{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:14px 28px;
    background:rgba(26,115,232,0.9);
    color:white;
    flex-wrap:wrap;
    backdrop-filter:blur(6px);
}
nav .logo{font-weight:700; font-size:20px;}
.nav-links{display:flex; gap:20px; list-style:none; padding:0; margin:0;}
.nav-links a{color:white; text-decoration:none; font-weight:600;}
.nav-links a:hover{text-decoration:underline;}

.email-text{
    color:#ffeb3b;
    font-weight:700;
    font-size:16px;
    white-space:nowrap;
}

/* MAIN CONTAINER */
.main-container{
    height:calc(100vh - 80px);
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
}

/* HERO SECTION */
.hero-wrapper{
    width:85%;
    background:white;
    padding:40px;
    border-radius:18px;
    box-shadow:0 6px 18px rgba(0,0,0,0.15);
    text-align:center;
    margin-bottom:40px;
}

.hero h1{
    font-size:34px;
    margin:0;
    font-weight:700;
    color:#222;
}
.hero p{
    font-size:18px;
    margin-top:10px;
    color:#444;
}

.start-btn{
    background:#1a73e8;
    padding:10px 28px;
    border-radius:6px;
    font-size:14px;
    color:white;
    text-decoration:none;
    display:inline-block;
    margin-top:20px;
    transition:0.3s;
    font-weight:600;
}
.start-btn:hover{
    background:#1557b0;
    transform:translateY(-1px);
}

/* CATEGORY CARDS HORIZONTAL */
.cards{
    display:flex;
    gap:20px;
    justify-content:center;
    margin-top:10px;
}

.card{
    background:white;
    padding:20px;
    width:180px;
    border-radius:14px;
    text-align:center;
    box-shadow:0 4px 12px rgba(0,0,0,0.1);
    transition:0.3s;
}
.card:hover{
    transform:translateY(-6px);
}
.icon{
    font-size:42px;
    margin-bottom:10px;
}
.title{
    font-size:18px;
    font-weight:700;
}
.desc{
    font-size:14px;
    color:#555;
}

/* FOOTER */
footer{
    background:#1a73e8;
    color:white;
    text-align:center;
    padding:10px;
    position:absolute;
    bottom:0;
    width:100%;
}
</style>

</head>
<body>

<!-- NAVBAR -->
<nav>
    <div class="logo">QuizFusion</div>

    <ul class="nav-links">
        <?php if($role === 'user'): ?>
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
            <li><a href="manage_contact.php"> Manage Contact</a></li>
            <li><a href="manage_feedback.php"> Manage Feedback</a></li>
            <li><a href="logout.php">Logout</a></li>
        <?php endif; ?>
    </ul>

    <div class="email-text">Hello 👋 <?= htmlspecialchars($useremail) ?></div>
</nav>


<div class="main-container">

    <!-- HERO SECTION -->
    <div class="hero-wrapper">
        <div class="hero">
            <h1><?= $greeting ?>, <?= htmlspecialchars($useremail) ?></h1>

            <p>
                <?php if($role === 'user'): ?>
                    Ready to begin your next challenge?
                <?php else: ?>
                    Manage quizzes, users, feedback & more.
                <?php endif; ?>
            </p>

            <a class="start-btn" href="<?= $role === 'user' ? 'categories.php' : 'manage_quiz.php' ?>">
                <?= $role === 'user' ? 'Start' : 'Go to Quiz' ?>
            </a>
        </div>
    </div>

    <!-- CATEGORY CARDS -->
    <div class="cards">
        <?php if($role === 'user'): ?>
            <div class="card"><div class="icon">📘</div><div class="title">General Knowledge</div><div class="desc">Test your awareness.</div></div>
            <div class="card"><div class="icon">🎨</div><div class="title">Pictionary</div><div class="desc">Guess the images.</div></div>
            <div class="card"><div class="icon">💻</div><div class="title">Technical</div><div class="desc">Computer & IT quizzes.</div></div>
            <div class="card"><div class="icon">🎧</div><div class="title">Audio Based</div><div class="desc">Identify sounds.</div></div>
            <div class="card"><div class="icon">🧠</div><div class="title">Maths & Logic</div><div class="desc">Solve puzzles.</div></div>
        <?php else: ?>
            <div class="card"><div class="icon">👤</div><div class="title">Manage Users</div><div class="desc">Add or remove users.</div></div>
            <div class="card"><div class="icon">📚</div><div class="title">Manage Quiz</div><div class="desc">Create questions.</div></div>
            <div class="card"><div class="icon">🏆</div><div class="title">Leaderboard</div><div class="desc">Track scores.</div></div>
            <div class="card"><div class="icon">✉️</div><div class="title">Contact</div><div class="desc">View messages.</div></div>
            <div class="card"><div class="icon">📝</div><div class="title">Feedback</div><div class="desc">View feedback.</div></div>
        <?php endif; ?>
    </div>

</div>

<footer>
    © 2025 QuizFusion | All Rights Reserved
</footer>

</body>
</html>
