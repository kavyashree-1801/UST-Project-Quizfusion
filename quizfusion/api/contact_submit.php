<?php
session_start();
include "../config.php";
header("Content-Type: application/json");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status"=>"error","message"=>"Unauthorized"]);
    exit;
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

if (!$name || !$email || !$message) {
    echo json_encode(["status"=>"error","message"=>"All fields required"]);
    exit;
}

$stmt = $con->prepare(
    "INSERT INTO contact_messages (user_id, name, email, message, created_at)
     VALUES (?, ?, ?, ?, NOW())"
);
$stmt->bind_param("isss", $_SESSION['user_id'], $name, $email, $message);

if ($stmt->execute()) {
    echo json_encode(["status"=>"success","message"=>"Message sent successfully"]);
} else {
    echo json_encode(["status"=>"error","message"=>"Failed to send message"]);
}
