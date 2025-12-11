<?php
session_start();
include 'config.php';

$error = "";
$success = "";

// Generate simple CAPTCHA only if form not submitted
if (!isset($_POST['captcha'])) {
    $captcha_num1 = rand(1, 9);
    $captcha_num2 = rand(1, 9);
    $_SESSION['captcha_answer'] = $captcha_num1 + $captcha_num2;
} else {
    $captcha_num1 = isset($_SESSION['captcha_num1']) ? $_SESSION['captcha_num1'] : rand(1,9);
    $captcha_num2 = isset($_SESSION['captcha_num2']) ? $_SESSION['captcha_num2'] : rand(1,9);
}

$questions = [
    "What is your birthplace?",
    "What is your mother's maiden name?",
    "What is your first pet's name?",
    "What is your favorite teacher's name?",
    "What is your favorite movie?"
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $question = trim($_POST['security_question']);
    $answer = trim($_POST['security_answer']);
    $captcha = trim($_POST['captcha']);

    if (empty($name) || empty($email) || empty($password) || empty($confirm_password) || empty($answer)) {
        $error = "All fields are required!";
    } 
    elseif ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    }
    elseif ($captcha != $_SESSION['captcha_answer']) {
        $error = "Incorrect CAPTCHA answer!";
    }
    else {
        $check = $con->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $error = "Email already registered!";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $hashed_answer = password_hash($answer, PASSWORD_DEFAULT);

            $stmt = $con->prepare(
                "INSERT INTO users (name, email, password, security_question, security_answer) 
                 VALUES (?, ?, ?, ?, ?)"
            );
            $stmt->bind_param("sssss", $name, $email, $hashed_password, $question, $hashed_answer);

            if ($stmt->execute()) {
                $success = "Registration successful! Redirecting...";
                header("refresh:2; url=login.php");
            } else {
                $error = "Database error!";
            }
            $stmt->close();
        }
        $check->close();
    }
}

// Save CAPTCHA numbers for next request
$_SESSION['captcha_num1'] = $captcha_num1;
$_SESSION['captcha_num2'] = $captcha_num2;

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>QuizFusion | Register</title>
<style>
body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background: url('https://st2.depositphotos.com/1038076/6115/i/950/depositphotos_61151365-stock-photo-register.jpg') no-repeat center center/cover;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

.reg-box {
    width: 420px;
    background: rgba(0,0,0,0.75);
    padding: 35px;
    border-radius: 15px;
    color: #fff;
    text-align: center;
    box-shadow: 0 0 25px rgba(0,0,0,0.7);
}

input, select, .captcha-box {
    width: 100%;
    padding: 12px 15px;
    margin: 10px 0;
    border-radius: 10px;
    border: none;
    outline: none;
    box-sizing: border-box;
    font-size: 16px;
}

.captcha-box {
    background: #fff;
    color: #000;
    font-weight: bold;
    text-align: center;
}

.input-group { position: relative; }

.eye-icon {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    width: 22px;
    opacity: 0.9;
}

button {
    width: 100%;
    padding: 12px;
    background: #00ffcc;
    border: none;
    border-radius: 10px;
    font-weight: bold;
    cursor: pointer;
    margin-top: 15px;
    font-size: 16px;
}

button:hover { background: #00eebb; }

.error { color: #ff4747; font-weight:bold; margin-bottom:10px; }
.success { color: #00ff99; font-weight:bold; margin-bottom:10px; }

.strength-bar {
    height: 7px;
    width: 100%;
    margin-top: 5px;
    border-radius: 5px;
    background: #333;
}

.strength-fill {
    height: 7px;
    width: 0%;
    background: red;
    border-radius: 5px;
    transition: 0.4s;
}

.login-link {
    margin-top: 15px;
    display: block;
    color: #ffeb3b;
    text-decoration: none;
}
</style>
</head>
<body>
<div class="reg-box">
    <h2>Create Account</h2>

    <?php if ($error) echo "<div class='error'>$error</div>"; ?>
    <?php if ($success) echo "<div class='success'>$success</div>"; ?>

    <form method="POST">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>

        <!-- PASSWORD -->
        <div class="input-group">
            <input type="password" id="password" name="password" placeholder="Password" required>
            <svg class="eye-icon" id="togglePassword" viewBox="0 0 24 24" fill="black">
                <path d="M12 5C7 5 2.73 8.11 1 12c1.73 3.89 6 7 11 7s9.27-3.11 11-7c-1.73-3.89-6-7-11-7Zm0 11a4 4 0 1 1 0-8 4 4 0 0 1 0 8Z"/>
            </svg>
        </div>

        <!-- Password Strength -->
        <div class="strength-bar">
            <div class="strength-fill" id="strength"></div>
        </div>

        <!-- CONFIRM PASSWORD -->
        <div class="input-group">
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
            <svg class="eye-icon" id="toggleConfirm" viewBox="0 0 24 24" fill="black">
                <path d="M12 5C7 5 2.73 8.11 1 12c1.73 3.89 6 7 11 7s9.27-3.11 11-7c-1.73-3.89-6-7-11-7Zm0 11a4 4 0 1 1 0-8 4 4 0 0 1 0 8Z"/>
            </svg>
        </div>

        <select name="security_question" required>
            <option value="">Select a security question</option>
            <?php foreach ($questions as $q) echo "<option value='$q'>$q</option>"; ?>
        </select>

        <input type="text" name="security_answer" placeholder="Security Answer" required>

        <!-- CAPTCHA -->
        <label>Solve CAPTCHA:</label>
        <div class="captcha-box">
            <?php echo "$_SESSION[captcha_num1] + $_SESSION[captcha_num2] = ?"; ?>
        </div>
        <input type="text" name="captcha" placeholder="Enter answer" required>

        <button type="submit">Register</button>
    </form>

    <a href="login.php" class="login-link">Already have an account? Login</a>
</div>

<script>
document.getElementById("password").addEventListener("input", function () {
    let strength = document.getElementById("strength");
    let value = this.value;
    let score = 0;
    if (value.length >= 6) score++;
    if (/[A-Z]/.test(value)) score++;
    if (/[0-9]/.test(value)) score++;
    if (/[@#$%^&*!]/.test(value)) score++;
    let width = ["25%","50%","75%","100%"];
    let colors = ["red","orange","gold","lime"];
    strength.style.width = width[score-1] || "0%";
    strength.style.background = colors[score-1] || "red";
});

// Toggle password visibility
document.getElementById("togglePassword").onclick = function () {
    let field = document.getElementById("password");
    field.type = field.type === "password" ? "text" : "password";
};

document.getElementById("toggleConfirm").onclick = function () {
    let field = document.getElementById("confirm_password");
    field.type = field.type === "password" ? "text" : "password";
};
</script>
</body>
</html>
