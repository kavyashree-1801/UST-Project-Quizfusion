<?php
session_start();
include 'config.php'; // Your DB connection

// Get user role and email from session
$role = $_SESSION['role'] ?? 'guest';
$email = $_SESSION['email'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>View Recipes | Veggiedelights</title>
<style>
/* General styles */
body { font-family: Arial; background:#f0f0f0; margin:0; padding:20px;}
h1 { text-align:center; color:#ff8c00; margin-bottom:20px;}
.recipe-card { background:#fff; padding:15px; margin:10px auto; max-width:600px; border-radius:10px; box-shadow:0 2px 6px rgba(0,0,0,0.1);}
.recipe-card img { width:100%; height:auto; border-radius:8px; margin-bottom:10px;}
.recipe-card h2 { margin:5px 0; color:#333;}
.recipe-card p { color:#555; }
.added-by { font-style: italic; color:#777; margin-top:8px; }

/* Navbar styles */
header.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color:#ff7b00; /* Navbar orange background */
    padding:10px 20px;
    box-shadow:0 2px 4px rgba(0,0,0,0.1);
    position: sticky;
    top: 0;
    z-index: 100;
}

header.navbar .logo a {
    text-decoration: none;
    font-size: 1.5rem;
    color:#fff;
    font-weight: bold;
}

header.navbar nav a {
    margin: 0 10px;
    text-decoration: none;
    color:#fff;
    padding:5px 10px;
    border-radius:5px;
    transition: all 0.3s;
}

header.navbar nav a:hover {
    background-color:#fff;
    color:#ff7b00;
}

header.navbar nav .dropdown {
    position: relative;
    display: inline-block;
}

header.navbar nav .dropdown-content {
    display: none;
    position: absolute;
    background-color:#fff;
    min-width: 180px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    z-index: 1;
}

header.navbar nav .dropdown-content a {
    display: block;
    padding:10px 15px;
    color:#333;
    text-decoration: none;
    transition: all 0.3s;
}

header.navbar nav .dropdown:hover .dropdown-content {
    display: block;
}

/* Admin dropdown hover */
header.navbar nav .dropdown-content a:hover {
    background-color:#ff7b00;
    color:#fff;
}

/* Logout button */
.auth-links .nav-link {
    background-color: #fff;
    color: #ff7b00;
    padding: 5px 10px;
    border-radius: 5px;
    text-decoration: none;
    transition: all 0.3s;
}

.auth-links .nav-link:hover {
    background-color: #ff7b00;
    color: #fff;
}

.auth-links {
    display: flex;
    align-items: center;
    gap: 10px;
}
.auth-links .welcome {
    margin-right: 10px;
    color: #fff;
}
</style>
</head>
<body>

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
            </div>
        </div>
        

        <?php if ($role === 'user'): ?>
            <a href="contact.php">Contact</a>
            <a href="feedback.php">Feedback</a>
        <?php endif; ?>

        <?php if ($role === 'admin'): ?>
            <div class="dropdown">
                <a href="#">Admin Panel ▾</a>
                <div class="dropdown-content">
                    <a href="view_users.php">Manage Users</a>
                    <a href="view_recipes.php">Manage Recipes</a>
                    <a href="manage_categories.php">Manage Categories</a>
                    <a href="view_feedback.php">Manage Feedback</a>
                    <a href="view_contact.php">Manage Contact</a>
                </div>
            </div>
        <?php endif; ?>
    </nav>
    <div class="auth-links">
        <?php if ($role === 'admin'): ?>
            <span class="welcome">👋 Hello Admin</span>
            <a href="logout.php" class="nav-link">Logout</a>
        <?php elseif ($role === 'user'): ?>
            <span class="welcome">👋 Hello <?php echo htmlspecialchars($email); ?></span>
            <a href="logout.php" class="nav-link">Logout</a>
        <?php else: ?>
            <a href="login.php" class="nav-link">Login</a>
            <a href="admin_login.php" class="nav-link">Admin</a>
        <?php endif; ?>
    </div>
</header>

<h1>All Recipes</h1>

<?php
$result = $con->query("SELECT * FROM recipes ORDER BY id DESC");

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="recipe-card">';
        
        // Recipe image
        if (!empty($row['image']) && file_exists($row['image'])) {
            echo '<img src="'.htmlspecialchars($row['image']).'" alt="Recipe Image">';
        } else {
            echo '<img src="uploads/default.png" alt="No Image">';
        }

        // Recipe details
        echo '<h2>'.htmlspecialchars($row['name']).'</h2>';
        echo '<p><strong>Ingredients:</strong> '.htmlspecialchars($row['ingredients']).'</p>';
        echo '<p><strong>Steps:</strong> '.nl2br(htmlspecialchars($row['steps'])).'</p>';

        // Added by (user email from recipes table)
        if (!empty($row['user_email'])) {
            echo '<p class="added-by">Added by: <strong>'.htmlspecialchars($row['user_email']).'</strong></p>';
        } else {
            echo '<p class="added-by">Added by: <em>Unknown</em></p>';
        }

        echo '</div>';
    }
} else {
    echo "<p style='text-align:center;color:#555;'>No recipes added yet.</p>";
}
?>

</body>
</html>
