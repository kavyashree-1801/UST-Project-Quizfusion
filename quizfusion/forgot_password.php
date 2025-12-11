<?php
session_start();
include 'config.php';

$error = "";
$question = "";

// Step 1: Check if email is submitted to fetch security question
if (isset($_POST['email']) && !isset($_POST['answer'])) {
    $email = trim($_POST['email']);

    $stmt = $con->prepare("SELECT security_question FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($question);
        $stmt->fetch();
        $_SESSION['reset_email'] = $email; // store email for next step
    } else {
        $error = "Email not found!";
    }
    $stmt->close();
}

// Step 2: Verify answer and redirect to reset password
if (isset($_POST['answer'])) {
    $answer = trim($_POST['answer']);
    $email = $_SESSION['reset_email'] ?? '';

    $stmt = $con->prepare("SELECT id, security_answer FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $hash_answer);
        $stmt->fetch();

        if (password_verify($answer, $hash_answer)) {
            $_SESSION['reset_user'] = $id;
            header("Location: reset_password.php");
            exit;
        } else {
            $error = "Incorrect answer!";
        }
    } else {
        $error = "Email not found!";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Forgot Password</title>
<style>
body { 
    font-family: 'Poppins', sans-serif; 
    margin: 0; 
    display: flex; 
    justify-content: center; 
    align-items: center; 
    min-height: 100vh; 
    background: url('https://www.shutterstock.com/shutterstock/videos/3502946609/thumb/4.jpg?ip=x480') no-repeat center center/cover;
}

.overlay {
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.6);
    z-index: 1;
}

.box { 
    position: relative;
    z-index: 2;
    width: 380px; 
    background: rgba(0,0,0,0.75); 
    padding: 30px; 
    border-radius: 12px; 
    text-align: center; 
    color: #fff; 
    box-shadow: 0 0 20px rgba(0,0,0,0.7);
}

.input-group { position: relative; }

input { 
    width: 100%; 
    padding: 12px; 
    margin: 10px 0; 
    border-radius: 8px; 
    border: none; 
    outline: none; 
    box-sizing: border-box;
}

.eye-icon {
    position: absolute;
    right: 12px;
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
    border-radius: 8px; 
    font-weight: bold; 
    cursor: pointer; 
    margin-top: 10px;
}

button:hover { background: #00eebb; }

.error { color: #ff4747; font-weight: bold; margin-bottom: 10px; }
</style>
</head>
<body>
<div class="overlay"></div>
<div class="box">

<h2>Forgot Password</h2>

<?php if($error) echo "<div class='error'>$error</div>"; ?>

<form method="POST">

    <?php if(empty($question)): ?>
        <input type="email" name="email" placeholder="Enter Email" required>
        <button type="submit">Next</button>
    <?php else: ?>
        <p><b>Security Question:</b><br><?php echo $question; ?></p>
        <div class="input-group">
            <input type="text" name="answer" id="answer" placeholder="Enter Security Answer" required>
            <svg class="eye-icon" id="toggleAnswer" viewBox="0 0 24 24" fill="black">
                <path d="M12 5C7 5 2.73 8.11 1 12c1.73 3.89 6 7 11 7s9.27-3.11 11-7c-1.73-3.89-6-7-11-7Zm0 11a4 4 0 1 1 0-8 4 4 0 0 1 0 8Z"/>
            </svg>
        </div>
        <button type="submit">Verify</button>
    <?php endif; ?>

</form>

</div>

<script>
// Eye toggle for security answer
const toggleAnswer = document.getElementById("toggleAnswer");
if(toggleAnswer) {
    toggleAnswer.onclick = function() {
        const field = document.getElementById("answer");
        field.type = field.type === "password" ? "text" : "password";
    };
}
</script>

</body>
</html>
