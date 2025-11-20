<?php
session_start();
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Recipe Categories | Veggiedelights</title>
  <link rel="stylesheet" href="css/cstyles.css" />
  <style>
    /* 🌈 Orange Navbar Styling */
    .navbar {
      background-color: #ff8c00; /* bright orange */
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 30px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }

    .navbar a {
      color: white;
      text-decoration: none;
      margin: 0 12px;
      font-weight: 500;
      transition: 0.3s;
    }

    .navbar a:hover {
      text-decoration: underline;
    }

    .logo a {
      font-weight: bold;
      font-size: 22px;
      color: white;
    }

    /* Dropdown Menu */
    .dropdown {
      position: relative;
      display: inline-block;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #ffa733; /* lighter orange for dropdown */
      min-width: 160px;
      box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
      z-index: 1;
      border-radius: 5px;
      overflow: hidden;
    }

    .dropdown-content a {
      color: white;
      padding: 10px 15px;
      text-decoration: none;
      display: block;
      transition: background-color 0.3s;
    }

    .dropdown-content a:hover {
      background-color: #ff8c00; /* darker on hover */
    }

    .dropdown:hover .dropdown-content {
      display: block;
    }

    /* Auth links and theme toggle */
    .auth-links a {
      color: white;
      margin-left: 10px;
      font-weight: 500;
    }

    .auth-links button {
      background: transparent;
      border: none;
      color: white;
      font-size: 18px;
      cursor: pointer;
      margin-left: 10px;
    }

    .user-greet {
      margin-right: 10px;
      font-weight: 500;
    }
  </style>
</head>
<body>

  <!-- 🌐 Navbar -->
  <header class="navbar">
    <div class="logo"><a href="index.php">🍳 Veggiedelights</a></div>
    <nav>
      <a href="index.php">Home</a>

      <!-- Categories Dropdown -->
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
          echo '<span class="user-greet">👋 ' . htmlspecialchars($_SESSION['email']) . '</span>';
          echo '<a href="logout.php">Logout</a>';
      } else {
          echo '<a href="login.php">Login</a>';
      }
      ?>
      <button id="themeToggle">🌙</button>
    </div>
  </header>

  <!-- 🌸 Page Header -->
  <section class="page-header">
    <h1>Recipe Categories</h1>
    <p>Explore mouthwatering recipes from different cuisines!</p>
  </section>

  <!-- 🍲 Category Cards -->
  <section class="category-container">
    <div class="category-card">
      <img src="https://assets.vogue.com/photos/63d169f727f1d528635b4287/3:2/w_3630,h_2420,c_limit/GettyImages-1292563627.jpg" alt="South Indian">
      <h2>South Indian</h2>
      <a href="southindian.php" class="btn">View Recipes</a>
    </div>

    <div class="category-card">
      <img src="https://hometriangle.com/blogs/content/images/2024/03/Catering-Ideas-Food-Suggestions-For-North-Indian-Weddings.jpg" alt="North Indian">
      <h2>North Indian</h2>
      <a href="northindian.php" class="btn">View Recipes</a>
    </div>

    <div class="category-card">
      <img src="https://img.freepik.com/premium-photo/set-assorted-chinese-food-table-with-female-hand-holding-chopsticks-from-full-festive-table-with-all-traditional-chinese-dishes-asian-style-dinner-buffet-top-view_92134-561.jpg?semt=ais_hybrid&w=740&q=80" alt="Chinese">
      <h2>Chinese</h2>
      <a href="chinese.php" class="btn">View Recipes</a>
    </div>

    <!-- 🇮🇹 Italian Category -->
    <div class="category-card">
      <img src="https://img.freepik.com/free-photo/top-view-table-full-delicious-food-assortment_23-2149141339.jpg?semt=ais_hybrid&w=740&q=80" alt="Italian">
      <h2>Italian</h2>
      <a href="italian.php" class="btn">View Recipes</a>
    </div>
  </section>

  <!-- 🔙 Back Button -->
  <a href="index.php" class="back-btn">← Back to Home</a>

  <!-- 👣 Footer -->
  <footer>
    <p>&copy; 2025 Veggiedelights | All Rights Reserved</p>
  </footer>

  <!-- 💡 Theme Toggle Script -->
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
