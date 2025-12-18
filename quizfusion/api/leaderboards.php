<?php
session_start();
include '../config.php';
header('Content-Type: application/json');

// ------------------------
// 1. Ensure user is logged in
// ------------------------
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

// ------------------------
// 2. Get category filter from GET (optional)
// ------------------------
$category = $_GET['category'] ?? 'all';

// ------------------------
// 3. SQL query
// ------------------------
if ($category === 'all') {
    // All quizzes, all users
    $sql = "SELECT u.email, q.category, qr.total_questions, qr.score, qr.taken_on
            FROM quiz_results qr
            JOIN users u ON qr.id = u.id
            JOIN quizzes q ON qr.quiz_id = q.id
            ORDER BY q.category ASC, qr.score DESC, qr.taken_on ASC";
    $stmt = $con->prepare($sql);
} else {
    // Only this category
    $sql = "SELECT u.email, q.category, qr.total_questions, qr.score, qr.taken_on
            FROM quiz_results qr
            JOIN users u ON qr.id = u.id
            JOIN quizzes q ON qr.quiz_id = q.id
            WHERE q.category = ?
            ORDER BY qr.score DESC, qr.taken_on ASC";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $category);
}

// ------------------------
// 4. Execute query
// ------------------------
if (!$stmt) {
    echo json_encode(["error" => "SQL prepare failed: " . $con->error]);
    exit;
}

$stmt->execute();
$result = $stmt->get_result();

$data = [];
$rank = 1;
while ($row = $result->fetch_assoc()) {
    $row['rank'] = $rank++;
    $data[] = $row;
}

// ------------------------
// 5. Return JSON
// ------------------------
echo json_encode($data);

$stmt->close();
$con->close();
?>
