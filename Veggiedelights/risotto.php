<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mushroom Risotto | Veggiedelights</title>
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
  <img src="https://www.allrecipes.com/thmb/Pow6PE9UyushNDB4wutXNnmriX8=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/85389-gourmet-mushroom-risotto-86-7a2d218f53e94ccfaecc69b6fd93cab8.jpg" alt="Mushroom Risotto">
  <h1>Mushroom Risotto</h1>
  <h2>Ingredients</h2>
  <ul>
    <li>Arborio rice – 1 cup</li>
    <li>Mushrooms – 1 cup (sliced)</li>
    <li>Vegetable broth – 3 cups</li>
    <li>Butter – 2 tbsp</li>
    <li>Garlic – 2 cloves</li>
    <li>Parmesan – ¼ cup</li>
    <li>Salt and pepper – to taste</li>
  </ul>
  <h2>Steps</h2>
  <ol>
    <li>Sauté mushrooms and garlic in butter.</li>
    <li>Add rice and cook for 1–2 minutes.</li>
    <li>Gradually add broth, stirring until creamy.</li>
    <li>Mix in parmesan and serve warm.</li>
  </ol>
  <a href="italian.php" class="back-btn">← Back to Italian Recipes</a>
</div>

<footer>
  <p>&copy; 2025 Veggiedelights | All Rights Reserved</p>
</footer>
</body>
</html>
