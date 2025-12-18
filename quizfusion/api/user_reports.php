<?php
session_start();
header('Content-Type: application/json');
include '../config.php'; // Adjust path if needed

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error'=>'Not logged in']);
    exit;
}

$user_id = intval($_SESSION['user_id']);

// Fetch user email
$stmt = $con->prepare("SELECT email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();
$user_email = $user['email'] ?? "";

// --- USER STATS ---
$data = [];

// Total quizzes attempted
$stmt = $con->prepare("SELECT COUNT(*) AS total FROM quiz_results WHERE email=?");
$stmt->bind_param("s", $user_email);
$stmt->execute();
$stmt->bind_result($data['totalQuizzes']);
$stmt->fetch();
$stmt->close();

// Top category by average score
$data['topCategory'] = "No data";
$stmt = $con->prepare("
    SELECT category, AVG(score/total_questions) AS avg_score
    FROM quiz_results
    WHERE email = ?
    GROUP BY category
    ORDER BY avg_score DESC
    LIMIT 1
");
$stmt->bind_param("s", $user_email);
$stmt->execute();
$stmt->bind_result($catName, $avgScore);
if ($stmt->fetch()) $data['topCategory'] = $catName;
$stmt->close();

// Last 5 attempts
$data['recentAttempts'] = [];
$stmt = $con->prepare("
    SELECT quiz_id, category, total_questions, score, taken_on
    FROM quiz_results
    WHERE email = ?
    ORDER BY taken_on DESC
    LIMIT 5
");
$stmt->bind_param("s", $user_email);
$stmt->execute();
$res = $stmt->get_result();
while ($r = $res->fetch_assoc()) $data['recentAttempts'][] = $r;
$stmt->close();

// Pie chart data
$data['chart'] = ['labels'=>[], 'values'=>[]];
$stmt = $con->prepare("
    SELECT category, COUNT(*) AS cnt 
    FROM quiz_results 
    WHERE email = ?
    GROUP BY category
");
$stmt->bind_param("s", $user_email);
$stmt->execute();
$res = $stmt->get_result();
while ($r = $res->fetch_assoc()) {
    $data['chart']['labels'][] = $r['category'];
    $data['chart']['values'][] = (int)$r['cnt'];
}
$stmt->close();

// Highest score
$stmt = $con->prepare("SELECT MAX(score/total_questions*100) AS highest FROM quiz_results WHERE email = ?");
$stmt->bind_param("s", $user_email);
$stmt->execute();
$stmt->bind_result($highest);
if ($stmt->fetch()) $data['highestScore'] = round($highest,2)."%";
else $data['highestScore'] = "—";
$stmt->close();

$con->close();
echo json_encode($data);
