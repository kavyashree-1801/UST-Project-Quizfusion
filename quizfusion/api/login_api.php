<?php
session_start();
include '../config.php';

header('Content-Type: application/json');

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if (!$email || !$password) {
    echo json_encode(["status"=>"error","message"=>"All fields required"]);
    exit;
}

$stmt = $con->prepare("SELECT id, password, role FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows !== 1) {
    echo json_encode(["status"=>"error","message"=>"Invalid credentials"]);
    exit;
}

$user = $res->fetch_assoc();

if (!password_verify($password, $user['password'])) {
    echo json_encode(["status"=>"error","message"=>"Invalid credentials"]);
    exit;
}

$_SESSION['user_id'] = $user['id'];
$_SESSION['role'] = $user['role'];

$redirect = ($user['role'] === 'admin') ? "homepage.php" : "homepage.php";

echo json_encode([
    "status" => "success",
    "redirect" => $redirect
]);
