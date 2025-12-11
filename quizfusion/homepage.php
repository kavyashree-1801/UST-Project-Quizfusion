<?php
session_start();
include 'config.php';

// CHECK IF USER IS LOGGED IN
$isLoggedIn = isset($_SESSION['user_id']);

if ($isLoggedIn) {
    $user_id = intval($_SESSION['user_id']);

    // Fetch user email and role
    $stmt = $con->prepare("SELECT email, role FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($useremail, $role);
    $stmt->fetch();
    $stmt->close();
} else {
    // DEFAULT VALUES FOR GUEST
    $useremail = "Guest";
    $role = "guest";
}

// GREETING MESSAGE
$hour = date("H");
if ($hour < 12)       $greeting = "Good Morning";
elseif ($hour < 17)   $greeting = "Good Afternoon";
else                  $greeting = "Good Evening";
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
    background: 
        linear-gradient(rgba(255,255,255,0.2), rgba(255,255,255,0.2)),
        url('https://media.istockphoto.com/id/466873090/vector/education-icons-on-gray-background-pattern.jpg?s=612x612&w=0&k=20&c=q4fAGF4qsNXuCK39Q22y18L6DaJVVs3Gnqo8KDCFDNQ=')
        center/cover no-repeat fixed;
    height:100%;
}

/* NAVBAR */
nav{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:14px 28px;
    background:rgba(26,115,232,0.95);
    color:white;
    backdrop-filter:blur(6px);
}
nav .logo{font-weight:700; font-size:22px;}

.nav-links{
    display:flex;
    gap:20px;
    list-style:none;
    margin:0;
    padding:0;
}
.nav-links a{
    color:white;
    text-decoration:none;
    font-weight:600;
}
.nav-links a:hover{text-decoration:underline;}

.right-section{
    display:flex;
    align-items:center;
    gap:15px;
}

.welcome-text{
    color:#ffeb3b;
    font-weight:700;
}

.btn{
    background:white;
    color:#1a73e8;
    padding:8px 20px;
    border-radius:6px;
    font-weight:600;
    text-decoration:none;
    border:2px solid white;
    transition:0.3s;
}
.btn:hover{ background:#e7e7e7; }

/* MAIN */
.main-container{
    padding:40px 0;
    text-align:center;
}

.hero-wrapper{
    width:85%;
    margin:auto;
    background:white;
    padding:40px;
    border-radius:18px;
    box-shadow:0 6px 18px rgba(0,0,0,0.15);
}

.hero h1{font-size:34px; margin:0; font-weight:700;}
.hero p{font-size:18px; margin-top:10px; color:#444;}

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
}
.start-btn:hover{ background:#1557b0; }

/* CARDS */
.cards{
    display:flex;
    gap:20px;
    justify-content:center;
    margin-top:30px;
    flex-wrap:wrap;
}
.card{
    background:white;
    padding:20px;
    width:180px;
    border-radius:14px;
    text-align:center;
    box-shadow:0 4px 12px rgba(0,0,0,0.1);
}
.icon{font-size:42px; margin-bottom:10px;}
.title{font-size:18px; font-weight:700;}
.desc{font-size:14px; color:#555;}

/* FOOTER */
footer{
    background:#1a73e8;
    color:white;
    text-align:center;
    padding:12px;
    position:fixed;
    bottom:0;
    left:0;
    width:100%;
}
</style>

</head>
<body>

<!-- NAVBAR -->
<nav>
    <div class="logo">QuizFusion</div>

    <ul class="nav-links">
        <li><a href="homepage.php">Home</a></li>

        <?php if ($role === 'guest'): ?>
            <li><a href="about.php">About</a></li>

        <?php elseif ($role === 'user'): ?>
            <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="categories.php">Categories</a></li>
            <li><a href="leaderboard.php">Leaderboard</a></li>
            <li><a href="feedback.php">Feedback</a></li>
            <li><a href="user_report.php">User Report</a></li>
            <li><a href="logout.php">Logout</a></li>

        <?php else: ?>
            <li><a href="manage_contact.php">Manage Contact</a></li>
            <li><a href="manage_feedback.php">Manage Feedback</a></li>
            <li><a href="manage_leaderboard.php">Manage Leaderboard</a></li>
            <li><a href="manage_users.php">Manage Users</a></li>
            <li><a href="manage_quiz.php">Manage Quiz</a></li>
            <li><a href="logout.php">Logout</a></li>
        <?php endif; ?>
    </ul>

    <!-- RIGHT SECTION (LOGIN, REGISTER, WELCOME + PROFILE BUTTON) -->
    <div class="right-section">

        <?php if ($role === 'guest'): ?>
            <div class="welcome-text">Welcome Guest</div>
            <a href="login.php" class="btn">Login</a>
            <a href="register.php" class="btn">Register</a>

        <?php elseif ($role === 'user' || $role === 'admin'): ?>
            <div class="welcome-text">Hello👋<?= htmlspecialchars($useremail) ?></div>
            
            <!-- PROFILE BUTTON -->
            <a href="profile.php" class="btn"
               style="border:1px solid #fff;"
               onmouseover="this.style.background='#e2e2e2'"
               onmouseout="this.style.background='white'">
               Profile
            </a>

        <?php endif; ?>

    </div>

</nav>


<!-- MAIN CONTENT -->
<div class="main-container">

    <div class="hero-wrapper">
        <div class="hero">
            <h1><?= $greeting ?>, <?= htmlspecialchars($useremail) ?></h1>

            <p>
                <?php if ($role === 'guest'): ?>
                    Welcome! Please log in or register to start quizzes.
                <?php elseif ($role === 'user'): ?>
                    Ready for your next quiz challenge?
                <?php else: ?>
                    Manage quizzes, users, feedback & more.
                <?php endif; ?>
            </p>

            <a class="start-btn" 
               href="<?= $role === 'guest' ? 'login.php' : ($role === 'user' ? 'categories.php' : 'manage_quiz.php') ?>">
               <?= $role === 'guest' ? 'Login to Start' : ($role === 'user' ? 'Start Quiz' : 'Go to Admin Panel') ?>
            </a>
        </div>
    </div>

    <div class="cards">
        <?php if ($role === 'guest'): ?>
            <div class="card"><div class="icon">🔒</div><div class="title">Login Required</div><div class="desc">Access quizzes after logging in.</div></div>
            <div class="card"><div class="icon">ℹ️</div><div class="title">About</div></div>
            <div class="card"><div class="icon">📝</div><div class="title">Register</div></div>

        <?php elseif($role === 'user'): ?>
            <div class="card"><div class="icon">📘</div><div class="title">General Knowledge</div></div>
            <div class="card"><div class="icon">🎨</div><div class="title">Pictionary</div></div>
            <div class="card"><div class="icon">💻</div><div class="title">Technical</div></div>
            <div class="card"><div class="icon">🎧</div><div class="title">Audio Based</div></div>
            <div class="card"><div class="icon">🧠</div><div class="title">Maths & Logic</div></div>

        <?php else: ?>
            <div class="card"><div class="icon">👤</div><div class="title">Manage Users</div></div>
            <div class="card"><div class="icon">📚</div><div class="title">Manage Quiz</div></div>
            <div class="card"><div class="icon">🏆</div><div class="title">Leaderboard</div></div>
            <div class="card"><div class="icon">📝</div><div class="title">Feedback</div></div>
        <?php endif; ?>
    </div>

</div>

<footer>
    © 2025 QuizFusion | All Rights Reserved
</footer>

</body>
</html>
