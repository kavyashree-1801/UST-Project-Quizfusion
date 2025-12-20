<?php
session_start();
header('Content-Type: application/json');
include '../config.php';

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$rating = $_POST['rating'] ?? '';
$comments = trim($_POST['comments'] ?? '');

if ($name === '' || $email === '' || $rating === '' || $comments === '') {
    echo json_encode(["status" => "error", "message" => "All fields are required"]);
    exit;
}

// Insert feedback into table
$stmt = $con->prepare("INSERT INTO feedback (name, email, rating, comments) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssis", $name, $email, $rating, $comments);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Feedback submitted successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => $stmt->error]);
}

$stmt->close();
$con->close();
