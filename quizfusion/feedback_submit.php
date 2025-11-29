<?php
session_start();
include 'config.php';

// Make sure user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to submit feedback.");
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
if (!isset($_POST['rating']) || !isset($_POST['comments'])) {
    die("Please fill out all fields.");
}

$rating = intval($_POST['rating']);
$comments = trim($_POST['comments']);
$submitted_on = date("Y-m-d H:i:s");

// Insert into feedback table
$stmt = $con->prepare("INSERT INTO feedback (email, rating, comments, submitted_on) VALUES (?, ?, ?, ?)");
$stmt->bind_param("siss", $email, $rating, $comments, $submitted_on);

if ($stmt->execute()) {
    $stmt->close();
    // Redirect back to feedback page with success message
    header("Location: homepage.php?success=1");
    exit;
} else {
    die("Error saving feedback: " . $stmt->error);
}
?>
