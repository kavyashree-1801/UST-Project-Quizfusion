<?php
session_start();
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact Us | Veggiedelights</title>
  <link rel="stylesheet" href="css/styles.css" />
  <style>
    /* Reset & Body */
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f5f5f5;
      padding-top: 70px; /* navbar height */
      transition: background 0.3s ease, color 0.3s ease;
    }

    /* Fixed Navbar */
    .navbar {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      background: #ff6600;
      color: white;
      z-index: 1000;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 20px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }

    .navbar .logo a {
      color: white;
      text-decoration: none;
      font-size: 1.5rem;
      font-weight: bold;
    }

    .navbar nav a {
      color: white;
      margin: 0 10px;
      text-decoration: none;
      transition: 0.3s;
    }

    .navbar nav a:hover {
      text-decoration: underline;
    }

    /* Dropdown Styling */
    .navbar .dropdown {
      position: relative;
      display: inline-block;
    }

    .navbar .dropdown-content {
      display: none;
      position: absolute;
      background: #ff6600; /* Orange background for dropdown */
      min-width: 150px;
      border-radius: 6px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
      z-index: 1;
    }

    .navbar .dropdown-content a {
      color: white; /* White text for contrast */
      padding: 10px 14px;
      display: block;
      text-decoration: none;
      transition: background 0.3s ease;
    }

    .navbar .dropdown-content a:hover {
      background: #ff944d; /* lighter orange on hover */
    }

    .navbar .dropdown:hover .dropdown-content {
      display: block;
    }

    .auth-links {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .auth-links .welcome {
      font-size: 0.9rem;
    }

    /* Contact Container */
    .contact-container {
      max-width: 650px;
      margin: 40px auto;
      padding: 40px;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      transition: background 0.3s ease, color 0.3s ease;
    }

    .contact-container h1 {
      text-align: center;
      margin-bottom: 30px;
      color: #ff6600;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    input, textarea {
      width: 100%;
      padding: 12px;
      border: 2px solid #ccc;
      border-radius: 10px;
      font-size: 1rem;
      transition: all 0.3s ease;
    }

    input:focus, textarea:focus {
      outline: none;
      border-color: #ff6600;
      box-shadow: 0 0 6px rgba(255,102,0,0.4);
    }

    textarea {
      min-height: 120px;
      resize: vertical;
    }

    button {
      padding: 12px;
      border: none;
      background: #ff6600;
      color: #fff;
      font-weight: bold;
      font-size: 1.1rem;
      border-radius: 10px;
      cursor: pointer;
      transition: background 0.3s ease, transform 0.2s ease;
    }

    button:hover {
      background: #ff944d;
      transform: scale(1.03);
    }

    .message {
      text-align: center;
      font-weight: 600;
      margin-top: 15px;
    }

    .success { color: #2e7d32; }
    .error { color: #d32f2f; }

    /* Dark Theme */
    body.dark-theme {
      background: #121212;
      color: #eee;
    }

    body.dark-theme .contact-container {
      background: #1e1e1e;
      color: #eee;
    }

    body.dark-theme input,
    body.dark-theme textarea {
      background: #2b2b2b;
      color: #eee;
      border-color: #444;
    }

    body.dark-theme input:focus,
    body.dark-theme textarea:focus {
      border-color: #ff6600;
      box-shadow: 0 0 6px rgba(255,102,0,0.4);
    }

    body.dark-theme button {
      background: #ff6600;
    }

    body.dark-theme button:hover {
      background: #ff944d;
    }
  </style>
</head>
<body>
  <!-- 🌐 Navigation Bar -->
  <header class="navbar">
    <div class="logo"><a href="index.php">🥘 Veggiedelights</a></div>
    
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
      <a href="contact.php" class="active">Contact</a>
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

  <!-- ✨ Contact Form Section -->
  <main>
    <div class="contact-container">
      <h1>📬 Contact Us</h1>

      <?php
        if (isset($_GET['success'])) {
            echo "<p class='message success'>Thank you! Your message has been sent.</p>";
        } elseif (isset($_GET['error'])) {
            if ($_GET['error'] == 'empty') echo "<p class='message error'>Please fill in all fields.</p>";
            elseif ($_GET['error'] == 'invalid_email') echo "<p class='message error'>Invalid email format.</p>";
            elseif ($_GET['error'] == 'database') echo "<p class='message error'>Something went wrong. Try again.</p>";
        }
      ?>

      <form method="POST" action="save_contact.php">
        <input type="text" name="name" placeholder="Your Name" required />
        <input type="email" name="email" placeholder="Your Email" required />
        <input type="text" name="subject" placeholder="Subject" required />
        <textarea name="message" placeholder="Your Message" required></textarea>
        <button type="submit">Send Message</button>
      </form>
    </div>
  </main>

  <!-- 👣 Footer -->
  <footer>
    <p style="text-align:center; margin:20px;">Made with ❤️ by You | © 2025 Veggiedelights</p>
  </footer>

  <!-- 🌙 Theme Toggle Script -->
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
</body>
</html>
