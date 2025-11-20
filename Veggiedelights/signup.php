<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign Up | Veggiedelights</title>
  <style>
    * { box-sizing: border-box; }

    body {
      margin: 0;
      font-family: "Poppins", sans-serif;
      background: url('https://img.freepik.com/premium-photo/ingredients-recipe-wooden-background_1049143-28691.jpg') no-repeat center center/cover;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      position: relative;
      padding-top: 80px;
    }

    body::before {
      content: "";
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: linear-gradient(to bottom, rgba(0,0,0,0.4), rgba(0,0,0,0.1));
      z-index: 0;
    }

    header.navbar {
      width: 100%;
      background-color: #ff7b00;
      color: #fff;
      padding: 15px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: fixed;
      top: 0; left: 0;
      z-index: 10;
      box-shadow: 0 2px 10px rgba(0,0,0,0.15);
      height: 50px;
    }

    .navbar .logo a {
      font-size: 1.5rem;
      font-weight: 700;
      color: #fff;
      text-decoration: none;
    }

    .signup-container {
      position: relative;
      z-index: 1;
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      padding: 40px;
      width: 100%;
      max-width: 420px;
      text-align: left;
      backdrop-filter: blur(10px);
    }

    .signup-container h1 {
      color: #ff7b00;
      font-size: 2rem;
      text-align: center;
      margin-bottom: 25px;
    }

    form { display: flex; flex-direction: column; gap: 18px; }

    input[type="text"],
    input[type="email"],
    input[type="password"],
    select {
      width: 100%;
      padding: 10px 14px;
      border: 1px solid #ccc;
      border-radius: 10px;
      font-size: 1rem;
      outline: none;
      transition: border-color 0.2s, box-shadow 0.2s;
    }

    input:focus, select:focus {
      border-color: #ffa94d;
      box-shadow: 0 0 0 3px rgba(255,179,71,0.3);
    }

    .password-wrapper {
      position: relative;
    }

    .toggle-password {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      background: transparent;
      border: none;
      cursor: pointer;
      padding: 4px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .toggle-password svg {
      width: 22px;
      height: 22px;
      fill: #666;
      transition: fill 0.2s;
    }

    .toggle-password:hover svg {
      fill: #ff7b00;
    }

    .password-error {
      color: red;
      font-size: 0.85rem;
      display: none;
    }

    button[type="submit"] {
      background: #ff7b00;
      color: #fff;
      border: none;
      border-radius: 10px;
      padding: 12px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.3s;
      margin-top: 10px;
    }

    button[type="submit"]:hover:enabled { background: #ff8f26; }
    button[type="submit"]:disabled { background: #ccc; cursor: not-allowed; }

    .login-link {
      margin-top: 15px;
      font-size: 0.9rem;
      color: #555;
      text-align: center;
    }

    .login-link a {
      color: #ff7b00;
      text-decoration: none;
      font-weight: 600;
    }

    .login-link a:hover { text-decoration: underline; }

  </style>
</head>
<body>
  <header class="navbar">
    <div class="logo"><a href="index.php">Veggiedelights</a></div>
  </header>

  <div class="signup-container">
    <h1>👩‍🍳 Create an Account</h1>
    <form id="signupForm">
      <input type="text" name="name" placeholder="Your Name" required />
      <input type="email" name="email" placeholder="you@example.com" required />

      <div class="password-wrapper">
        <input type="password" name="password" placeholder="Password" required id="password" />
        <button type="button" class="toggle-password" data-target="password">
          <!-- Eye SVG -->
          <svg viewBox="0 0 24 24">
            <path d="M12 5C7 5 2.73 8.11 1 12c1.73 3.89 6 7 11 7s9.27-3.11 11-7c-1.73-3.89-6-7-11-7zm0 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10zm0-8a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/>
          </svg>
        </button>
      </div>

      <div class="password-wrapper">
        <input type="password" name="confirmpassword" placeholder="Confirm Password" required id="confirmpassword" />
        <button type="button" class="toggle-password" data-target="confirmpassword">
          <!-- Eye SVG -->
          <svg viewBox="0 0 24 24">
            <path d="M12 5C7 5 2.73 8.11 1 12c1.73 3.89 6 7 11 7s9.27-3.11 11-7c-1.73-3.89-6-7-11-7zm0 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10zm0-8a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/>
          </svg>
        </button>
      </div>

      <div class="password-error" id="passwordError">Passwords do not match</div>

      <select name="security_question" required>
        <option value="">-- Select a question --</option>
        <option value="What is your favorite recipe?">What is your favorite recipe?</option>
        <option value="What is your favorite ingredient?">What is your favorite ingredient?</option>
        <option value="Who taught you to cook?">Who taught you to cook?</option>
      </select>

      <input type="text" name="security_answer" placeholder="Your Answer" required />

      <button type="submit" id="signupBtn">Sign Up</button>
      <p class="login-link">
        Already have an account? <a href="login.php">Log in</a>
      </p>
    </form>
  </div>

  <script>
    // Toggle password show/hide
    document.querySelectorAll('.toggle-password').forEach(btn => {
      btn.addEventListener('click', () => {
        const targetId = btn.getAttribute('data-target');
        const input = document.getElementById(targetId);
        const svg = btn.querySelector('svg');
        if(input.type === 'password'){
          input.type = 'text';
          svg.innerHTML = '<path d="M12 5C7 5 2.73 8.11 1 12c1.73 3.89 6 7 11 7s9.27-3.11 11-7c-1.73-3.89-6-7-11-7zm0 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10z" />';
        } else {
          input.type = 'password';
          svg.innerHTML = '<path d="M12 5C7 5 2.73 8.11 1 12c1.73 3.89 6 7 11 7s9.27-3.11 11-7c-1.73-3.89-6-7-11-7zm0 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10zm0-8a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/>';
        }
      });
    });

    // Password match validation
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirmpassword');
    const passwordError = document.getElementById('passwordError');
    const signupBtn = document.getElementById('signupBtn');

    function validatePasswords() {
      if(password.value && confirmPassword.value && password.value !== confirmPassword.value){
        passwordError.style.display = 'block';
        signupBtn.disabled = true;
      } else {
        passwordError.style.display = 'none';
        signupBtn.disabled = false;
      }
    }

    password.addEventListener('input', validatePasswords);
    confirmPassword.addEventListener('input', validatePasswords);

    // Submit form via AJAX
    const form = document.getElementById('signupForm');
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      const formData = new FormData(form);
      formData.append('ajax', '1'); // flag for PHP

      fetch('signups.php', {
        method: 'POST',
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        alert(data.message);
        if(data.status === 'success'){
          window.location.href = 'login.php';
        }
      })
      .catch(err => console.error('Error:', err));
    });
  </script>
</body>
</html>
