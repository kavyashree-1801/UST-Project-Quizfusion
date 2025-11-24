<?php
session_start();
include 'config.php';

// --------------------------
// 1. CHECK ADMIN LOGIN
// --------------------------
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = intval($_SESSION['user_id']);
$stmt = $con->prepare("SELECT email, role FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($useremail, $role);
$stmt->fetch();
$stmt->close();

// Only allow admin
if($role !== 'admin') {
    die("Access denied. Admins only.");
}

// --------------------------
// 2. HANDLE DELETE
// --------------------------
if(isset($_GET['delete_id'])) {
    $del_id = intval($_GET['delete_id']);
    mysqli_query($con, "DELETE FROM questions WHERE id='$del_id'");
    header("Location: manage_questions.php?category=" . urlencode($_GET['category']));
    exit;
}

// --------------------------
// 3. GET ALL QUIZ CATEGORIES
// --------------------------
$quiz_result = mysqli_query($con, "SELECT category FROM quizzes ORDER BY category ASC");
$categories = mysqli_fetch_all($quiz_result, MYSQLI_ASSOC);

// --------------------------
// 4. DETERMINE SELECTED CATEGORY
// --------------------------
$selected_category = $_GET['category'] ?? '';
if($selected_category == '' && count($categories) > 0){
    // Default to the first category if none selected
    $selected_category = $categories[0]['category'];
}

$questions = [];
if($selected_category != '') {
    $quiz_q = mysqli_query($con, "SELECT id FROM quizzes WHERE category='$selected_category' LIMIT 1");
    if($quiz_q && mysqli_num_rows($quiz_q) > 0) {
        $quiz_row = mysqli_fetch_assoc($quiz_q);
        $quiz_id = $quiz_row['id'];
        $q_res = mysqli_query($con, "SELECT * FROM questions WHERE quiz_id='$quiz_id' ORDER BY id ASC");
        if($q_res) {
            $questions = mysqli_fetch_all($q_res, MYSQLI_ASSOC);
        }
    } else {
        $selected_category = '';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Questions | Admin</title>
<style>
:root { --brand:#1a73e8; --card:#ffffff; }
body { margin:0; font-family:'Poppins',sans-serif; background:#f5f7ff; display:flex; flex-direction:column; min-height:100vh; }
nav{ display:flex; justify-content:space-between; align-items:center; padding:14px 28px; background:var(--brand); color:white; flex-wrap:wrap; }
nav .logo{font-weight:700; font-size:20px;}
.nav-links{display:flex; gap:20px; list-style:none; padding:0; margin:0; flex-wrap:wrap;}
.nav-links a{color:white; text-decoration:none; font-weight:600;}
.nav-links a:hover{text-decoration:underline;}
.email-text{color:#ffeb3b; font-weight:600;}
.main-container{flex:1; padding:36px 28px; max-width:1200px; margin:28px auto;}
table{width:100%; border-collapse:collapse; background:#fff;}
table th, table td{padding:12px; border:1px solid #ddd; text-align:left;}
table th{background:#f0f0f0;}
.btn{padding:6px 12px; background:#1a73e8; color:#fff; text-decoration:none; border-radius:5px; margin-right:5px;}
.btn:hover{background:#0c59c3;}
footer{background:var(--brand); color:white; text-align:center; padding:12px; flex-shrink:0;}
select{padding:6px; margin-bottom:20px;}
</style>
</head>
<body>

<!-- NAVBAR -->
<nav>
    <div class="logo">QuizFusion</div>
    <ul class="nav-links">
        <li><a href="homepage.php">Home</a></li>
        <li><a href="manage_users.php">Manage Users</a></li>
        <li><a href="manage_quiz.php">Manage Quiz</a></li>
        <li><a href="manage_questions.php">Manage Questions</a></li>
        <li><a href="manage_leaderboard.php">Manage Leaderboard</a></li>
        <li><a href="manage_contact.php"> Manage Contact</a></li>
        <li><a href=" manage_feedback.php"> Manage Feedback</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
    <div class="email-text"><?= htmlspecialchars($useremail) ?></div>
</nav>

<!-- MAIN -->
<div class="main-container">
    <h2>Manage Questions</h2>

    <form method="GET">
        <label>Select Category: </label>
        <select name="category" onchange="this.form.submit()">
            <?php foreach($categories as $c): ?>
                <option value="<?= htmlspecialchars($c['category']) ?>" <?= ($selected_category==$c['category'])?'selected':'' ?>>
                    <?= htmlspecialchars($c['category']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <a href="add_question.php?category=<?= urlencode($selected_category) ?>" class="btn">Add New Question</a>

    <table>
        <tr>
            <th>Id</th>
            <th>Question</th>
            <th>Option 1</th>
            <th>Option 2</th>
            <th>Option 3</th>
            <th>Option 4</th>
            <th>Answer</th>
            <th>Actions</th>
        </tr>
        <?php
        $i=1;
        foreach($questions as $q):
        ?>
        <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($q['question']) ?></td>
            <td><?= htmlspecialchars($q['option1']) ?></td>
            <td><?= htmlspecialchars($q['option2']) ?></td>
            <td><?= htmlspecialchars($q['option3']) ?></td>
            <td><?= htmlspecialchars($q['option4']) ?></td>
            <td><?= htmlspecialchars($q['answer']) ?></td>
            <td>
                <a href="edit_question.php?id=<?= $q['id'] ?>" class="btn">Edit</a>
                <a href="manage_questions.php?category=<?= urlencode($selected_category) ?>&delete_id=<?= $q['id'] ?>" class="btn" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

<!-- FOOTER -->
<footer>
    © 2025 QuizFusion | All Rights Reserved
</footer>

</body>
</html>
