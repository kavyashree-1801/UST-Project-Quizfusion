<?php
session_start();
header("Content-Type: application/json");

require_once __DIR__ . "/../config.php";

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || $email === '' || $message === '') {
    echo json_encode([
        "status" => "error",
        "message" => "All fields required"
    ]);
    exit;
}

$stmt = $con->prepare(
    "INSERT INTO contact_messages (name, email, message)
     VALUES (?, ?, ?)"
);

if (!$stmt) {
    echo json_encode([
        "status" => "error",
        "message" => "SQL error: " . $con->error
    ]);
    exit;
}

$stmt->bind_param("sss", $name, $email, $message);

if ($stmt->execute()) {
    echo json_encode([
        "status" => "success",
        "message" => "Message sent successfully"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => $stmt->error
    ]);
}

$stmt->close();
$con->close();
