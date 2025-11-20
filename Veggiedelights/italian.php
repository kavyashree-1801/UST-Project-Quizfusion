<?php
session_start();
$role = $_SESSION['role'] ?? 'guest';
$email = $_SESSION['email'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Italian Recipes | Veggiedelights</title>
  <style>
    body {
      font-family: "Poppins", sans-serif;
      margin: 0;
      background: #f8f8f8;
    }

    /* ===== NAVBAR ===== */
    header.navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #ff7b00;
      padding: 12px 20px;
      flex-wrap: wrap;
    }

    header.navbar .logo a {
      font-size: 1.5rem;
      font-weight: bold;
      color: #fff;
      text-decoration: none;
    }

    header.navbar nav {
      display: flex;
      align-items: center;
      gap: 25px;
    }

    header.navbar nav a {
      color: #fff;
      text-decoration: none;
      padding: 8px 12px;
      border-radius: 5px;
      transition: 0.3s;
    }

    header.navbar nav a:hover {
      background: #fff;
      color: #ff7b00;
    }

    /* ===== DROPDOWN ===== */
    .dropdown {
      position: relative;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      top: 38px;
      left: 0;
      background-color: #ff7b00;
      min-width: 180px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
      border-radius: 8px;
      flex-direction: column;
      z-index: 10;
    }

    .dropdown-content a {
      color: #fff;
      padding: 10px 15px;
      text-decoration: none;
      display: block;
      border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .dropdown-content a:last-child {
      border-bottom: none;
    }

    .dropdown-content a:hover {
      background: #fff;
      color: #ff7b00;
    }

    .dropdown:hover .dropdown-content {
      display: flex;
    }

    /* ===== AUTH LINKS ===== */
    .auth-links {
      display: flex;
      align-items: center;
      gap: 10px;
      flex-wrap: wrap;
    }

    .auth-links .welcome {
      color: #fff;
      font-weight: bold;
    }

    .auth-links .nav-link {
      background: #fff;
      color: #ff7b00;
      padding: 6px 12px;
      border-radius: 5px;
      text-decoration: none;
      transition: 0.3s;
    }

    .auth-links .nav-link:hover {
      background: #ff7b00;
      color: #fff;
    }

    /* ===== PAGE HEADER ===== */
    .page-header {
      text-align: center;
      margin-top: 40px;
    }

    .page-header h1 {
      color: #333;
    }

    .page-header p {
      color: #666;
    }

    /* ===== RECIPE CARDS ===== */
    .recipe-container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
      margin: 40px 10px;
    }

    .recipe-card {
      background: #fff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      width: 280px;
      transition: transform 0.3s;
      text-align: center;
    }

    .recipe-card:hover {
      transform: translateY(-5px);
    }

    .recipe-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }

    .recipe-card h3 {
      margin: 15px 0 10px 0;
      color: #333;
    }

    .recipe-card p {
      padding: 0 15px;
      font-size: 0.95rem;
      color: #555;
      margin-bottom: 15px;
    }

    .recipe-card .btn {
      display: inline-block;
      margin-bottom: 20px;
      padding: 8px 15px;
      background: #ff7b00;
      color: #fff;
      border-radius: 5px;
      text-decoration: none;
      font-weight: bold;
      transition: 0.3s;
    }

    .recipe-card .btn:hover {
      background: #e26b00;
    }

    .back-btn {
      display: block;
      text-align: center;
      margin: 30px auto;
      color: #ff7b00;
      text-decoration: none;
      font-weight: bold;
    }

    .back-btn:hover {
      text-decoration: underline;
    }

    footer {
      background: #ff7b00;
      color: #fff;
      text-align: center;
      padding: 15px 0;
      margin-top: 50px;
    }
  </style>
</head>
<body>
<!-- 🍝 Page Header -->
<section class="page-header">
  <h1>Italian Vegetarian Recipes</h1>
  <p>Indulge in classic Italian flavors with these delicious veg recipes!</p>
</section>

<!-- 🍕 Recipe Cards -->
<section class="recipe-container">

  <!-- Recipe 1 -->
  <div class="recipe-card">
    <img src="https://www.inspiredtaste.net/wp-content/uploads/2016/10/Easy-Vegetable-Lasagna-Recipe-1200.jpg" alt="Veg Lasagna">
    <h3>Vegetable Lasagna</h3>
    <p>Layers of pasta, veggies, and rich tomato sauce topped with melted cheese. Pure comfort food!</p>
    <a href="Lasagna.php" class="btn">View Recipe</a>
  </div>

  <!-- Recipe 2 -->
  <div class="recipe-card">
    <img src="https://media.istockphoto.com/id/1393150881/photo/italian-pizza-margherita-with-cheese-and-tomato-sauce-on-the-board-on-grey-table-macro-close.jpg?s=612x612&w=0&k=20&c=kL0Vhg2XKBjEl__iG8sFv31WTiahdpLc3rTDtNZuD2g=" alt="Margherita Pizza">
    <h3>Margherita Pizza</h3>
    <p>A classic thin-crust pizza topped with tangy tomato sauce, mozzarella, and fresh basil leaves.</p>
    <a href="pizza.php" class="btn">View Recipe</a>
  </div>

  <!-- Recipe 3 -->
  <div class="recipe-card">
    <img src="https://thecozycook.com/wp-content/uploads/2024/02/Pasta-Primavera-f.jpg" alt="Pasta Primavera">
    <h3>Pasta Primavera</h3>
    <p>Fresh seasonal vegetables tossed with creamy white sauce and Italian herbs. Light and delicious!</p>
    <a href="primavera.php" class="btn">View Recipe</a>
  </div>

  <!-- Recipe 4 -->
  <div class="recipe-card">
    <img src="https://cdn.loveandlemons.com/wp-content/uploads/2023/01/mushroom-risotto.jpg" alt="Mushroom Risotto">
    <h3>Mushroom Risotto</h3>
    <p>Italian rice cooked slowly with mushrooms, butter, and parmesan for a rich and creamy flavor.</p>
    <a href="risotto.php" class="btn">View Recipe</a>
  </div>

</section>

<!-- 🔙 Back Button -->
<a href="manage_categories.php" class="back-btn">← Back to Categories</a>

<!-- 👣 Footer -->
<footer>
  <p>&copy; 2025 Veggiedelights | All Rights Reserved</p>
</footer>

</body>
</html>
