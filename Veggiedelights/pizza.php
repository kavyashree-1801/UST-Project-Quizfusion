<?php
session_start();
$role = $_SESSION['role'] ?? 'guest';
$email = $_SESSION['email'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Margherita Pizza | Veggiedelights</title>
  <style>
    body {font-family:"Poppins",sans-serif;margin:0;background:#f8f8f8;}
    header.navbar{display:flex;justify-content:space-between;align-items:center;background:#ff7b00;padding:12px 20px;}
    .logo a{font-size:1.5rem;color:#fff;font-weight:bold;text-decoration:none;}
    nav a{color:#fff;text-decoration:none;margin:0 10px;}
    nav a:hover{background:#fff;color:#ff7b00;padding:5px 10px;border-radius:5px;}
    .recipe-detail{max-width:800px;margin:40px auto;background:#fff;border-radius:10px;padding:20px;box-shadow:0 2px 10px rgba(0,0,0,0.1);}
    img{width:100%;border-radius:10px;height:350px;object-fit:cover;}
    h1{text-align:center;color:#ff7b00;}
    h2{border-bottom:2px solid #ff7b00;color:#333;}
    ul,ol{line-height:1.8;}
    .back-btn{text-align:center;display:block;margin:20px auto;color:#ff7b00;font-weight:bold;text-decoration:none;}
    .back-btn:hover{text-decoration:underline;}
    footer{background:#ff7b00;color:#fff;text-align:center;padding:15px 0;margin-top:50px;}
  </style>
</head>
<body>
<div class="recipe-detail">
  <img src="https://media.istockphoto.com/id/1393150881/photo/italian-pizza-margherita-with-cheese-and-tomato-sauce-on-the-board-on-grey-table-macro-close.jpg?s=612x612&w=0&k=20&c=kL0Vhg2XKBjEl__iG8sFv31WTiahdpLc3rTDtNZuD2g=" alt="Margherita Pizza">
  <h1>Margherita Pizza</h1>
  <h2>Ingredients</h2>
  <ul>
    <li>Pizza dough – 1 base</li>
    <li>Tomato sauce – ½ cup</li>
    <li>Fresh mozzarella – 100 g</li>
    <li>Fresh basil leaves – 8–10</li>
    <li>Olive oil – 1 tbsp</li>
    <li>Salt and oregano – to taste</li>
  </ul>
  <h2>Steps</h2>
  <ol>
    <li>Spread tomato sauce over the dough evenly.</li>
    <li>Top with mozzarella and basil leaves.</li>
    <li>Drizzle olive oil and sprinkle oregano.</li>
    <li>Bake at 220°C for 10–12 minutes.</li>
    <li>Slice and serve hot!</li>
  </ol>
  <a href="italian.php" class="back-btn">← Back to Italian Recipes</a>
</div>

<footer>
  <p>&copy; 2025 Veggiedelights | All Rights Reserved</p>
</footer>
</body>
</html>
