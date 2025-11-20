<?php
session_start();
include 'config.php'; // Your DB connection

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Fetch user from DB
    $stmt = $con->prepare("SELECT * FROM signup WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $user['role']; // user or admin

            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "Email not registered!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login | Veggiedelights</title>
<style>
  /* --- Styles (unchanged from your original) --- */
  body, html { height: 100%; margin: 0; font-family: 'Arial', sans-serif; }
  body { background: url('https://media.istockphoto.com/id/1392224785/photo/cookbook-with-ingredients-on-the-table-recipe-book.jpg?s=612x612&w=0&k=20&c=2xrQymhTQV_1i9P9jioHjV4n3rHdYevuKdMH77mZgjw=') no-repeat center center fixed; background-size: cover; display: flex; justify-content: center; align-items: center; position: relative; }
  body::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.85); z-index:0; }
  .login-container { position: relative; z-index:1; width: 380px; background: rgba(255,255,255,0.95); padding:40px 30px; border-radius:15px; box-shadow:0 6px 25px rgba(0,0,0,0.25); text-align:center; }
  .login-container h2 { margin-bottom:25px; color:#ff7b00; font-size:28px; }
  input[type="email"], input[type="password"] { width:100%; padding:12px 15px; margin:10px 0; border:1px solid #ccc; border-radius:10px; font-size:16px; box-sizing:border-box; }
  input:focus { border-color:#ff7b00; outline:none; }
  .password-field { position:relative; margin-top:10px; }
  .toggle-password { position:absolute; right:12px; top:50%; transform:translateY(-50%); cursor:pointer; width:24px; height:24px; fill:#888; transition:fill 0.2s, transform 0.2s; }
  .toggle-password:hover { fill:#ff7b00; transform:translateY(-50%) scale(1.1); }
  button { width:100%; padding:14px; background:#ff7b00; color:white; border:none; border-radius:10px; cursor:pointer; font-size:17px; font-weight:bold; margin-top:20px; transition: background 0.3s, transform 0.2s; }
  button:hover { background:#e96b00; transform: scale(1.03); }
  .error { color:red; margin-bottom:15px; font-weight:bold; }
  .links { display:flex; justify-content:space-between; margin-top:18px; }
  .links a { text-decoration:none; color:#ff7b00; font-weight:bold; font-size:14px; }
  .links a:hover { text-decoration:underline; }
  .back-link { display:block; margin-top:20px; text-decoration:none; color:#333; font-weight:bold; }
  .back-link:hover { color:#ff7b00; }
</style>
</head>
<body>
  <div class="login-container">
    <h2>🔒 Login</h2>

    <?php if (!empty($error)): ?>
      <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
      <input type="email" name="email" placeholder="Email" required>

      <div class="password-field">
        <input type="password" name="password" id="password" placeholder="Password" required>
        <svg id="eyeOpen" class="toggle-password" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
          <path d="M12 5C7 5 2.73 8.11 1 12c1.73 3.89 6 7 11 7s9.27-3.11 11-7c-1.73-3.89-6-7-11-7zm0 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10z"/>
          <circle cx="12" cy="12" r="2.5"/>
        </svg>
        <svg id="eyeClosed" class="toggle-password" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="display:none;">
          <path d="M12 6c3.89 0 7.25 2.24 8.94 6-1.69 3.76-5.05 6-8.94 6-3.89 0-7.25-2.24-8.94-6C4.75 8.24 8.11 6 12 6zm0-2C7 4 2.73 7.11 1 11c1.73 3.89 6 7 11 7s9.27-3.11 11-7c-1.73-3.89-6-7-11-7zM4.27 3L3 4.27l3.18 3.18C4.73 8.24 3.27 9.99 2.06 12c1.63 2.85 4.49 5.27 8.08 5.9l1.42 1.42L21 19.73 19.73 18 4.27 3z"/>
        </svg>
      </div>

      <button type="submit">Login</button>
    </form>

    <div class="links">
      <a href="signup.php">Don't have an account? Signup</a>
      <a href="forgot_password.php">Forgot Password?</a>
    </div>

    <a href="index.php" class="back-link">← Back to Home</a>
  </div>

  <script>
    const passwordInput = document.getElementById('password');
    const eyeOpen = document.getElementById('eyeOpen');
    const eyeClosed = document.getElementById('eyeClosed');

    eyeOpen.addEventListener('click', () => {
      passwordInput.type = 'text';
      eyeOpen.style.display = 'none';
      eyeClosed.style.display = 'block';
    });

    eyeClosed.addEventListener('click', () => {
      passwordInput.type = 'password';
      eyeClosed.style.display = 'none';
      eyeOpen.style.display = 'block';
    });
  </script>
</body>
</html>
