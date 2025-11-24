<?php
session_start();
include 'config.php';

// --------------------------------------------
// 1. CHECK IF USER IS ADMIN
// --------------------------------------------
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = intval($_SESSION['user_id']);
$stmt = $con->prepare("SELECT email, role FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($useremail, $role);
$stmt->fetch();
$stmt->close();

if ($role !== 'admin') {
    die("Access denied. Admins only.");
}

// --------------------------------------------
// 2. DELETE RESULT IF REQUESTED
// --------------------------------------------
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $del_stmt = $con->prepare("DELETE FROM quiz_results WHERE id = ?");
    $del_stmt->bind_param("i", $delete_id);
    $del_stmt->execute();
    $del_stmt->close();
    header("Location: manage_leaderboard.php");
    exit;
}

// --------------------------------------------
// 3. GET QUIZ CATEGORIES
// --------------------------------------------
$categories = [];
$q_cat = mysqli_query($con, "SELECT DISTINCT category FROM quizzes");
if($q_cat) {
    while($row = mysqli_fetch_assoc($q_cat)) {
        $categories[] = $row['category'];
    }
}

// --------------------------------------------
// 4. FETCH LEADERBOARD ENTRIES (OPTIONALLY FILTERED)
// --------------------------------------------
$filter_category = $_GET['category'] ?? '';
$leaderboard = [];

$sql = "SELECT qr.id, qr.email, qr.score, qr.category, qr.total_questions, qr.taken_on
        FROM quiz_results qr ";

if(!empty($filter_category)) {
    $sql .= "WHERE qr.category = '" . mysqli_real_escape_string($con, $filter_category) . "' ";
}

$sql .= "ORDER BY qr.score DESC, qr.taken_on ASC";

$res = mysqli_query($con, $sql);
if ($res && mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $leaderboard[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Leaderboard | Admin</title>
<style>
:root { --brand:#1a73e8; --card:#ffffff; }

/* BODY */
html, body {
    margin:0;
    padding:0;
    font-family:'Poppins',sans-serif;
    min-height:100%;
    display:flex;
    flex-direction:column;
    background:#f5f7ff;
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
    flex:1;
    padding:36px 28px;
    max-width:1200px;
    margin:28px auto;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
    background:#fff;
    color:#000;
    border-radius:10px;
    overflow:hidden;
}
table th, table td{
    padding:12px 15px;
    border-bottom:1px solid #ddd;
    text-align:left;
}
table th{
    background:var(--brand);
    color:#fff;
}
table tr:hover{background:#f1f1f1;}
.delete-btn{
    background:#ff4444;
    color:#fff;
    padding:5px 10px;
    border:none;
    border-radius:4px;
    cursor:pointer;
    text-decoration:none;
}
.delete-btn:hover{background:#e53935;}

/* FILTER FORM */
.filter-form {
    margin-bottom:15px;
}
.filter-form select{
    padding:6px 10px;
    border-radius:4px;
    border:1px solid #ccc;
    font-size:14px;
}
.filter-form button{
    padding:6px 12px;
    border:none;
    background:var(--brand);
    color:#fff;
    font-weight:600;
    border-radius:4px;
    cursor:pointer;
}
.filter-form button:hover{background:#155ab6;}

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
        <li><a href="homepage.php">Home</a></li>
        <li><a href="manage_users.php">Manage Users</a></li>
        <li><a href="manage_quiz.php">Manage Quiz</a></li>
        <li><a href="manage_leaderboard.php">Manage Leaderboard</a></li>
        <li><a href="manage_contact.php"> Manage Contact</a></li>
        <li><a href="manage_feedback.php"> Manage Feedback</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
    <div class="email-text"><?= htmlspecialchars($useremail) ?></div>
</nav>

<!-- MAIN -->
<div class="main-container">
    <h2>Leaderboard Management</h2>

    <!-- FILTER FORM -->
    <form method="GET" class="filter-form">
        <label>Filter by Category:
            <select name="category">
                <option value="">All</option>
                <?php foreach($categories as $cat): ?>
                    <option value="<?= htmlspecialchars($cat) ?>" <?= ($filter_category==$cat)?'selected':''; ?>>
                        <?= htmlspecialchars($cat) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>
        <button type="submit">Filter</button>
    </form>

    <?php if(count($leaderboard) === 0): ?>
        <p>No quiz results found.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Email</th>
                    <th>Score</th>
                    <th>Category</th>
                    <th>Total Questions</th>
                    <th>Taken On</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i=1; foreach($leaderboard as $row): ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= $row['score'] ?></td>
                    <td><?= htmlspecialchars($row['category']) ?></td>
                    <td><?= $row['total_questions'] ?></td>
                    <td><?= $row['taken_on'] ?></td>
                    <td>
                        <a href="manage_leaderboard.php?delete_id=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this result?');">Delete</a>
                    </td>
                </tr>
                <?php $i++; endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<!-- FOOTER -->
<footer>
    © 2025 QuizFusion | All Rights Reserved
</footer>

</body>
</html>
