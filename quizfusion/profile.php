<?php
session_start();
include 'config.php'; // must set $con as a mysqli connection

// --- BASIC CHECKS ---
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to access this page.");
}

if (!isset($con) || !($con instanceof mysqli)) {
    die("Database connection NOT available. Check config.php. Error: " . mysqli_connect_error());
}

$user_id = intval($_SESSION['user_id']);

// Helper: prepare SQL safely
function prepare_or_die($con, $sql) {
    $stmt = $con->prepare($sql);
    if ($stmt === false) {
        die("DB prepare failed: (" . $con->errno . ") " . $con->error . " — SQL: " . htmlspecialchars($sql));
    }
    return $stmt;
}

/* ---------------------------------------------------------
   FETCH USER DETAILS (name, email, role — NO username)
--------------------------------------------------------- */
$stmt = prepare_or_die($con, "SELECT name, email, role FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($name, $email, $role);
$stmt->fetch();
$stmt->close();

$success = "";
$error = "";

/* ---------------------------------------------------------
   UPDATE PROFILE (name + email only)
--------------------------------------------------------- */
if (isset($_POST['update_profile'])) {
    $new_name = trim($_POST['name'] ?? '');
    $new_email = trim($_POST['email'] ?? '');

    if ($new_name === "" || $new_email === "") {
        $error = "All fields are required!";
    } else {
        $upd = prepare_or_die($con, "UPDATE users SET name = ?, email = ? WHERE id = ?");
        $upd->bind_param("ssi", $new_name, $new_email, $user_id);

        if ($upd->execute()) {
            $success = "Profile updated successfully!";
            $name = $new_name;
            $email = $new_email;
        } else {
            $error = "Update failed: (" . $upd->errno . ") " . $upd->error;
        }
        $upd->close();
    }
}

/* ---------------------------------------------------------
   UPDATE PASSWORD
--------------------------------------------------------- */
if (isset($_POST['update_password'])) {
    $old_pass = $_POST['old_password'] ?? '';
    $new_pass = $_POST['new_password'] ?? '';

    if ($old_pass === "" || $new_pass === "") {
        $error = "Please fill both password fields.";
    } else {
        // Fetch current password
        $getpass = prepare_or_die($con, "SELECT password FROM users WHERE id = ?");
        $getpass->bind_param("i", $user_id);
        $getpass->execute();
        $getpass->bind_result($dbpass);
        $got = $getpass->fetch();
        $getpass->close();

        if (!$got) {
            $error = "Unable to fetch existing password.";
        } elseif (!password_verify($old_pass, $dbpass)) {
            $error = "Old password is incorrect!";
        } else {
            $hashed = password_hash($new_pass, PASSWORD_DEFAULT);

            $updpass = prepare_or_die($con, "UPDATE users SET password = ? WHERE id = ?");
            $updpass->bind_param("si", $hashed, $user_id);

            if ($updpass->execute()) {
                $success = "Password updated successfully!";
            } else {
                $error = "Failed to update password.";
            }
            $updpass->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>QuizFusion | Profile</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
:root{--brand:#1a73e8;--card:#ffffff;}
html, body{
    margin:0; padding:0; height:100%; font-family:Poppins,sans-serif; display:flex; flex-direction:column;
    background:url('https://img.freepik.com/free-photo/abstract-connection-between-dots-lines_1048-5824.jpg') no-repeat center center fixed;
    background-size:cover;
}
nav{
    display:flex; justify-content:space-between; align-items:center;
    padding:14px 28px; background:var(--brand); color:white; flex-wrap:wrap;
}
nav .logo{font-weight:700;font-size:20px;}
.nav-links{display:flex;gap:20px;list-style:none;margin:0;padding:0;}
.nav-links a{color:white;text-decoration:none;font-weight:600;}
.nav-links a:hover{text-decoration:underline;}
.email-text{color:#ffeb3b;font-weight:600;}

.main{flex:1;display:flex;justify-content:center;align-items:center;padding:40px;}
.card{
    width:100%; max-width:550px; background:rgba(255,255,255,0.96);
    padding:30px; border-radius:12px; 
    box-shadow:0 4px 12px rgba(0,0,0,0.15);
}

h1{font-size:28px;text-align:center;color:var(--brand);margin-bottom:20px;}
label{font-weight:600;}
input{
    width:100%; padding:10px; margin-bottom:16px;
    border-radius:6px; border:1px solid #ccc;
}
button{
    width:100%; background:var(--brand); color:white;
    border:none; padding:12px; border-radius:6px;
    font-size:16px; cursor:pointer; margin-top:10px;
    transition:0.3s;
}
button:hover{background:#155ab6;}

.success-msg{
    background:#d4f8d4; color:#1e6b1e;
    padding:10px; text-align:center;
    margin-bottom:10px; border-radius:6px; font-weight:bold;
}
.error-msg{
    background:#ffd1d1; color:#9b0000;
    padding:10px; text-align:center;
    margin-bottom:10px; border-radius:6px; font-weight:bold;
}

/* Password toggle */
.toggle-pass {
    position:absolute;
    right:10px;
    top:50%;
    transform:translateY(-50%);
    cursor:pointer;
}
.toggle-pass svg { pointer-events:none; }

.pass-wrapper { position:relative; }

footer{
    background:var(--brand); color:white;
    text-align:center; padding:12px;
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
            <li><a href="contact_messages.php">Contact</a></li>
            <li><a href="feedback_list.php">Feedback</a></li>
            <li><a href="logout.php">Logout</a></li>
        <?php endif; ?>
    </ul>

    <div style="display:flex; align-items:center; gap:12px;">
        <div class="email-text">Hello👋 <?= htmlspecialchars($email) ?></div>

        <a href="profile.php"
           style="background:white; color:#1a73e8; padding:6px 14px; border-radius:6px; font-weight:600; text-decoration:none; border:1px solid #fff; transition:0.3s;"
           onmouseover="this.style.background='#e2e2e2'" onmouseout="this.style.background='white'">Profile</a>
    </div>
</nav>

<!-- PROFILE CARD -->
<div class="main">
    <div class="card">

        <h1>My Profile</h1>

        <?php if($success): ?>
            <div class="success-msg"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <?php if($error): ?>
            <div class="error-msg"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <!-- UPDATE PROFILE -->
        <form method="post">
            <label>Name:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($name) ?>">

            <label>Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($email) ?>">

            <button type="submit" name="update_profile">Update Profile</button>
        </form>

        <hr style="margin:25px 0;">

        <!-- UPDATE PASSWORD -->
        <form method="post">
            <label>Old Password:</label>
            <div class="pass-wrapper">
                <input type="password" name="old_password" id="old_password" required>
                <span class="toggle-pass" onclick="togglePass('old_password', this)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="gray" viewBox="0 0 24 24">
                        <path d="M12 5c-7.633 0-12 7-12 7s4.367 7 12 7 12-7 12-7-4.367-7-12-7zm0 12c-2.761 0-5-2.239-5-5s2.239-5 5-5 
                        5 2.239 5 5-2.239 5-5 5zm0-8a3 3 0 100 6 3 3 0 000-6z"/>
                    </svg>
                </span>
            </div>

            <label>New Password:</label>
            <div class="pass-wrapper">
                <input type="password" name="new_password" id="new_password" required>
                <span class="toggle-pass" onclick="togglePass('new_password', this)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="gray" viewBox="0 0 24 24">
                        <path d="M12 5c-7.633 0-12 7-12 7s4.367 7 12 7 12-7 12-7-4.367-7-12-7zm0 12c-2.761 0-5-2.239-5-5s2.239-5 5-5 
                        5 2.239 5 5-2.239 5-5 5zm0-8a3 3 0 100 6 3 3 0 000-6z"/>
                    </svg>
                </span>
            </div>

            <button type="submit" name="update_password">Update Password</button>
        </form>

    </div>
</div>

<footer>
    © <?= date('Y') ?> QuizFusion | All Rights Reserved
</footer>

<script>
function togglePass(inputId, el) {
    const input = document.getElementById(inputId);
    if (input.type === "password") {
        input.type = "text";
        el.querySelector('svg').style.fill = "#1a73e8";
    } else {
        input.type = "password";
        el.querySelector('svg').style.fill = "gray";
    }
}
</script>

</body>
</html>
