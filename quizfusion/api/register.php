<?php
session_start();
include "../config.php";
header("Content-Type: application/json");

/* CAPTCHA */
if (isset($_GET['action']) && $_GET['action'] === 'captcha') {
    $a = rand(1, 9);
    $b = rand(1, 9);
    $_SESSION['captcha_answer'] = $a + $b;
    echo json_encode(["question" => "$a + $b = ?"]);
    exit;
}

/* REGISTER */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $captcha = intval($_POST['captcha'] ?? 0);

    if ($captcha !== ($_SESSION['captcha_answer'] ?? -1)) {
        echo json_encode(["status"=>"error","message"=>"Incorrect CAPTCHA"]);
        exit;
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $con->prepare("INSERT INTO users (name,email,password) VALUES (?,?,?)");
    $stmt->bind_param("sss", $name, $email, $hash);

    if ($stmt->execute()) {
        echo json_encode(["status"=>"success","message"=>"Registered successfully"]);
    } else {
        echo json_encode(["status"=>"error","message"=>"Email already exists"]);
    }
}
