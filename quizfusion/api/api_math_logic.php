<?php
session_start();
include "../config.php";

$quiz_id = 5; // fixed quiz ID

/* CHECK LOGIN */
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "login"]);
    exit;
}

$uid = $_SESSION['user_id'];
$u = mysqli_query($con, "SELECT email FROM users WHERE id='$uid'");
$user = mysqli_fetch_assoc($u);
$email = $user['email'];

/* RESTART QUIZ */
if (isset($_POST['restart'])) {
    unset($_SESSION["quiz_{$quiz_id}_questions"]);
    unset($_SESSION["quiz_{$quiz_id}_index"]);
    unset($_SESSION["quiz_{$quiz_id}_score"]);
    exit;
}

/* INIT QUESTIONS */
if (!isset($_SESSION["quiz_{$quiz_id}_questions"])) {
    $q = mysqli_query($con, "SELECT * FROM questions WHERE quiz_id='$quiz_id'");
    $questions = mysqli_fetch_all($q, MYSQLI_ASSOC);
    shuffle($questions);

    $_SESSION["quiz_{$quiz_id}_questions"] = $questions;
    $_SESSION["quiz_{$quiz_id}_index"] = 0;
    $_SESSION["quiz_{$quiz_id}_score"] = 0;
}

$questions = $_SESSION["quiz_{$quiz_id}_questions"];
$index = $_SESSION["quiz_{$quiz_id}_index"];
$total = count($questions);

/* FINISH QUIZ */
if ($index >= $total) {
    $score = $_SESSION["quiz_{$quiz_id}_score"];

    mysqli_query($con, "
        INSERT INTO quiz_results (quiz_id, email, category, total_questions, score, taken_on)
        VALUES ('$quiz_id', '$email', 'Maths & Logic', '$total', '$score', NOW())
    ");

    unset($_SESSION["quiz_{$quiz_id}_questions"]);
    unset($_SESSION["quiz_{$quiz_id}_index"]);
    unset($_SESSION["quiz_{$quiz_id}_score"]);

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
        $_SESSION["quiz_{$quiz_id}_score"]++;
    }
}

/* NEXT QUESTION */
if (isset($_POST['next'])) {
    $_SESSION["quiz_{$quiz_id}_index"]++;
}

/* SEND CURRENT QUESTION */
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
