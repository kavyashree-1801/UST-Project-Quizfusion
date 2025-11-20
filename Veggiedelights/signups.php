<?php
session_start();
include 'config.php'; // Your DB connection file

header('Content-Type: application/json'); // Always return JSON

$response = ['status' => '', 'message' => ''];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['ajax'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmpassword = trim($_POST['confirmpassword']);
    $security_question = trim($_POST['security_question']);
    $security_answer = trim($_POST['security_answer']);

    // Validate passwords match
    if ($password !== $confirmpassword) {
        $response['status'] = 'error';
        $response['message'] = 'Passwords do not match!';
        echo json_encode($response);
        exit;
    }

    // Check if email already exists
    $stmt = $con->prepare("SELECT email FROM signup WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $response['status'] = 'error';
        $response['message'] = 'Email already registered!';
        echo json_encode($response);
        exit;
    }

    // Hash password and security answer
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $hashed_answer = password_hash($security_answer, PASSWORD_DEFAULT);

    // Default role for every signup (can be 'user' or 'admin')
    $default_role = 'user';

    // Insert user into database
    $stmt = $con->prepare("
        INSERT INTO signup (name, email, password, security_question, security_answer, role)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("ssssss", $name, $email, $hashed_password, $security_question, $hashed_answer, $default_role);

    if ($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Registration successful! Redirecting to login...';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Something went wrong. Please try again!';
    }

    echo json_encode($response);
    exit;
}
?>
