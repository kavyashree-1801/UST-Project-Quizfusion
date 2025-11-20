<?php
session_start();
include 'config.php';

if (!isset($_SESSION['email_reset'])) {
    header("Location: forgot_password.php");
    exit;
}

$email = $_SESSION['email_reset'];
$question = $_SESSION['security_question'];
$name = $_SESSION['user_name'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $answer = trim($_POST['security_answer']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    if ($new_password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        $stmt = $con->prepare("SELECT security_answer FROM signup WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row && password_verify($answer, $row['security_answer'])) {
            $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update = $con->prepare("UPDATE signup SET password = ? WHERE email = ?");
            $update->bind_param("ss", $hashed_new_password, $email);
            $update->execute();

            session_destroy();
            $success = "Password reset successful! Redirecting to login...";
        } else {
            $error = "Incorrect answer. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password | Veggiedelights</title>
  <style>
    body {
      font-family: "Poppins", sans-serif;
      background: url('https://t3.ftcdn.net/jpg/05/15/82/20/360_F_515822014_L4aurIrqCks24haCUIPSWpZ2VX9ls0Q6.jpg') no-repeat center center/cover;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
      position: relative;
    }
    body::before {
      content: "";
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.3);
    }
    .reset-box {
      background: rgba(255,255,255,0.95);
      border-radius: 20px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.1);
      padding: 35px 40px;
      text-align: center;
      z-index: 2;
      max-width: 380px;
      width: 90%;
    }
    h2 { color: #ff7b00; margin-bottom: 10px; }
    p { color: #333; margin-bottom: 20px; }
    input {
      width: 100%;
      padding: 10px 12px;
      margin: 10px 0;
      border-radius: 10px;
      border: 1px solid #ccc;
      font-size: 1rem;
      outline: none;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    input:focus {
      border-color: #ffa94d;
      box-shadow: 0 0 0 3px rgba(255, 179, 71, 0.3);
    }
    .password-wrapper { position: relative; }
    .toggle-password {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      background: transparent;
      border: none;
      cursor: pointer;
      color: #666;
      padding: 6px;
      border-radius: 8px;
    }
    .toggle-password:hover { background: rgba(0,0,0,0.05); }
    .toggle-password svg { width: 20px; height: 20px; }
    button {
      background: #ff7b00;
      color: #fff;
      border: none;
      padding: 12px;
      width: 100%;
      border-radius: 10px;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s;
      margin-top: 10px;
    }
    button:hover { background: #ff8f26; }
  </style>
</head>
<body>
  <div class="reset-box">
    <h2>Hello, <?= htmlspecialchars($name) ?>!</h2>
    <p><strong>Security Question:</strong><br><?= htmlspecialchars($question) ?></p>

    <form method="POST">
      <input type="text" name="security_answer" placeholder="Your answer" required><br>

      <div class="password-wrapper">
        <input type="password" id="new_password" name="new_password" placeholder="New password" required>
        <button type="button" class="toggle-password" data-target="new_password" title="Show password">
          👁️
        </button>
      </div>

      <div class="password-wrapper">
        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm password" required>
        <button type="button" class="toggle-password" data-target="confirm_password" title="Show password">
          👁️
        </button>
      </div>

      <button type="submit">Reset Password</button>
    </form>
  </div>

  <script>
    // Toggle password visibility
    document.querySelectorAll('.toggle-password').forEach(btn => {
      btn.addEventListener('click', () => {
        const targetId = btn.getAttribute('data-target');
        const input = document.getElementById(targetId);
        input.type = input.type === "password" ? "text" : "password";
      });
    });

    // Show alert if PHP sets error or success
    <?php if(isset($error)): ?>
      alert("<?= addslashes($error) ?>");
    <?php endif; ?>

    <?php if(isset($success)): ?>
      alert("<?= addslashes($success) ?>");
      setTimeout(() => {
        window.location.href = "login.php";
      }, 1000); // Redirect after 1 second
    <?php endif; ?>
  </script>
</body>
</html>
