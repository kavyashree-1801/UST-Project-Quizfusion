<?php
session_start();
include "../config.php";
header("Content-Type: application/json");

/* ================= CAPTCHA ================= */
if (isset($_GET['action']) && $_GET['action'] === 'captcha') {
    $a = rand(1, 9);
    $b = rand(1, 9);
    $_SESSION['captcha_answer'] = $a + $b;
    echo json_encode(["question" => "$a + $b = ?"]);
    exit;
}

/* ================= REGISTER ================= */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $captcha = intval($_POST['captcha'] ?? 0);
    $security_question = trim($_POST['security_question'] ?? '');
    $security_answer = trim($_POST['security_answer'] ?? '');

    // Check required fields
    if (!$name || !$email || !$password || !$security_question || !$security_answer) {
        echo json_encode(["status"=>"error","message"=>"All fields are required"]);
        exit;
    }

    // CAPTCHA verification
    if ($captcha !== ($_SESSION['captcha_answer'] ?? -1)) {
        echo json_encode(["status"=>"error","message"=>"Incorrect CAPTCHA"]);
        exit;
    }

    // Check if email already exists
    $stmtCheck = $con->prepare("SELECT id FROM users WHERE email=?");
    $stmtCheck->bind_param("s", $email);
    $stmtCheck->execute();
    $stmtCheck->store_result();
    if ($stmtCheck->num_rows > 0) {
        echo json_encode(["status"=>"error","message"=>"Email already exists"]);
        exit;
    }

    // Hash password and security answer
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $secAnswerHash = password_hash($security_answer, PASSWORD_DEFAULT);

    // Insert into database
    $stmt = $con->prepare("INSERT INTO users (name,email,password,security_question,security_answer) VALUES (?,?,?,?,?)");
    $stmt->bind_param("sssss", $name, $email, $hash, $security_question, $secAnswerHash);

    if ($stmt->execute()) {
        echo json_encode(["status"=>"success","message"=>"Registered successfully"]);
    } else {
        echo json_encode(["status"=>"error","message"=>"Registration failed"]);
    }
}
