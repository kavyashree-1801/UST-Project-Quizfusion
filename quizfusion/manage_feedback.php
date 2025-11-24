<?php
session_start();
include 'config.php';

// --------------------------------------------
// 1. CHECK LOGIN
// --------------------------------------------
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

// --------------------------------------------
// 2. HANDLE DELETE FEEDBACK
// --------------------------------------------
if($role === 'admin' && isset($_GET['delete_id'])){
    $del_id = intval($_GET['delete_id']);
    $del_query = "DELETE FROM feedback WHERE id = $del_id";
    mysqli_query($con, $del_query);
    header("Location: feedback_list.php");
    exit;
}

// --------------------------------------------
// 3. FETCH FEEDBACK MESSAGES
// --------------------------------------------
$feedbacks = [];
$q = "SELECT * FROM feedback ORDER BY id DESC";
$res = mysqli_query($con, $q);
if($res && mysqli_num_rows($res) > 0){
    while($row = mysqli_fetch_assoc($res)){
        $feedbacks[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Feedback List</title>
<style>
:root { --brand:#1a73e8; --card:#ffffff; }

/* BODY */
html, body {
    margin:0;
    padding:0;
    font-family:'Poppins',sans-serif;
    min-height:100vh;
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
    border-radius:8px;
    overflow:hidden;
    box-shadow:0 4px 12px rgba(0,0,0,0.1);
}
th, td{
    padding:12px 15px;
    text-align:left;
    border-bottom:1px solid #ddd;
}
th{background:var(--brand); color:#fff;}
tr:hover{background:#f1f1f1;}
.delete-btn{
    background:#ff4444;
    color:#fff;
    border:none;
    padding:6px 12px;
    border-radius:6px;
    cursor:pointer;
    text-decoration:none;
    font-weight:bold;
}
.delete-btn:hover{background:#cc0000;}

/* FOOTER */
footer{
    background:var(--brand);
    color:white;
    text-align:center;
    padding:12px;
    flex-shrink:0;
    position:sticky;
    bottom:0;
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
        <?php else: // admin ?>
            <li><a href="homepage.php">Home</a></li>
            <li><a href="manage_users.php">Manage Users</a></li>
            <li><a href="manage_quiz.php">Manage Quiz</a></li>
            <li><a href="manage_leaderboard.php">Manage Leaderboard</a></li>
            <li><a href="manage_contact.php">Manage Contact</a></li>
            <li><a href=" manage_feedback.php"> Manage Feedback</a></li>
            <li><a href="logout.php">Logout</a></li>
        <?php endif; ?>
    </ul>
    <div class="email-text"><?= htmlspecialchars($useremail) ?></div>
</nav>

<!-- MAIN -->
<div class="main-container">
    <h2>Feedback Messages</h2>

    <?php if(count($feedbacks) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Rating</th>
                    <th>Comments</th>
                    <?php if($role === 'admin'): ?><th>Action</th><?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach($feedbacks as $f): ?>
                <tr>
                    <td><?= $f['id'] ?></td>
                    <td><?= htmlspecialchars($f['email']) ?></td>
                    <td><?= htmlspecialchars($f['rating']) ?></td>
                    <td><?= htmlspecialchars($f['comments']) ?></td>
                    <?php if($role === 'admin'): ?>
                        <td>
                            <a class="delete-btn" href="feedback_list.php?delete_id=<?= $f['id'] ?>" onclick="return confirm('Are you sure to delete this feedback?');">Delete</a>
                        </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No feedback messages found.</p>
    <?php endif; ?>
</div>

<!-- FOOTER -->
<footer>
    © 2025 QuizFusion | All Rights Reserved
</footer>

</body>
</html>
