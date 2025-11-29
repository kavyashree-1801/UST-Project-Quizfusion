<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to access this page.");
}

$user_id = intval($_SESSION['user_id']);

// Fetch user email and role
$stmt = $con->prepare("SELECT email, role FROM users WHERE id = ?");
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
<title>QuizFusion | Contact Us</title>
<style>
:root{--brand:#1a73e8;--card:#ffffff;}
html, body{
    margin:0;
    padding:0;
    height:100%;
    font-family:Poppins,sans-serif;
    display:flex;
    flex-direction:column;
    /* BACKGROUND IMAGE */
    background: url('https://media.istockphoto.com/id/1450058572/photo/businessman-using-a-laptop-and-touching-on-virtual-screen-contact-icons-consists-of-telephone.jpg?s=612x612&w=0&k=20&c=R5wzCGHu6ZS-8EQpJ2Z1tkSbKGGdJH4apVhFM18EXSM=') no-repeat center center fixed;
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

/* MAIN FORM */
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
    background: rgba(255,255,255,0.95); /* semi-transparent white */
    padding:30px;
    border-radius:12px;
    box-shadow:0 4px 12px rgba(0,0,0,0.15);
    display:flex;
    flex-direction:column;
}
input, textarea{
    width:100%;
    padding:10px;
    margin-bottom:16px;
    border-radius:6px;
    border:1px solid #ccc;
    font-size:14px;
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
h1{font-size:32px;margin-bottom:20px;color:var(--brand);text-align:center;}
.success-msg{
    color:green;
    text-align:center;
    margin-bottom:12px;
    font-weight:bold;
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
    <div class="email-text">Hello👋<?= htmlspecialchars($useremail) ?></div>
</nav>

<!-- MAIN CONTACT FORM -->
<div class="main">
    <form action="contact_submit.php" method="post">
        <h1>Contact Us</h1>
        <input type="text" name="name" placeholder="Your Name">
        <input type="email" name="email" required value="<?= htmlspecialchars($useremail) ?>" placeholder="Your Email">
        <textarea name="message" rows="5" required placeholder="Your Message"></textarea>
        <button type="submit">Send Message</button>

        <?php if(isset($_GET['success'])): ?>
            <p class="success-msg">Message sent successfully! Redirecting...</p>
            <script>
                setTimeout(function(){
                    window.location.href="homepage.php";
                },3000);
            </script>
        <?php endif; ?>
    </form>
</div>

<!-- FOOTER -->
<footer>
    © 2025 QuizFusion | All Rights Reserved
</footer>

</body>
</html>
