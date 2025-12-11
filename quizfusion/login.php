<?php
session_start();
include 'config.php';

$error = "";
$show_shake = false;

// -----------------------------------------------------
// CAPTCHA FUNCTION
// -----------------------------------------------------
function generate_captcha() {
    $a = rand(2, 9);
    $b = rand(1, 9);
    
    $_SESSION['captcha_answer'] = $a + $b;
    $_SESSION['captcha_question'] = "$a + $b = ?";
}

// -----------------------------------------------------
// GENERATE CAPTCHA ONLY ON PAGE LOAD (NOT ON POST)
// -----------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    generate_captcha();
}

$captcha_question = $_SESSION['captcha_question'];


// -----------------------------------------------------
// LOGIN LOGIC
// -----------------------------------------------------
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $captcha = trim($_POST['captcha']);

    // -------------------------------
    // VALIDATIONS
    // -------------------------------
    if (empty($email) || empty($password)) {
        $error = "All fields are required!";
        $show_shake = true;
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
        $show_shake = true;
    }
    elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$%^&*!]).{6,}$/', $password)) {
        $error = "Password must be ≥6 chars, include uppercase, lowercase, number & special char!";
        $show_shake = true;
    }
    elseif ((int)$captcha !== (int)$_SESSION['captcha_answer']) { 
        $error = "Incorrect CAPTCHA!";
        $show_shake = true;

        // Regenerate new captcha for next attempt
        generate_captcha();
        $captcha_question = $_SESSION['captcha_question'];
    }
    else {

        // CAPTCHA correct — continue login
        $stmt = $con->prepare("SELECT id, name, password FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $name, $hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {

                // Login successful → clear CAPTCHA
                unset($_SESSION['captcha_answer'], $_SESSION['captcha_question']);

                $_SESSION['user_id'] = $id;
                $_SESSION['name'] = $name;

                header("Location: homepage.php");
                exit;
            } 
            else {
                $error = "Invalid password!";
                $show_shake = true;
            }
        } else {
            $error = "Email not found!";
            $show_shake = true;
        }

        $stmt->close();
    }
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>QuizFusion | Login</title>
<style>
    body { margin:0; font-family:Poppins; background:url('https://media.istockphoto.com/id/914788014/photo/businessman-using-tablet-and-set-up-network-connection-with-shield-guard-to-protected-from.jpg?b=1&s=612x612&w=0&k=20&c=3eCC74-Is7mJVf4UMdFwrLkCWqHPPnPO5DGJHR1HL_o=') no-repeat center center/cover; min-height:100vh; display:flex; justify-content:center; align-items:center;}
    .login-box { background: rgba(0,0,0,0.75); padding:40px 35px; border-radius:15px; width:350px; text-align:center; color:#fff; box-shadow:0 0 20px rgba(0,0,0,0.7); animation: <?php echo $show_shake ? 'shake 0.3s' : 'none'; ?>;}
    @keyframes shake {0%{transform:translateX(0);}25%{transform:translateX(-8px);}50%{transform:translateX(8px);}75%{transform:translateX(-8px);}100%{transform:translateX(0);}}
    h2 { margin-bottom:20px; }
    .input-group { position:relative; margin:12px 0; }
    input { width:100%; padding:12px 45px 12px 12px; border-radius:10px; border:none; outline:none; font-size:15px; box-sizing:border-box; }
    .eye-icon { position:absolute; right:12px; top:50%; transform:translateY(-50%); width:22px; height:22px; cursor:pointer; fill:#999; transition:0.3s; }
    .eye-icon:hover { fill:#fff; }
    .forgot-link { display:block; text-align:right; margin-top:3px; margin-bottom:12px; font-size:13px; color:#ffeb3b; text-decoration:none; }
    .forgot-link:hover { text-decoration:underline; }
    button { width:100%; padding:12px; background:#00ffcc; color:#000; font-weight:bold; border:none; border-radius:10px; cursor:pointer; transition:0.3s; }
    button:hover { background:#00eebb; }
    .error { margin-top:10px; color:#ff4747; font-weight:bold; }
    .register-link { margin-top:15px; display:block; color:#ffeb3b; text-decoration:none; }
    .register-link:hover { text-decoration:underline; }
    .captcha-box { margin-top:15px; margin-bottom:10px; text-align:left; font-weight:600; }
</style>
</head>
<body>

<div class="login-box">
    <h2>Login</h2>

    <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>

    <form action="" method="POST" id="loginForm">

        <input type="email" name="email" placeholder="Enter Email" required>

        <div class="input-group">
            <input type="password" id="password" name="password" placeholder="Enter Password" required>
            <svg id="togglePassword" class="eye-icon" viewBox="0 0 24 24">
                <path d="M12 5C7 5 2.73 8.11 1 12c1.73 3.89 6 
                    7 11 7s9.27-3.11 11-7c-1.73-3.89-6-7-11-7zm0 
                    12a5 5 0 1 1 0-10 5 5 0 0 1 0 10zm0-8a3 
                    3 0 1 0 0 6 3 3 0 0 0 0-6z"/>
            </svg>
        </div>

        <a href="forgot_password.php" class="forgot-link">Forgot Password?</a>

        <div class="captcha-box">
            CAPTCHA: <span style="color:#00ffcc"><?= $captcha_question ?></span>
        </div>

        <input type="number" name="captcha" placeholder="Solve the above" required>

        <button type="submit">Login</button>
    </form>

    <a href="register.php" class="register-link">New user? Register here</a>
</div>

<script>
const togglePassword = document.getElementById("togglePassword");
const passwordField = document.getElementById("password");

togglePassword.addEventListener("click", () => {
    const type = passwordField.type === "password" ? "text" : "password";
    passwordField.type = type;
    togglePassword.style.fill = type === "text" ? "#fff" : "#999";
});

// -------------------------------
// Client-side validation
// -------------------------------
document.getElementById("loginForm").addEventListener("submit", function(e){
    const email = this.email.value.trim();
    const password = this.password.value.trim();
    const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
    const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$%^&*!]).{6,}$/;

    if(!emailPattern.test(email)){
        alert("Please enter a valid email.");
        e.preventDefault();
        return false;
    }

    if(!passwordPattern.test(password)){
        alert("Password must be at least 6 characters and include uppercase, lowercase, number & special character.");
        e.preventDefault();
        return false;
    }
});
</script>

</body>
</html>
