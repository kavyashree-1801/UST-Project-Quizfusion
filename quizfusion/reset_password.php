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

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $new_pass = trim($_POST['password']);
    $hashed = password_hash($new_pass, PASSWORD_DEFAULT);

    $stmt = $con->prepare("UPDATE users SET password=? WHERE id=?");
    $stmt->bind_param("si", $hashed, $user_id);

    if ($stmt->execute()) {
        unset($_SESSION['reset_user']);
        $success = "Password reset successful! Redirecting...";
        header("refresh:2; url=login.php");
    } else {
        $error = "Error updating password!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Reset Password</title>
<style>
body { font-family:poppins;background:#111;color:#fff;display:flex;justify-content:center;align-items:center;min-height:100vh; }
.box { width:350px;background:#222;padding:20px;border-radius:10px;text-align:center; }
input { width:100%;padding:10px;margin:10px 0;border-radius:8px;border:none; }
button { width:100%;padding:10px;background:#00ffcc;border:none;border-radius:8px;font-weight:bold;cursor:pointer; }
.success {color:#00ff99;font-weight:bold;}
.error {color:red;font-weight:bold;}
</style>
</head>
<body>
<div class="box">

<h2>Reset Password</h2>

<?php 
if($error) echo "<div class='error'>$error</div>"; 
if($success) echo "<div class='success'>$success</div>"; 
?>

<form method="POST">
    <input type="password" name="password" placeholder="New Password" required>
    <button type="submit">Reset Password</button>
</form>

</div>
</body>
</html>
