<?php
session_start();
include 'config.php';

// Make sure user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to submit a message.");
}

$user_id = intval($_SESSION['user_id']);

// Fetch user's email
$stmt = $con->prepare("SELECT email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$email = $user['email'];
$stmt->close();

// Validate POST data
if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['message'])) {
    die("Please fill out all fields.");
}

$name = trim($_POST['name']);
$email_input = trim($_POST['email']);
$message = trim($_POST['message']);
$submitted_on = date("Y-m-d H:i:s");

// Insert into contact table
$stmt = $con->prepare("INSERT INTO contact_messages (name, email, message, submitted_on) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email_input, $message, $submitted_on);

if ($stmt->execute()) {
    $stmt->close();
    // Redirect back to contact page with success message
    header("Location: contact.php?success=1");
    exit;
} else {
    die("Error saving message: " . $stmt->error);
}
?>
