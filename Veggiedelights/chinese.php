<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vegetarian Chinese Recipes</title>
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
    .view-button { display: block; text-align: center; padding: 10px 15px; background-color: #FF8C00; color: #fff; text-decoration: none; border-radius: 0 0 10px 10px; transition: background-color 0.3s; }
    .view-button:hover { background-color: #e67300; }
    @media(max-width:600px){ .recipe-card img { height: 150px; } }
  </style>
</head>
<body>

<h1>Vegetarian Chinese Recipes</h1>

<div class="recipe-container">

  <div class="recipe-card">
    <img src="https://www.seriouseats.com/thmb/CaR7btHrJgEO3OKZD1Z_795VmII=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/__opt__aboutcom__coeus__resources__content_migration__serious_eats__seriouseats.com__2011__07__2021-02-12-Mapo-Tofu-MHOM-10-804db1211f1d47dbae505341d1e7b994.jpg" alt="Mapo Tofu">
    <div class="recipe-details">
      <h2>Mapo Tofu</h2>
      <p>A classic Sichuan dish featuring soft tofu in a spicy, flavorful sauce made with fermented bean paste and chili, perfect with steamed rice.</p>
    </div>
    <a href="mapotofu.php" class="view-button">View Recipe</a>
  </div>

  <div class="recipe-card">
    <img src="https://shwetainthekitchen.com/wp-content/uploads/2023/03/vegetable-noodles.jpg" alt="Vegetable Noodles">
    <div class="recipe-details">
      <h2>Vegetable Noodles</h2>
      <p>Stir-fried noodles tossed with a colorful mix of fresh vegetables, flavored with soy sauce and garlic for a quick and tasty meal.</p>
    </div>
    <a href="vegetablenoodles.php" class="view-button">View Recipe</a>
  </div>

  <div class="recipe-card">
    <img src="https://www.sharmispassions.com/wp-content/uploads/2011/01/VegFriedRice2.jpg" alt="Vegetable Fried Rice">
    <div class="recipe-details">
      <h2>Vegetable Fried Rice</h2>
      <p>A simple yet flavorful dish made with stir-fried rice, mixed vegetables, and soy sauce, perfect as a main or side dish.</p>
    </div>
    <a href="friedrice.php" class="view-button">View Recipe</a>
  </div>

  <div class="recipe-card">
    <img src="https://media.istockphoto.com/id/486940812/photo/baked-spring-rolls-with-deep-vegetables-and-rice.jpg?s=612x612&w=0&k=20&c=rQ5NCxvLHt8zhO3oXFCU8QCfoVG_94jKTMWjti05Bso=" alt="Vegetable Spring Rolls">
    <div class="recipe-details">
      <h2>Vegetable Spring Rolls</h2>
      <p>Crispy rolls filled with fresh vegetables and lightly seasoned, perfect as a snack or appetizer with dipping sauce.</p>
    </div>
    <a href="springroll.php" class="view-button">View Recipe</a>
  </div>

</div>

<a href="category.php" class="view-button" style="margin:20px; display:inline-block;">← Back to Categories</a>

</body>
</html>
