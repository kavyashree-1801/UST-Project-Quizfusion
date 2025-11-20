<?php
session_start();
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Feedback | Veggiedelights</title>
  <link rel="stylesheet" href="css/styles.css">
  <style>
    /* 🌿 Feedback Page Styling */
    main {
      max-width: 700px;
      margin: 50px auto;
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    h1 {
      text-align: center;
      color: #ff8c00;
      margin-bottom: 25px;
    }

    p.subtext {
      text-align: center;
      margin-bottom: 30px;
      color: #555;
      font-size: 1.05rem;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 18px;
    }

    label {
      font-weight: 600;
      color: #333;
    }

    input[type="text"],
    input[type="email"],
    textarea,
    select {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 1rem;
      transition: border-color 0.2s ease;
    }

    input:focus,
    textarea:focus,
    select:focus {
      border-color: #ff8c00;
      outline: none;
      box-shadow: 0 0 3px rgba(255,140,0,0.4);
    }

    textarea {
      resize: vertical;
    }

    button {
      background: #ff8c00;
      color: white;
      padding: 14px;
      font-size: 1rem;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
      transition: background 0.3s ease;
    }

    button:hover {
      background: #e67300;
    }

    .success {
      background: #e6ffe6;
      color: #007a00;
      border-left: 4px solid #00a000;
      padding: 12px;
      margin-bottom: 15px;
      border-radius: 6px;
      display: none;
    }

    .error {
      background: #ffe6e6;
      color: #a00000;
      border-left: 4px solid #ff4d4d;
      padding: 12px;
      margin-bottom: 15px;
      border-radius: 6px;
      display: none;
    }
  </style>
</head>
<body>
  <!-- 🌐 Navigation Bar -->
  <header class="navbar">
    <div class="logo"><a href="index.php">🥘veggiedelights</a></div>
    
    <nav>
      <a href="index.php">Home</a>
      <div class="dropdown">
        <a href="#">Categories ▾</a>
        <div class="dropdown-content">
          <a href="northindian.php">North Indian</a>
          <a href="southindian.php">South Indian</a>
          <a href="chinese.php">Chinese</a>
          <a href="italian.php">Italian</a>
        </div>
      </div>
      <a href="my_recipes.php">My Recipes</a>
      <a href="about.php">About</a>
      <a href="contact.php">Contact</a>
      <a href="feedback.php">Feedback</a>
    </nav>

    <div class="auth-links">
      <?php
      if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
          echo '<span class="welcome">👋 Welcome, ' . htmlspecialchars($_SESSION['email']) . '</span>';
          echo '<a href="logout.php" class="nav-link"><span class="acc">Logout</span></a>';
      } else {
          echo '<a href="login.php" class="nav-link"><span class="acc">Login</span></a>';
      }
      ?>
      <button id="themeToggle">🌙</button>
    </div>
  </header>

  <!-- 💬 Feedback Form Section -->
  <main>
    <h1>💬 We Value Your Feedback!</h1>
    <p class="subtext">Share your thoughts and help us make Veggiedelights even better 🌱</p>

    <div class="success" id="successMsg">✅ Thank you for your feedback!</div>
    <div class="error" id="errorMsg">⚠️ Please fill out all fields correctly.</div>

    <form id="feedbackForm" method="post" action="save_feedback.php">
      <div>
        <label for="name">Your Name</label>
        <input type="text" id="name" name="name" placeholder="Enter Your Name" required>
      </div>

      <div>
        <label for="email">Your Email</label>
        <input type="email" id="email" name="email" placeholder="Enter your Email" required>
      </div>

      <div>
        <label for="rating">Your Rating</label>
        <select id="rating" name="rating" required>
          <option value="">Select Rating</option>
          <option value="5">⭐⭐⭐⭐⭐ - Excellent</option>
          <option value="4">⭐⭐⭐⭐ - Good</option>
          <option value="3">⭐⭐⭐ - Average</option>
          <option value="2">⭐⭐ - Poor</option>
          <option value="1">⭐ - Very Poor</option>
        </select>
      </div>

      <div>
        <label for="message">Your Feedback</label>
        <textarea id="message" name="message" rows="5" placeholder="Tell us about your experience..." required></textarea>
      </div>

      <button type="submit">📨 Submit Feedback</button>
    </form>
  </main>

  <!-- 👣 Footer -->
  <footer>
    <p>Made with ❤️ by You | © 2025 My Recipe Book</p>
  </footer>

  <!-- 🌗 Theme Toggle Script -->
  <script>
    const toggle = document.getElementById('themeToggle');
    const body = document.body;

    if(localStorage.getItem('theme') === 'dark') {
      body.classList.add('dark-theme');
      toggle.textContent = '☀️';
    }

    toggle.addEventListener('click', () => {
      body.classList.toggle('dark-theme');
      if(body.classList.contains('dark-theme')){
        localStorage.setItem('theme', 'dark');
        toggle.textContent = '☀️';
      } else {
        localStorage.setItem('theme', 'light');
        toggle.textContent = '🌙';
      }
    });
  </script>

  <!-- ✅ Optional JS for Instant Feedback -->
  <script>
    const form = document.getElementById('feedbackForm');
    const successMsg = document.getElementById('successMsg');
    const errorMsg = document.getElementById('errorMsg');

    form.addEventListener('submit', (e) => {
      if(!form.checkValidity()) {
        e.preventDefault();
        successMsg.style.display = 'none';
        errorMsg.style.display = 'block';
      } else {
        successMsg.style.display = 'block';
        errorMsg.style.display = 'none';
      }
    });
  </script>
</body>
</html>
