<?php
session_start();
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>My Recipes | Veggiedelights</title>
  <link rel="stylesheet" href="css/myrecipes.css" />
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
      <a href="my_recipes.php" class="active">My Recipes</a>
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

  <!-- 🥘 My Recipes Section -->
  <main>
    <section class="recipe-page">
      <h1>My Recipes</h1>
      <div class="recipe-container">

        <!-- Recipe Cards Start -->
        <div class="recipe-card">
          <img src="https://images.archanaskitchen.com/images/recipes/indian/sweet-recipes/Pineapple_Kesari_Bhath_9e29000d52.jpg" alt="Kesari Bath">
          <div class="recipe-details">
            <h2>Kesari Bath</h2>
            <p>Sweet semolina dessert flavored with saffron, cardamom, and ghee, a South Indian delicacy.</p>
          </div>
          <a href="kesaribath.php" class="view-button">View Recipe</a>
          <button class="delete-btn">Delete</button>
        </div>

        <div class="recipe-card">
          <img src="https://media.istockphoto.com/id/1334115358/photo/cabbage-manchurian.jpg?s=612x612&w=0&k=20&c=lZvW1lWr03mQszDbx4v59IAnxWacQ_Ti275hjj18hcE=" alt="Veg Manchurian">
          <div class="recipe-details">
            <h2>Veg Manchurian</h2>
            <p>Chinese-style vegetable balls cooked in spicy soy-based sauce, perfect with rice or noodles.</p>
          </div>
          <a href="veg_manchurian.php" class="view-button">View Recipe</a>
          <button class="delete-btn">Delete</button>
        </div>

        <div class="recipe-card">
          <img src="https://media.istockphoto.com/id/1431969046/photo/baby-bok-choy-or-chinese-cabbage-in-mushroom-vegetarian-sauce.jpg?s=612x612&w=0&k=20&c=4R2K4eaAQXayQ6DCLnkGjx2zuR78C-JtZ-iljavttjY=" alt="Stir-Fried Bok Choy">
          <div class="recipe-details">
            <h2>Stir-Fried Bok Choy</h2>
            <p>Fresh bok choy stir-fried with garlic and a light soy sauce, simple and healthy Chinese dish.</p>
          </div>
          <a href="stirfried_bokchoy.php" class="view-button">View Recipe</a>
          <button class="delete-btn">Delete</button>
        </div>

        <div class="recipe-card">
          <img src="https://www.indianhealthyrecipes.com/wp-content/uploads/2021/08/chana-masala-recipe.jpg" alt="Chana Masala">
          <div class="recipe-details">
            <h2>Chana Masala</h2>
            <p>Spiced chickpeas cooked in tangy tomato gravy, a North Indian favorite served with rice or roti.</p>
          </div>
          <a href="chana_masala.php" class="view-button">View Recipe</a>
          <button class="delete-btn">Delete</button>
        </div>

        <div class="recipe-card">
          <img src="https://niksharmacooks.com/wp-content/uploads/2022/11/AlooGobiDSC_5234.jpg" alt="Aloo Gobi">
          <div class="recipe-details">
            <h2>Aloo Gobi</h2>
            <p>Classic Indian curry of potatoes and cauliflower cooked with spices, tomato, and herbs.</p>
          </div>
          <a href="aloo_gobi.php" class="view-button">View Recipe</a>
          <button class="delete-btn">Delete</button>
        </div>

      </div>
    </section>
  </main>

  <!-- 👣 Footer -->
  <footer>
    <p>Made with ❤️ by You | © 2025 Veggiedelights</p>
  </footer>

  <!-- 🌙 Theme & Delete Script -->
  <script>
    // 🌙 Theme toggle
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

    // 🗑️ Delete recipe card
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(btn => {
      btn.addEventListener('click', () => {
        const card = btn.parentElement;
        card.remove();
      });
    });
  </script>
</body>
</html>

<style>
/* General Styles */
body {
  font-family: 'Arial', sans-serif;
  margin: 0;
  padding: 0;
  background-color: #f7f7f7;
}

/* 🌐 Navigation Bar Styles */
header {
  background-color: #ff6600; /* Orange color for the navbar */
  color: #fff;
  padding: 15px 20px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

header .logo a {
  color: #fff;
  font-size: 1.5rem;
  text-decoration: none;
  font-weight: bold;
}

/* Flexbox for equal spacing in navigation */
header nav {
  display: flex;
  justify-content: space-around; /* Distribute links evenly */
  align-items: center;
  flex-grow: 1;
}

header nav a {
  color: #fff;
  text-decoration: none;
  padding: 10px 15px;
  font-size: 1rem;
  font-weight: 600;
  text-align: center;
}

header nav a:hover, header nav a.active {
  background-color: #cc5200; /* Darker orange for hover and active states */
  border-radius: 4px;
}

header .auth-links {
  display: flex;
  align-items: center;
}

header .auth-links a {
  color: #fff;
  text-decoration: none;
  margin-left: 20px;
  font-size: 1rem;
}

header .auth-links a:hover {
  color: #ff6600; /* Orange color for hover effect */
}

header #themeToggle {
  background: none;
  border: none;
  font-size: 1.2rem;
  color: #fff;
  cursor: pointer;
  margin-left: 20px;
}

/* Recipe Cards Layout */
.recipe-page {
  padding: 20px;
}

.recipe-container {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 20px;
  padding: 20px;
}

.recipe-card {
  background-color: #fff;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s ease-in-out;
}

.recipe-card:hover {
  transform: translateY(-5px);
}

.recipe-card img {
  width: 100%;
  height: 200px;
  object-fit: cover;
}

.recipe-details {
  padding: 15px;
  text-align: center;
}

.recipe-details h2 {
  font-size: 1.2rem;
  margin: 10px 0;
}

.recipe-details p {
  font-size: 0.9rem;
  color: #555;
}

/* Orange "View Recipe" Button */
.view-button {
  display: block;
  background-color: #ff6600; /* Orange color */
  color: #fff;
  padding: 10px 15px;
  text-align: center;
  text-decoration: none;
  margin: 10px 0;
  border-radius: 4px;
}

.view-button:hover {
  background-color: #cc5200; /* Darker orange on hover */
}

.delete-btn {
  display: inline-block;
  background-color: #dc3545;
  color: #fff;
  padding: 8px 12px;
  text-align: center;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.delete-btn:hover {
  background-color: #c82333;
}

footer {
  background-color: #333;
  color: #fff;
  text-align: center;
  padding: 15px 0;
  position: relative;
  bottom: 0;
  width: 100%;
}

/* Dark theme */
body.dark-theme {
  background-color: #121212;
  color: #fff;
}

body.dark-theme header {
  background-color: #222;
}

body.dark-theme .recipe-card {
  background-color: #333;
}

body.dark-theme .recipe-card img {
  filter: brightness(70%);
}

body.dark-theme .view-button {
  background-color: #cc5200; /* Darker orange for dark theme */
}

body.dark-theme .delete-btn {
  background-color: #e03131;
}
</style>
