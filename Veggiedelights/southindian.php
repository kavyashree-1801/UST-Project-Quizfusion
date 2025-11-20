<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>South Indian Recipes</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f8f8f8; margin: 0; padding: 0; }
    h1 { text-align: center; margin: 20px 0; color: #333; }
    .recipe-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px,1fr)); gap: 20px; padding: 20px; max-width: 1200px; margin: 0 auto; }
    .recipe-card { background: #fff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); overflow: hidden; transition: transform 0.2s; display: flex; flex-direction: column; justify-content: space-between; }
    .recipe-card:hover { transform: scale(1.03); }
    .recipe-card img { width: 100%; height: 180px; object-fit: cover; }
    .recipe-details { padding: 15px; }
    .recipe-details h2 { font-size: 1.2rem; margin: 0 0 10px; color: #444; text-transform: capitalize; }
    .recipe-details p { font-size: 0.95rem; color: #666; margin-bottom: 15px; }
    .view-button { display: block; text-align: center; padding: 10px 15px; background-color: #ff7b00; color: #fff; text-decoration: none; border-radius: 0 0 10px 10px; transition: background-color 0.3s; }
    .view-button:hover { background-color: #ff7b00; }
    @media(max-width:600px){ .recipe-card img { height: 150px; } }
  </style>
</head>
<body>

<h1>South Indian Recipes</h1>

<div class="recipe-container">

  <div class="recipe-card">
    <img src="https://static.toiimg.com/thumb/msid-113810989,width-1280,height-720,resizemode-4/113810989.jpg" alt="Idli">
    <div class="recipe-details">
      <h2>Idli</h2>
      <p>Steamed rice cakes, soft and fluffy, served with chutney.</p>
    </div>
    <a href="idli.php" class="view-button">View Recipe</a>
  </div>

  <div class="recipe-card">
    <img src="https://vismaifood.com/storage/app/uploads/public/8b4/19e/427/thumb__1200_0_0_0_auto.jpg" alt="Dosa">
    <div class="recipe-details">
      <h2>Dosa</h2>
      <p>Crispy rice and lentil crepe, served with sambar and chutney.</p>
    </div>
    <a href="dosa.php" class="view-button">View Recipe</a>
  </div>

  <div class="recipe-card">
    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT4yNAg8mINQeky1Wln4RUS2XAeIJtf1TaKMw&s" alt="Bisibelebath">
    <div class="recipe-details">
      <h2>Bisibelebath</h2>
      <p>Spiced rice and lentil porridge, rich and tangy, simmered with tamarind and aromatic spices.</p>
    </div>
    <a href="bisibelebath.php" class="view-button">View Recipe</a>
  </div>

  <div class="recipe-card">
    <img src="https://www.mygingergarlickitchen.com/wp-content/rich-markup-images/16x9/16x9-pyaaz-pakoda-onion-fritters.jpg" alt="Onion Pakoda">
    <div class="recipe-details">
      <h2>Onion Pakoda</h2>
      <p>Crispy and golden fried onion fritters, seasoned with spices, perfect as a snack or tea-time treat.</p>
    </div>
    <a href="onionpakoda.php" class="view-button">View Recipe</a>
  </div>

</div>

<a href="category.php" class="view-button" style="margin:20px; display:inline-block;">← Back to Categories</a>

</body>
</html>
