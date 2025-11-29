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
$stmt = $con->prepare("SELECT email, role FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($useremail, $role);
$stmt->fetch();
$stmt->close();

if ($role !== 'admin') die("Access denied. Admins only.");

// -----------------------------
// 2. CHECK QUIZ_ID PARAMETER
// -----------------------------
if (!isset($_GET['quiz_id']) || empty(trim($_GET['quiz_id']))) {
    die("Quiz not specified. Please go back.");
}

$quiz_id = intval($_GET['quiz_id']);

// -----------------------------
// 3. FETCH QUIZ INFO
// -----------------------------
$qz_stmt = $con->prepare("SELECT category FROM quizzes WHERE id=? LIMIT 1");
$qz_stmt->bind_param("i", $quiz_id);
$qz_stmt->execute();
$qz_res = $qz_stmt->get_result();
$quiz = $qz_res->fetch_assoc();
$qz_stmt->close();

if (!$quiz) die("Invalid quiz ID.");

$selected_category = $quiz['category'];

// -----------------------------
// 4. DELETE QUESTION
// -----------------------------
if (isset($_GET['delete_id'])) {
    $del = intval($_GET['delete_id']);
    $stmt_del = $con->prepare("DELETE FROM questions WHERE id=?");
    $stmt_del->bind_param("i", $del);
    $stmt_del->execute();
    $stmt_del->close();

    header("Location: manage_questions.php?quiz_id=" . $quiz_id);
    exit;
}

// -----------------------------
// 5. FETCH QUESTIONS
// -----------------------------
$stmt_q = $con->prepare("SELECT * FROM questions WHERE quiz_id=? ORDER BY id ASC");
$stmt_q->bind_param("i", $quiz_id);
$stmt_q->execute();
$result_q = $stmt_q->get_result();
$questions = $result_q->fetch_all(MYSQLI_ASSOC);
$stmt_q->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Questions | Admin</title>
<style>
body { font-family:'Poppins',sans-serif; background:#f5f7ff; margin:0; }
nav{ display:flex; justify-content:space-between; align-items:center; padding:14px 28px; background:#1a73e8; color:white; flex-wrap:wrap; }
nav .logo{ font-weight:700; font-size:20px; }
.nav-links{display:flex; gap:20px; list-style:none; padding:0; margin:0; flex-wrap:wrap;}
.nav-links a{color:white; text-decoration:none; font-weight:600;}
.nav-links a:hover{text-decoration:underline;}
.email-text{color:#ffeb3b; font-weight:600;}
.main-container { max-width:1200px; margin:30px auto; background:#fff; padding:25px; border-radius:10px; }
table { width:100%; border-collapse:collapse; }
th, td { border:1px solid #ccc; padding:10px; text-align:left; }
th { background:#1a73e8; color:white; }
.btn { background:#1a73e8; color:#fff; padding:7px 14px; text-decoration:none; border-radius:5px; font-size:14px; margin-right:5px; display:inline-block; }
.btn:hover { background:#0c59c3; }
.back-btn { background:#1a73e8; margin-bottom:15px; }
.back-btn:hover { background:#0c59c3; }
</style>
</head>
<body>

<!-- NAVBAR -->
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

    <h2>Manage Questions — <span style="color:#1a73e8;"><?= htmlspecialchars($selected_category) ?></span></h2>

    <!-- Back Button -->
    <a href="manage_quiz.php" class="btn back-btn">⬅ Back to Manage Quiz</a>

    <!-- Add New Question Button -->
    <a href="add_question.php?quiz_id=<?= $quiz_id ?>" class="btn">Add New Question</a>

    <br><br>

    <table>
        <tr>
            <th>ID</th>
            <th>Question</th>
            <th>Option 1</th>
            <th>Option 2</th>
            <th>Option 3</th>
            <th>Option 4</th>
            <th>Answer</th>
            <th>Hint</th>
            <th>Actions</th>
        </tr>

        <?php if (!empty($questions)): ?>
            <?php foreach ($questions as $index => $q): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= htmlspecialchars($q['question']) ?></td>
                <td><?= htmlspecialchars($q['option1']) ?></td>
                <td><?= htmlspecialchars($q['option2']) ?></td>
                <td><?= htmlspecialchars($q['option3']) ?></td>
                <td><?= htmlspecialchars($q['option4']) ?></td>
                <td><?= htmlspecialchars($q['answer']) ?></td>
                <td><?= htmlspecialchars($q['hint']) ?></td>
                <td>
                    <a class="btn" href="edit_question.php?id=<?= $q['id'] ?>&quiz_id=<?= $quiz_id ?>">Edit</a>
                    <a class="btn" href="manage_questions.php?quiz_id=<?= $quiz_id ?>&delete_id=<?= $q['id'] ?>" onclick="return confirm('Delete this question?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="9" style="text-align:center; color:#888;">No questions found for this quiz.</td></tr>
        <?php endif; ?>
    </table>
</div>

</body>
</html>
