<?php
session_start();
include 'config.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo "Unauthorized: Please login first.";
    exit;
}

$user_id = intval($_SESSION['user_id']);

// Get POST data
$quiz_id = isset($_POST['quiz_id']) ? intval($_POST['quiz_id']) : null;
$category = isset($_POST['category']) ? trim($_POST['category']) : '';
$score = isset($_POST['score']) ? intval($_POST['score']) : 0;
$total_questions = isset($_POST['total_questions']) ? intval($_POST['total_questions']) : 0;

if (!$quiz_id || !$category || $total_questions <= 0) {
    http_response_code(400);
    echo "Invalid data sent.";
    exit;
}

// Optional: check if user already has a result for this quiz
$stmt_check = $con->prepare("SELECT id FROM quiz_results WHERE user_id=? AND quiz_id=? LIMIT 1");
$stmt_check->bind_param("ii", $user_id, $quiz_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    // Update existing record
    $stmt_update = $con->prepare("UPDATE quiz_results SET score=?, total_questions=?, date_taken=NOW() WHERE user_id=? AND quiz_id=?");
    $stmt_update->bind_param("iiii", $score, $total_questions, $user_id, $quiz_id);
    if ($stmt_update->execute()) echo "Score updated successfully.";
    else echo "Failed to update score: " . $stmt_update->error;
    $stmt_update->close();
} else {
    // Insert new record
    $stmt_insert = $con->prepare("INSERT INTO quiz_results (user_id, quiz_id, category, score, total_questions, date_taken) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt_insert->bind_param("iisii", $user_id, $quiz_id, $category, $score, $total_questions);
    if ($stmt_insert->execute()) echo "Score saved successfully.";
    else echo "Failed to save score: " . $stmt_insert->error;
    $stmt_insert->close();
}

$stmt_check->close();
?>
