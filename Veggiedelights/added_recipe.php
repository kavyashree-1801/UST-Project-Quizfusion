<?php
session_start();
error_reporting(0);
include 'config.php'; // Make sure you have your DB connection here

if (!isset($_SESSION['email'])) {
    header("Location: add_recipe.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $ingredients = trim($_POST['ingredients']);
    $steps = trim($_POST['steps']);

    // Image Upload Handling
    $imagePath = "";
    if(isset($_FILES['image']) && $_FILES['image']['name'] != "") {
        $targetDir = "uploads/";
        if(!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true); // Create uploads folder if not exists
        }

        $fileName = time() . "_" . basename($_FILES['image']['name']);
        $targetFile = $targetDir . $fileName;

        // Move uploaded file
        if(move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $imagePath = $targetFile;
        } else {
            // Redirect to add recipe page on failure
            header("Location: add_recipe.php?status=error");
            exit;
        }
    }

    // Insert into DB
    $email = $_SESSION['email'];
    $stmt = $con->prepare("INSERT INTO recipes (user_email, name, ingredients, steps, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $email, $name, $ingredients, $steps, $imagePath);

    if($stmt->execute()) {
        // Redirect to homepage with success alert
        header("Location: index.php?status=success");
        exit;
    } else {
        header("Location: add_recipe.php?status=error");
        exit;
    }
} else {
    header("Location: add_recipe.php");
    exit;
}
?>
