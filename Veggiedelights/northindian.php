<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>North Indian Recipes</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f8f8f8; margin: 0; padding: 0; }
    h1 { text-align: center; margin: 20px 0; color: #333; }
    .recipe-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px,1fr)); gap: 20px; padding: 20px; max-width: 1200px; margin: 0 auto; }
    .recipe-card { background: #fff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); overflow: hidden; transition: transform 0.2s; display: flex; flex-direction: column; justify-content: space-between; }
    .recipe-card:hover { transform: scale(1.03); }
    .recipe-card img { width: 100%; height: 180px; object-fit: cover; }
    .recipe-details { padding: 15px; }
    .recipe-details h2 { font-size: 1.2rem; margin: 0 0 10px; color: #444; }
    .recipe-details p { font-size: 0.95rem; color: #666; margin-bottom: 15px; }
    .view-button { display: block; text-align: center; padding: 10px 15px; background-color: #ff7b00; color: #fff; text-decoration: none; border-radius: 0 0 10px 10px; transition: background-color 0.3s; }
    .view-button:hover { background-color: #ff7b00; }
    @media(max-width:600px){ .recipe-card img { height: 150px; } }
  </style>
</head>
<body>

<h1>North Indian Recipes</h1>

<div class="recipe-container">

  <div class="recipe-card">
    <img src="https://aartimadan.com/wp-content/uploads/2023/11/Paneer-Butter-Masala-Restaurant-Style.jpg" alt="Paneer Butter Masala">
    <div class="recipe-details">
      <h2>Paneer Butter Masala</h2>
      <p>Soft paneer cubes simmered in a creamy, buttery tomato gravy.</p>
    </div>
    <a href="paneerbuttermasala.php" class="view-button">View Recipe</a>
  </div>

  <div class="recipe-card">
    <img src="https://spicecravings.com/wp-content/uploads/2020/10/Paneer-Tikka-Featured-1.jpg" alt="Paneer Tikka">
    <div class="recipe-details">
      <h2>Paneer Tikka</h2>
      <p>Marinated paneer cubes grilled to perfection with smoky flavors and spices.</p>
    </div>
    <a href="paneertikka.php" class="view-button">View Recipe</a>
  </div>

  <div class="recipe-card">
    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSrY-YDbNH_JLFnMOh26A1l7WKFgORHz6C3uQ&s" alt="Rajma Chawal">
    <div class="recipe-details">
      <h2>Rajma Chawal</h2>
      <p>Red kidney beans cooked in spiced tomato gravy, served with steamed rice.</p>
    </div>
    <a href="rajmachawal.php" class="view-button">View Recipe</a>
  </div>

  <div class="recipe-card">
    <img src="https://www.sharmispassions.com/wp-content/uploads/2012/05/dal-makhani7-500x500.jpg" alt="Dal Makhani">
    <div class="recipe-details">
      <h2>Dal Makhani</h2>
      <p>Slow-cooked black lentils in a rich, buttery and mildly spiced sauce.</p>
    </div>
    <a href="dalmakhani.php" class="view-button">View Recipe</a>
  </div>

</div>

<a href="category.php" class="view-button" style="margin:20px; display:inline-block;">← Back to Categories</a>

</body>
</html>
