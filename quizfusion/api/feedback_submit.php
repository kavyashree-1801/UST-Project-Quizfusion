<?php
session_start();
include '../config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status"=>"error","message"=>"Unauthorized"]);
    exit;
}

$user_id = intval($_SESSION['user_id']);
$rating = intval($_POST['rating'] ?? 0);
$comments = trim($_POST['comments'] ?? '');

if ($rating < 1 || $rating > 5 || empty($comments)) {
    echo json_encode(["status"=>"error","message"=>"Please provide valid rating and comments."]);
    exit;
}

$stmt = $con->prepare("INSERT INTO feedback (user_id, rating, comments, created_at) VALUES (?, ?, ?, NOW())");
$stmt->bind_param("iis", $user_id, $rating, $comments);

if ($stmt->execute()) {
    echo json_encode(["status"=>"success", "message"=>"Thank you! Your feedback has been submitted."]);
} else {
    echo json_encode(["status"=>"error", "message"=>"Failed to submit feedback."]);
}
$stmt->close();
$con->close();
