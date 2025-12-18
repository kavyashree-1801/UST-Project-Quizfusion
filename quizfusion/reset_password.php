<?php
session_start();
include 'config.php';

if (!isset($_SESSION['reset_user'])) {
    header("Location: forgot_password.php");
    exit;
}

$user_id = $_SESSION['reset_user'];
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $password = trim($_POST['password']);
    $confirm  = trim($_POST['confirm_password']);

    if (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } elseif ($password !== $confirm) {
        $error = "Passwords do not match.";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $con->prepare("UPDATE users SET password=? WHERE id=?");
        $stmt->bind_param("si", $hashed, $user_id);

        if ($stmt->execute()) {
            session_regenerate_id(true);
            unset($_SESSION['reset_user']);

            $success = "Password reset successful! Redirecting...";
            header("refresh:2; url=login.php");
        } else {
            $error = "Failed to update password.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reset Password</title>

<link rel="stylesheet" href="css/reset_password.css">
</head>
<body>

<div class="box">
    <h2>Reset Password</h2>

    <?php if($error): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <?php if($success): ?>
        <div class="success"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST" id="resetForm">
        <input type="password" name="password" id="password" placeholder="New Password" required>
        <input type="password" name="confirm_password" id="confirm" placeholder="Confirm Password" required>
        <button type="submit">Reset Password</button>
    </form>
</div>

<script src="js/reset_password.js"></script>
</body>
</html>
