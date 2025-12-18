<?php
session_start();
include "../config.php";

$quiz_id = 5;
$category = "Maths & Logic";

/* CHECK LOGIN */
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "login"]);
    exit;
}

/* GET USER EMAIL */
$uid = $_SESSION['user_id'];
$u = mysqli_query($con, "SELECT email FROM users WHERE id='$uid'");
$user = mysqli_fetch_assoc($u);
$email = $user['email'];

/* RESTART */
if (isset($_POST['restart'])) {
    unset($_SESSION['math_questions']);
    unset($_SESSION['math_index']);
    unset($_SESSION['math_score']);
    exit;
}

/* INIT QUESTIONS */
if (!isset($_SESSION['math_questions'])) {
    $q = mysqli_query($con, "SELECT * FROM questions WHERE quiz_id='$quiz_id'");
    $questions = mysqli_fetch_all($q, MYSQLI_ASSOC);
    shuffle($questions);

    $_SESSION['math_questions'] = $questions;
    $_SESSION['math_index'] = 0;
    $_SESSION['math_score'] = 0;
}

$questions = $_SESSION['math_questions'];
$index = $_SESSION['math_index'];
$total = count($questions);

/* FINISH QUIZ */
if ($index >= $total) {

    $score = $_SESSION['math_score'];

    // 🔥 STORE SCORE IN DB (ONLY ONCE)
    mysqli_query($con, "
        INSERT INTO quiz_results 
        (quiz_id, email, category, total_questions, score, taken_on)
        VALUES 
        ('$quiz_id', '$email', '$category', '$total', '$score', NOW())
    ");

    // CLEAR SESSION
    unset($_SESSION['math_questions']);
    unset($_SESSION['math_index']);
    unset($_SESSION['math_score']);

    echo json_encode([
        "finished" => true,
        "score" => $score,
        "total" => $total
    ]);
    exit;
}

$current = $questions[$index];

/* CHECK ANSWER */
if (isset($_POST['answer'])) {
    if ($_POST['answer'] === $current['answer']) {
        $_SESSION['math_score']++;
    }
}

/* NEXT QUESTION */
if (isset($_POST['next'])) {
    $_SESSION['math_index']++;
}

/* SEND QUESTION */
echo json_encode([
    "finished" => false,
    "index" => $index + 1,
    "total" => $total,
    "question" => $current['question'],
    "options" => [
        $current['option1'],
        $current['option2'],
        $current['option3'],
        $current['option4']
    ],
    "answer" => $current['answer'],
    "hint" => $current['hint']
]);
