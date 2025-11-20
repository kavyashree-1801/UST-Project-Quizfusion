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
  <title>Vegetable Lasagna | Veggiedelights</title>
  <style>
    body {
      font-family: "Poppins", sans-serif;
      margin: 0;
      background: #f8f8f8;
    }
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
    header.navbar nav a {
      color: #fff;
      text-decoration: none;
      margin: 0 10px;
      transition: 0.3s;
    }
    header.navbar nav a:hover {
      background: #fff;
      color: #ff7b00;
      padding: 5px 10px;
      border-radius: 5px;
    }
    .recipe-detail {
      max-width: 800px;
      margin: 40px auto;
      background: #fff;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .recipe-detail img {
      width: 100%;
      border-radius: 10px;
      height: 350px;
      object-fit: cover;
    }
    .recipe-detail h1 {
      color: #ff7b00;
      text-align: center;
      margin-top: 20px;
    }
    h2 {
      color: #333;
      border-bottom: 2px solid #ff7b00;
      padding-bottom: 5px;
    }
    ul, ol {
      line-height: 1.8;
    }
    .back-btn {
      display: block;
      text-align: center;
      margin: 20px auto;
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
<div class="recipe-detail">
  <img src="https://media.istockphoto.com/id/508652097/photo/spinach-and-ricotta-lasagna.jpg?s=612x612&w=0&k=20&c=LABDGg0Mg2Tvk1yBphUUrYAC6CXczKKPxksdKk1dlb8=" alt="Vegetable Lasagna">
  <h1>Vegetable Lasagna</h1>

  <h2>Ingredients</h2>
  <ul>
    <li>Lasagna sheets – 6</li>
    <li>Mixed vegetables (carrot, bell pepper, zucchini) – 1½ cups</li>
    <li>Tomato sauce – 2 cups</li>
    <li>Ricotta or paneer – 1 cup</li>
    <li>Mozzarella cheese – 1 cup (shredded)</li>
    <li>Olive oil, salt, pepper, oregano – as needed</li>
  </ul>

  <h2>Steps</h2>
  <ol>
    <li>Boil the lasagna sheets and set aside.</li>
    <li>Sauté the vegetables in olive oil, season with salt and pepper.</li>
    <li>Layer the sauce, pasta sheets, veggies, ricotta, and cheese in a baking dish.</li>
    <li>Bake at 180°C for 25 minutes until golden brown.</li>
    <li>Cool slightly, slice, and serve warm!</li>
  </ol>

  <a href="italian.php" class="back-btn">← Back to Italian Recipes</a>
</div>

<footer>
  <p>&copy; 2025 Veggiedelights | All Rights Reserved</p>
</footer>
</body>
</html>
