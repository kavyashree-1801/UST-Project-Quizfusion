<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pasta Primavera | Veggiedelights</title>
<style>
body{font-family:"Poppins",sans-serif;margin:0;background:#f8f8f8;}
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
  <img src="https://thecozycook.com/wp-content/uploads/2024/02/Pasta-Primavera-f.jpg" alt="Pasta Primavera">
  <h1>Pasta Primavera</h1>
  <h2>Ingredients</h2>
  <ul>
    <li>Penne pasta – 200g</li>
    <li>Mixed veggies (broccoli, bell peppers, peas) – 1 cup</li>
    <li>Olive oil – 2 tbsp</li>
    <li>Garlic – 3 cloves (minced)</li>
    <li>Cream or milk – ½ cup</li>
    <li>Salt, pepper, Italian herbs – to taste</li>
  </ul>
  <h2>Steps</h2>
  <ol>
    <li>Boil pasta and drain.</li>
    <li>Sauté garlic and vegetables in olive oil.</li>
    <li>Add cream, herbs, and mix in the pasta.</li>
    <li>Cook for 2–3 minutes and serve warm.</li>
  </ol>
  <a href="italian.php" class="back-btn">← Back to Italian Recipes</a>
</div>

<footer>
  <p>&copy; 2025 Veggiedelights | All Rights Reserved</p>
</footer>
</body>
</html>
