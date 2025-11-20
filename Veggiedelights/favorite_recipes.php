<?php
session_start();
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Favorite Recipes | Veggiedelights</title>
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
      font-weight: bold;
    }
    header.navbar nav a:hover { 
      background: #fff; 
      color: #FF8C00; 
    }

    /* ===== Dropdown Menu ===== */
    .dropdown { position: relative; }
    .dropdown-content {
      display: none;
      position: absolute;
      background: #ff7b00;  /* orange dropdown */
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
    }
    .dropdown-content a:hover { 
      background: #fff;  /* hover background */
      color: #ff7b00;    /* hover text */
    }
    .dropdown:hover .dropdown-content { display: block; }

    /* ===== Auth Links ===== */
    .auth-links {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .auth-links a {
      color: #FF8C00;
      text-decoration: none;
      padding: 6px 12px;
      border-radius: 6px;
      transition: all 0.3s ease;
      font-weight: bold;
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
    #themeToggle:hover { color: #333; }

    /* ===== Page Container ===== */
    .container {
      max-width: 1000px;
      margin: 30px auto;
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    h1 { text-align: center; color: #FF8C00; }
    .recipe-list {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      margin-top: 20px;
    }
    .recipe-card {
      background: #f9f9f9;
      padding: 15px;
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      text-align: center;
      transition: all 0.3s ease;
      cursor: pointer;
    }
    .recipe-card img {
      width: 100%;
      height: 150px;
      object-fit: cover;
      border-radius: 8px;
      margin-bottom: 10px;
      transition: transform 0.3s ease;
    }
    .recipe-card h3 { 
      margin: 0 0 10px; 
      color: #333; 
    }
    .recipe-card:hover {
      transform: scale(1.05);
      background: #FF8C00;
      color: #fff;
    }
    .recipe-card:hover h3 { color: #fff; }
    a.back {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 15px;
      background: #FF8C00;
      color: #fff;
      text-decoration: none;
      border-radius: 6px;
      transition: all 0.3s ease;
    }
    a.back:hover { 
      background: #fff; 
      color: #FF8C00; 
    }
  </style>
</head>
<body>
  <!-- 🌐 Navigation Bar -->
  <header class="navbar">
    <div class="logo"><a href="index.php">🍳veggiedelights</a></div>
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
          echo '<span class="welcome">👋 ' . htmlspecialchars($_SESSION['email']) . '</span>';
          echo '<a href="logout.php">Logout</a>';
      } else {
          echo '<a href="login.php">Login</a>';
      }
      ?>
      <button id="themeToggle">🌙</button>
    </div>
  </header>

  <!-- ===== Favorite Recipes Container ===== -->
  <div class="container">
    <h1>Favorite Recipes</h1>
    <p>Your saved favorite recipes will appear below:</p>

    <div class="recipe-list" id="recipeList">
      <div class="recipe-card" onclick="location.href='dosa.html'">
        <img src="https://vismaifood.com/storage/app/uploads/public/8b4/19e/427/thumb__1200_0_0_0_auto.jpg" alt="Dosa">
        <h3>Dosa</h3>
      </div>
      <div class="recipe-card" onclick="location.href='vegetablenoodles.html'">
        <img src="https://shwetainthekitchen.com/wp-content/uploads/2023/03/vegetable-noodles.jpg" alt="Vegetable Noodles">
        <h3>Vegetable Noodles</h3>
      </div>
      <div class="recipe-card" onclick="location.href='paneertikka.html'">
        <img src="https://spicecravings.com/wp-content/uploads/2020/10/Paneer-Tikka-Featured-1.jpg" alt="Paneer Tikka">
        <h3>Paneer Tikka</h3>
      </div>
      <div class="recipe-card" onclick="location.href='springroll.html'">
        <img src="https://media.istockphoto.com/id/486940812/photo/baked-spring-rolls-with-deep-vegetables-and-rice.jpg?s=612x612&w=0&k=20&c=rQ5NCxvLHt8zhO3oXFCU8QCfoVG_94jKTMWjti05Bso=" alt="Spring Roll">
        <h3>Spring Roll</h3>
      </div>
    </div>

    <a href="index.php" class="back">← Back to Home</a>
  </div>
</body>
</html>
