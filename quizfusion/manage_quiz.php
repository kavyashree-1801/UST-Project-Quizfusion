<?php
session_start();
include 'config.php';

// -----------------------------
// 1. CHECK LOGIN & ADMIN ROLE
// -----------------------------
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = intval($_SESSION['user_id']);

// Fetch user info
$stmt = $con->prepare("SELECT role, email FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($role, $useremail);
$stmt->fetch();
$stmt->close();

if ($role !== 'admin') die("Access denied. Admins only.");

// -----------------------------
// 2. DELETE QUIZ
// -----------------------------
if (isset($_GET['delete'])) {
    $qid = intval($_GET['delete']);
    $con->query("DELETE FROM quizzes WHERE id='$qid'");
    $con->query("DELETE FROM questions WHERE quiz_id='$qid'");
    header("Location: manage_quiz.php");
    exit;
}

// -----------------------------
// 3. FETCH ALL QUIZZES
// -----------------------------
$result = $con->query("SELECT * FROM quizzes ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Quiz | Admin</title>
<style>
body {
    font-family:'Poppins',sans-serif; 
    background:#f5f7ff; 
    margin:0;
    padding-bottom:80px;
}
nav {
    display:flex; 
    justify-content:space-between; 
    align-items:center; 
    padding:14px 28px; 
    background:#1a73e8; 
    color:#fff;
}
.logo { font-weight:bold; font-size:22px; }
.nav-links { display:flex; gap:20px; list-style:none; margin:0; padding:0; }
.nav-links a { color:#fff; text-decoration:none; font-weight:600; }
.email-text { color:#ffeb3b; font-weight:bold; }
.main-container {
    max-width:900px; 
    margin:40px auto; 
    background:#fff; 
    padding:30px; 
    border-radius:12px; 
    box-shadow:0 4px 12px rgba(0,0,0,0.15);
}
table { width:100%; border-collapse:collapse; }
th,td { border:1px solid #ccc; padding:10px; text-align:left; }
th { background:#1a73e8; color:#fff; }
a.btn { background:#1a73e8; color:#fff; padding:6px 12px; text-decoration:none; border-radius:6px; }
a.btn:hover { background:#155ab6; }
footer {
    position:fixed; bottom:0; left:0; width:100%; background:#1a73e8; color:#fff; text-align:center;
    padding:12px 0; font-weight:600; box-shadow:0 -2px 6px rgba(0,0,0,0.2);
}
</style>
</head>
<body>

<nav>
    <div class="logo">QuizFusion</div>
    <ul class="nav-links">
        <li><a href="homepage.php">Home</a></li>
        <li><a href="manage_contact.php">Manage Contact</a></li>
        <li><a href="manage_feedback.php">Manage Feedback</a></li>
        <li><a href="manage_leaderboard.php">Manage Leaderboard</a></li>
        <li><a href="manage_users.php">Manage Users</a></li>
        <li><a href="manage_quiz.php">Manage Quiz</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
    <div class="email-text">Hello👋<?= htmlspecialchars($useremail) ?></div>
</nav>

<div class="main-container">
    <h2>Manage Quizzes</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Category</th>
            <th>Actions</th>
        </tr>

        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['category']) ?></td>
            <td>
                <!-- Pass quiz_id instead of category -->
                <a class="btn" href="manage_questions.php?quiz_id=<?= $row['id'] ?>">Manage Questions</a>
                <a class="btn" href="manage_quiz.php?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this quiz?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<footer>
    © 2025 QuizFusion | All Rights Reserved
</footer>

</body>
</html>
