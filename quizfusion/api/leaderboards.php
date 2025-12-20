<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../config.php';

// Auth check
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

$category = $_GET['category'] ?? 'all';

/*
|--------------------------------------------------------------------------
| Fetch categories (from quizzes table only)
|--------------------------------------------------------------------------
*/
if ($category === 'categories') {
    $sql = "SELECT DISTINCT category FROM quizzes ORDER BY category ASC";
    $stmt = $con->prepare($sql);

    if (!$stmt) {
        echo json_encode(["error" => $con->error]);
        exit;
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $categories = [];
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row['category'];
    }

    echo json_encode($categories);
    exit;
}

/*
|--------------------------------------------------------------------------
| Leaderboard data (EMAIL FROM quiz_results ONLY)
|--------------------------------------------------------------------------
*/
if ($category === 'all') {

    $sql = "
        SELECT
            qr.email,
            q.category,
            qr.total_questions,
            qr.score,
            qr.taken_on
        FROM quiz_results qr
        LEFT JOIN quizzes q ON qr.quiz_id = q.id
        WHERE q.category IS NOT NULL
        ORDER BY q.category ASC, qr.score DESC, qr.taken_on ASC
    ";

    $stmt = $con->prepare($sql);

} else {

    $sql = "
        SELECT
            qr.email,
            q.category,
            qr.total_questions,
            qr.score,
            qr.taken_on
        FROM quiz_results qr
        LEFT JOIN quizzes q ON qr.quiz_id = q.id
        WHERE q.category = ?
        ORDER BY qr.score DESC, qr.taken_on ASC
    ";

    $stmt = $con->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("s", $category);
    }
}

// Safety check
if (!$stmt) {
    echo json_encode([
        "error" => "SQL prepare failed",
        "details" => $con->error
    ]);
    exit;
}

$stmt->execute();
$result = $stmt->get_result();

/*
|--------------------------------------------------------------------------
| Build response with rank
|--------------------------------------------------------------------------
*/
$data = [];
$rank = 1;

while ($row = $result->fetch_assoc()) {
    $row['rank'] = $rank++;
    $data[] = $row;
}

echo json_encode($data);
