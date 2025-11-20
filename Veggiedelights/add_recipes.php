<?php
session_start();
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Recipe | Veggiedelights</title>
  <link rel="stylesheet" href="css/styles.css">
  <style>
    /* ===== Navigation Bar ===== */
    header.navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 30px;
      background: #FF8C00;
      color: #fff;
      flex-wrap: wrap;
      border-radius: 0 0 10px 10px;
    }

    header.navbar .logo a {
      font-size: 1.5rem;
      font-weight: bold;
      color: #fff;
      text-decoration: none;
    }

    header.navbar nav {
      display: flex;
      gap: 15px;
      flex-wrap: wrap;
    }

    header.navbar nav a {
      color: #fff;
      text-decoration: none;
      padding: 8px 12px;
      border-radius: 6px;
      transition: all 0.3s ease;
      font-size: 16px;
    }

    header.navbar nav a:hover { 
      background: #fff; 
      color: #FF8C00; 
    }

    /* ===== Dropdown Menu ===== */
    .dropdown { 
      position: relative; 
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background: #FF7B00; /* Orange dropdown */
      color: #fff;
      min-width: 150px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.2);
      border-radius: 6px;
      overflow: hidden;
      top: 30px;
      z-index: 100;
    }

    .dropdown-content a {
      display: block;
      padding: 10px 12px;
      color: #fff;
      transition: all 0.3s ease;
      font-size: 16px;
      text-decoration: none;
    }

    .dropdown-content a:hover { 
      background: #fff; 
      color: #FF7B00; 
    }

    .dropdown:hover .dropdown-content { 
      display: block; 
    }

    /* ===== Auth Links ===== */
    .auth-links {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .auth-links a { 
      background: #FF8C00;
      color: #fff; 
      text-decoration: none; 
      padding: 6px 12px;
      border-radius: 6px;
      transition: all 0.3s ease;
      font-size: 16px;
    }

    .auth-links a:hover { 
      background: #fff; 
      color: #FF8C00; 
    }

    #themeToggle {
      background: none;
      border: none;
      font-size: 1.2rem;
      cursor: pointer;
      color: #fff;
      transition: all 0.3s ease;
    }

    #themeToggle:hover {
      color: #333;
    }

    /* ===== Main Form Section ===== */
    body {
      font-family: Arial, sans-serif;
      background: #f0f0f0;
      margin: 0;
      padding: 0;
    }

    main {
      max-width: 700px;
      margin: 40px auto;
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    h1 {
      text-align: center;
      color: #ff8c00;
      margin-bottom: 20px;
    }

    form div {
      margin-bottom: 15px;
    }

    label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }

    input[type="text"], 
    textarea, 
    input[type="file"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 1rem;
    }

    button {
      background: #ff8c00;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 1rem;
      transition: all 0.3s ease;
    }

    button:hover { 
      background: #e67300; 
    }

    /* ===== Dark Theme ===== */
    .dark-theme { 
      background: #222; 
      color: #fff; 
    }

    .dark-theme main { 
      background: #333; 
      color: #fff; 
    }

    .dark-theme input, 
    .dark-theme textarea {
      background: #444; 
      color: #fff; 
      border: 1px solid #666;
    }
  </style>
</head>
<body>

  <!-- 🌐 Navigation Bar -->
  <header class="navbar">
    <div class="logo"><a href="index.php">🍳 Veggiedelights</a></div>
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
          echo '<a href="logout.php">Logout</a>';
      } else {
          echo '<a href="login.php">Login</a>';
      }
      ?>
      <button id="themeToggle">🌙</button>
    </div>
  </header>

  <!-- ✨ Main Content -->
  <main>
    <h1>Add New Recipe</h1>

    <?php
    if (!isset($_SESSION['email'])) {
        echo "<p style='color:red; text-align:center;'>You must be logged in to add a recipe.</p>";
    } else {
    ?>
    <form action="added_recipe.php" method="POST" enctype="multipart/form-data">
      <div>
        <label for="name">Recipe Name</label>
        <input type="text" name="name" id="name" required>
      </div>

      <div>
        <label for="ingredients">Ingredients (comma separated)</label>
        <textarea name="ingredients" id="ingredients" rows="3" required></textarea>
      </div>

      <div>
        <label for="steps">Preparation Steps</label>
        <textarea name="steps" id="steps" rows="5" required></textarea>
      </div>

      <div>
        <label for="image">Recipe Image</label>
        <input type="file" name="image" id="image" accept="image/*">
      </div>

      <button type="submit">Add Recipe</button>
    </form>
    <?php } ?>
  </main>

  <!-- 🌙 Theme Toggle Script -->
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
