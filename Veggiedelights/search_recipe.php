<?php
session_start();
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search Recipes | Veggiedelights</title>
  <style>
    /* ===== Navigation Bar ===== */
    header.navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 40px;
      background: #FF8C00;
      color: #fff;
      flex-wrap: wrap;
      border-radius: 0 0 10px 10px;
      font-family: "Poppins", sans-serif;
    }

    header.navbar .logo a {
      font-size: 1.6rem;
      font-weight: 700;
      color: #fff;
      text-decoration: none;
      letter-spacing: 1px;
    }

    header.navbar nav {
      display: flex;
      gap: 25px;
      flex-wrap: wrap;
      align-items: center;
      justify-content: center;
    }

    header.navbar nav a {
      color: #fff;
      text-decoration: none;
      font-weight: 600;
      font-size: 17px;
      padding: 8px 14px;
      border-radius: 6px;
      transition: all 0.3s ease;
    }

    header.navbar nav a:hover { 
      background: #fff; 
      color: #FF8C00; 
    }

    /* ===== Dropdown Menu ===== */
    .dropdown {
      position: relative;
      font-weight: 600;
    }

    .dropdown > a {
      font-weight: 600;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background: #FF7B00;
      min-width: 160px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.2);
      border-radius: 6px;
      top: 35px;
      left: 0;
      overflow: hidden;
      z-index: 100;
    }

    .dropdown-content a {
      display: block;
      padding: 10px 14px;
      color: #fff;
      font-weight: 600;
      text-decoration: none;
      font-size: 15px;
      transition: all 0.3s ease;
    }

    .dropdown-content a:hover {
      background: #fff;
      color: #FF7B00;
    }

    .dropdown:hover .dropdown-content {
      display: block;
    }

    /* ===== Auth Links ===== */
    .auth-links {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .auth-links a {
      background: #fff;
      color: #FF8C00;
      font-weight: 600;
      text-decoration: none;
      padding: 7px 14px;
      border-radius: 6px;
      transition: all 0.3s ease;
      font-size: 15px;
    }

    .auth-links a:hover {
      background: #FF8C00;
      color: #fff;
    }

    .welcome {
      font-weight: 600;
    }

    #themeToggle {
      background: none;
      border: 2px solid #fff;
      border-radius: 50%;
      width: 32px;
      height: 32px;
      font-size: 1.1rem;
      cursor: pointer;
      color: #fff;
      transition: all 0.3s ease;
    }

    #themeToggle:hover {
      background: #fff;
      color: #FF8C00;
    }

    /* ===== Page Container ===== */
    .container {
      max-width: 1000px;
      margin: 30px auto;
      background: #fff;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      font-family: "Poppins", sans-serif;
    }

    h1 {
      text-align: center;
      color: #FF8C00;
      font-weight: 700;
    }

    p {
      text-align: center;
      color: #444;
      font-weight: 500;
    }

    input[type="text"] {
      width: 100%;
      padding: 12px;
      margin: 15px 0;
      border-radius: 8px;
      border: 1px solid #ccc;
      font-size: 1rem;
    }

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
      font-weight: 600;
    }

    .recipe-card:hover {
      transform: scale(1.05);
      background: #FF8C00;
      color: #fff;
    }

    .recipe-card:hover h3 {
      color: #fff;
    }

    .not-found {
      text-align: center;
      font-size: 1.2rem;
      color: #FF8C00;
      margin-top: 20px;
      display: none;
    }

    a.back {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 15px;
      background: #FF8C00;
      color: #fff;
      text-decoration: none;
      border-radius: 6px;
      transition: all 0.3s ease;
      font-weight: 600;
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
    <div class="logo"><a href="index.php">🍳 Veggiedelights</a></div>
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

  <!-- ===== Recipe Search Page ===== -->
  <div class="container">
    <h1>Search Recipes</h1>
    <p>Type the name of a recipe to find it instantly:</p>
    <input type="text" id="searchInput" placeholder="Search for recipes...">

    <div class="recipe-list" id="recipeList">
      <!-- ✅ North Indian -->
      <div class="recipe-card" onclick="location.href='paneerbuttermasala.php'">
        <img src="https://aartimadan.com/wp-content/uploads/2023/11/Paneer-Butter-Masala-Restaurant-Style.jpg">
        <h3>Paneer Butter Masala</h3>
      </div>
      <div class="recipe-card" onclick="location.href='paneertikka.php'">
        <img src="https://spicecravings.com/wp-content/uploads/2020/10/Paneer-Tikka-Featured-1.jpg">
        <h3>Paneer Tikka</h3>
      </div>
      <div class="recipe-card" onclick="location.href='rajmachawal.php'">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSrY-YDbNH_JLFnMOh26A1l7WKFgORHz6C3uQ&s">
        <h3>Rajma Chawal</h3>
      </div>
      <div class="recipe-card" onclick="location.href='dalmakhani.php'">
        <img src="https://www.sharmispassions.com/wp-content/uploads/2012/05/dal-makhani7-500x500.jpg">
        <h3>Dal Makhani</h3>
      </div>

      <!-- ✅ South Indian -->
      <div class="recipe-card" onclick="location.href='idli.php'">
        <img src="https://t4.ftcdn.net/jpg/04/39/31/29/360_F_439312935_lxOEQSqasYc5GeyHKgYJXWCIFm8gmQUN.jpg">
        <h3>Idli</h3>
      </div>
      <div class="recipe-card" onclick="location.href='dosa.php'">
        <img src="https://t4.ftcdn.net/jpg/14/87/08/63/360_F_1487086307_TrQcEjsbQ1TAUk5A30EWqRp8aYvx9Yyb.jpg">
        <h3>Dosa</h3>
      </div>
      <div class="recipe-card" onclick="location.href='bisibelebath.php'">
        <img src="https://www.indianhealthyrecipes.com/wp-content/uploads/2021/07/bisi-bele-bath-recipe.jpg">
        <h3>Bisi Bele Bath</h3>
      </div>
      <div class="recipe-card" onclick="location.href='onionpakoda.php'">
        <img src="https://i.ytimg.com/vi/qfZ3axZV48A/maxresdefault.jpg">
        <h3>Onion Pakoda</h3>
      </div>

      <!-- ✅ Chinese -->
      <div class="recipe-card" onclick="location.href='springroll.php'">
        <img src="https://img.freepik.com/free-photo/fried-spring-rolls-cutting-board_1150-17010.jpg?semt=ais_hybrid&w=740&q=80">
        <h3>Spring Rolls</h3>
      </div>
      <div class="recipe-card" onclick="location.href='mapotofu.php'">
        <img src="https://i.ytimg.com/vi/wj24Tb8Lmtc/maxresdefault.jpg">
        <h3>Mapo Tofu</h3>
      </div>
      <div class="recipe-card" onclick="location.href='friedrice.php'">
        <img src="https://salasdaily.com/cdn/shop/products/VegFriedRice.jpg?v=1637640487">
        <h3>Fried Rice</h3>
      </div>
      <div class="recipe-card" onclick="location.href='vegetablenoodles.php'">
        <img src="https://herbivorecucina.com/wp-content/uploads/2016/11/Vegetarian-Hakka-Noodles-2.jpg">
        <h3>Veg Noodles</h3>
      </div>

      <!-- ✅ Italian -->
      <div class="recipe-card" onclick="location.href='pizza.php'">
        <img src="https://static.toiimg.com/thumb/53110049.cms?imgsize=203799&width=800&height=800">
        <h3>Pizza Margherita</h3>
      </div>
      <div class="recipe-card" onclick="location.href='risotto.php'">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQEkzCSIjXWzrUwrkjkF9dLh8KTqYyYOknaXw&sg">
        <h3>Risotto</h3>
      </div>
      <div class="recipe-card" onclick="location.href='lasagna.php'">
        <img src="https://itsavegworldafterall.com/wp-content/uploads/2022/12/Vegetable-Lasagna-with-White-Sauce-1.jpg">
        <h3>Vegetarian Lasagna</h3>
      </div>
      <div class="recipe-card" onclick="location.href='primavera.php'">
        <img src="https://cdn.loveandlemons.com/wp-content/uploads/2022/06/pasta-primavera.jpg">
        <h3>Pasta Primavera</h3>
      </div>
    </div>

    <p class="not-found" id="notFoundMessage">🍴 Recipe not found. Try another name!</p>
    <a href="index.php" class="back">← Back to Home</a>
  </div>

  <script>
    // ===== Recipe Search Filter =====
    const searchInput = document.getElementById('searchInput');
    const recipes = document.getElementsByClassName('recipe-card');
    const notFoundMessage = document.getElementById('notFoundMessage');

    searchInput.addEventListener('keyup', function() {
      const filter = searchInput.value.toLowerCase();
      let found = false;
      for (let i = 0; i < recipes.length; i++) {
        const recipeName = recipes[i].getElementsByTagName('h3')[0].textContent.toLowerCase();
        if (recipeName.includes(filter)) {
          recipes[i].style.display = "";
          found = true;
        } else {
          recipes[i].style.display = "none";
        }
      }
      notFoundMessage.style.display = found ? "none" : "block";
    });
  </script>
</body>
</html>
