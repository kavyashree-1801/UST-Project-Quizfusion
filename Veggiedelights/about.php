<?php
session_start();
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>About Us | Veggiedelights</title>
  <link rel="stylesheet" href="css/styles.css" />
  <style>
    /* 🌿 BASIC BODY */
    body {
      margin: 0;
      font-family: "Poppins", sans-serif;
      background: #f8f8f8;
      color: #333;
    }

    /* 🔶 ORANGE NAVBAR */
    .navbar {
      background: #ff7b00;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 12px 40px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    /* Logo Section */
    .logo a {
      text-decoration: none;
      font-size: 1.8em;
      font-weight: bold;
      color: #fff;
    }

    /* Navigation Links */
    nav {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 25px;
    }

    nav a {
      text-decoration: none;
      color: #fffbea;
      font-weight: bold;
      font-size: 1em;
      padding: 6px 10px;
      transition: background 0.3s ease, color 0.3s ease;
      border-radius: 5px;
    }

    nav a:hover,
    nav a.active {
      background: #ff9933;
      color: #fffbea;
    }

    /* Dropdown Menu */
    .dropdown {
      position: relative;
      display: inline-block;
    }

    .dropdown > a::after {
      content: " ▾";
      font-size: 0.8em;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      top: 120%;
      left: 0;
      background-color: #fff;
      min-width: 160px;
      border-radius: 6px;
      box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.1);
      z-index: 999;
    }

    .dropdown-content a {
      color: #333;
      padding: 10px 15px;
      display: block;
      text-align: left;
      text-decoration: none;
      font-weight: normal;
      border-radius: 4px;
    }

    .dropdown-content a:hover {
      background-color: #ffeed9;
      color: #ff7b00;
    }

    .dropdown:hover .dropdown-content {
      display: block;
    }

    /* Auth & Theme Buttons */
    .auth-links {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .welcome {
      color: #fff;
      font-weight: bold;
      font-size: 0.95em;
    }

    .acc {
      font-weight: bold;
      color: #fff;
    }

    #themeToggle {
      background: none;
      border: 2px solid #fff;
      color: #fff;
      font-size: 1.1em;
      border-radius: 50%;
      width: 34px;
      height: 34px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    #themeToggle:hover {
      background: rgba(255, 255, 255, 0.2);
    }

    /* 🌱 ABOUT SECTION */
    .about {
      max-width: 1100px;
      margin: 60px auto;
      padding: 20px;
      text-align: center;
      line-height: 1.8;
    }

    .about h1 {
      font-size: 2.6em;
      color: #2c3e50;
      margin-bottom: 30px;
    }

    .brand {
      color: #ff7b00;
    }

    .about-content {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
      gap: 30px;
    }

    .about-text {
      flex: 1;
      text-align: left;
      font-size: 1.1em;
    }

    .about-image {
      flex: 1;
      text-align: center;
    }

    .about-image img {
      width: 100%;
      max-width: 400px;
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }

    .about-image img:hover {
      transform: scale(1.05);
    }

    /* 🌍 VALUES SECTION */
    .about-values {
      margin-top: 60px;
    }

    .about-values h2 {
      color: #2c3e50;
      font-size: 2em;
      margin-bottom: 30px;
    }

    .value-cards {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 25px;
    }

    .value-card {
      background: #fff8f2;
      border: 1px solid #ffe0c0;
      border-radius: 15px;
      padding: 25px;
      width: 280px;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .value-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    }

    .value-card h3 {
      color: #ff7b00;
      margin-bottom: 10px;
    }

    /* 👩‍🍳 CREATOR SECTION */
    .creator {
      margin-top: 80px;
      text-align: center;
    }

    .creator img {
      width: 140px;
      height: 140px;
      border-radius: 50%;
      object-fit: cover;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
      margin-bottom: 15px;
    }

    .creator h3 {
      color: #ff7b00;
      margin: 10px 0 5px;
    }

    .creator p {
      max-width: 700px;
      margin: 0 auto;
      font-size: 1.05em;
      color: #555;
    }

    /* 🌘 DARK THEME */
    .dark-theme {
      background: #1e1e1e;
      color: #eee;
    }

    .dark-theme .navbar {
      background: #ff7b00;
    }

    .dark-theme nav a {
      color: #fff;
    }

    .dark-theme .value-card {
      background: #2a2a2a;
      border-color: #333;
      color: #eee;
    }

    footer {
      text-align: center;
      padding: 20px;
      background: #222;
      color: #fff;
      margin-top: 60px;
    }

    @media (max-width: 768px) {
      .navbar {
        flex-direction: column;
        gap: 10px;
      }

      nav {
        flex-wrap: wrap;
        justify-content: center;
        gap: 15px;
      }

      .about-content {
        flex-direction: column;
        text-align: center;
      }

      .about-text {
        text-align: center;
      }
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
        <a href="#">Categories</a>
        <div class="dropdown-content">
          <a href="northindian.php">North Indian</a>
          <a href="southindian.php">South Indian</a>
          <a href="chinese.php">Chinese</a>
          <a href="italian.php">Italian</a>
        </div>
      </div>
      <a href="my_recipes.php">My Recipes</a>
      <a href="about.php" class="active">About</a>
      <a href="contact.php">Contact</a>
      <a href="feedback.php">Feedback</a>
    </nav>

    <div class="auth-links">
      <?php
      if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
          echo '<span class="welcome">👋 ' . htmlspecialchars($_SESSION['email']) . '</span>';
          echo '<a href="logout.php" class="nav-link"><span class="acc">Logout</span></a>';
      } else {
          echo '<a href="login.php" class="nav-link"><span class="acc">Login</span></a>';
      }
      ?>
      <button id="themeToggle">🌙</button>
    </div>
  </header>

  <!-- 🥗 About Section -->
  <main>
    <section class="about">
      <h1>About <span class="brand">Veggiedelights</span></h1>

      <div class="about-content">
        <div class="about-text">
          <p>
            Welcome to <strong>Veggiedelights</strong> — your happy corner for everything vegetarian! 🌿  
            We believe that good food doesn’t need meat to be delicious. From traditional Indian favorites 
            to modern global creations, our mission is to celebrate the joy of vegetarian cooking.
          </p>

          <p>
            At Veggiedelights, you can <strong>explore recipes</strong> from all over India and beyond — 
            discover spicy <em>North Indian curries</em>, comforting <em>South Indian meals</em>, 
            or even quick <em>Chinese stir-fries</em> and <em>Italian pastas</em>.  
            Every recipe is crafted to be simple, wholesome, and bursting with flavor.
          </p>

          <p>
            🍲 <strong>Share your own recipes</strong> with the community,  
            ❤️ <strong>save your favorites</strong> for later, and  
            👩‍🍳 <strong>learn from fellow food lovers</strong> across the world.
          </p>

          <p>
            Together, let’s make healthy eating an everyday delight — because every meal deserves 
            to be a celebration of taste and freshness! 🥦🍅🥕
          </p>
        </div>

        <div class="about-image">
          <img src="https://res.cloudinary.com/hz3gmuqw6/image/upload/c_fill,f_auto,q_60,w_750/v1/classpop/676136f4c8c7a" alt="Vegetarian dishes" />
        </div>
      </div>

      <div class="about-values">
        <h2>Our Values</h2>
        <div class="value-cards">
          <div class="value-card">
            <h3>🌱 Freshness</h3>
            <p>We believe in using natural, seasonal, and wholesome ingredients to create dishes full of life and flavor.</p>
          </div>
          <div class="value-card">
            <h3>💚 Community</h3>
            <p>Cooking is more fun when shared! Veggiedelights connects food lovers who inspire and learn from each other.</p>
          </div>
          <div class="value-card">
            <h3>🌎 Sustainability</h3>
            <p>We promote plant-based cooking as a way to care for both our health and our planet.</p>
          </div>
        </div>
      </div>

      <div class="creator">
        <img src="https://coreldrawdesign.com/resources/previews/preview-indian-women-wearing-orange-saree-hd-high-qulaity-png-download-for-free-1746013776.webp" alt="Creator Image">
        <h3>Meet the Creator</h3>
        <p>
          Hi! I'm <strong>Asha</strong> — a passionate food lover and the heart behind Veggiedelights.  
          My goal is to make vegetarian cooking accessible, exciting, and full of creativity.  
          Thank you for being part of this journey toward a greener, healthier plate! 🌿✨
        </p>
      </div>
    </section>
  </main>

  <!-- 👣 Footer -->
  <footer>
    <p>Made with ❤️ by You | © 2025 Veggiedelights</p>
  </footer>

  <!-- 🌙 Theme Toggle -->
  <script>
    const toggle = document.getElementById('themeToggle');
    const body = document.body;

    if (localStorage.getItem('theme') === 'dark') {
      body.classList.add('dark-theme');
      toggle.textContent = '☀️';
    }

    toggle.addEventListener('click', () => {
      body.classList.toggle('dark-theme');
      if (body.classList.contains('dark-theme')) {
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
