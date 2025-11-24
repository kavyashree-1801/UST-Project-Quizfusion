<?php
session_start();
include 'config.php';

// Only admin access
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch admin info
$user_id = intval($_SESSION['user_id']);
$stmt = $con->prepare("SELECT role, email FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($role, $useremail);
$stmt->fetch();
$stmt->close();

if ($role !== 'admin') die("Access denied. Admins only.");

// Handle delete quiz
if (isset($_GET['delete'])) {
    $qid = intval($_GET['delete']);
    $con->query("DELETE FROM quizzes WHERE id='$qid'");
    $con->query("DELETE FROM questions WHERE quiz_id='$qid'"); // delete related questions
    header("Location: manage_quiz.php");
    exit;
}

// Fetch all quizzes
$result = $con->query("SELECT * FROM quizzes ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Quiz | Admin</title>
<style>
body{ font-family:'Poppins',sans-serif; background:#f5f7ff; margin:0;}
nav{ display:flex; justify-content:space-between; align-items:center; padding:14px 28px; background:#1a73e8; color:#fff;}
.logo{ font-weight:bold; font-size:22px; } /* Bold and larger */
.nav-links{display:flex; gap:20px; list-style:none; margin:0; padding:0;}
.nav-links a{color:#fff; text-decoration:none; font-weight:600;}
.email-text{color:#ffeb3b;}
.main-container{max-width:900px; margin:40px auto; background:#fff; padding:30px; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.15);}
table{width:100%; border-collapse:collapse;}
th,td{border:1px solid #ccc; padding:10px; text-align:left;}
th{background:#1a73e8; color:#fff;}
a.btn{background:#1a73e8; color:#fff; padding:6px 12px; text-decoration:none; border-radius:6px;}
a.btn:hover{background:#155ab6;}
</style>
</head>
<body>

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
        <?php else: // admin ?>
            <li><a href="homepage.php">Home</a></li>
            <li><a href="manage_users.php">Manage Users</a></li>
            <li><a href="manage_quiz.php">Manage Quiz</a></li>
            <li><a href="manage_leaderboard.php">Manage Leaderboard</a></li>
            <li><a href="manage_contact.php">Manage Contact</a></li>
            <li><a href="manage_feedback.php">Manage Feedback</a></li>
            <li><a href="logout.php">Logout</a></li>
        <?php endif; ?>
    </ul>
    <div class="email-text"><?= htmlspecialchars($useremail) ?></div>
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
                <a class="btn" href="manage_questions.php?quiz_id=<?= $row['id'] ?>">Manage Questions</a>
                <a class="btn" href="manage_quiz.php?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this quiz?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
