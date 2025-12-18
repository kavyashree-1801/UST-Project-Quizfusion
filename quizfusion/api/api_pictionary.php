<?php
session_start();
include "../config.php";

/* ===============================
   CONFIG
================================ */
$quiz_id  = 3;
$category = "Pictionary";

/* ===============================
   AUTH CHECK
================================ */
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "login"]);
    exit;
}

/* ===============================
   GET USER EMAIL
================================ */
$uid = $_SESSION['user_id'];
$u   = mysqli_query($con, "SELECT email FROM users WHERE id='$uid'");
$user = mysqli_fetch_assoc($u);
$email = $user['email'];

/* ===============================
   RESTART QUIZ
================================ */
if (isset($_POST['restart'])) {
    unset($_SESSION['pic_questions']);
    unset($_SESSION['pic_index']);
    unset($_SESSION['pic_score']);
    exit;
}

/* ===============================
   LOAD QUESTIONS (ONCE)
================================ */
if (!isset($_SESSION['pic_questions'])) {

    $q = mysqli_query(
        $con,
        "SELECT * FROM questions WHERE quiz_id='$quiz_id'"
    );

    $questions = mysqli_fetch_all($q, MYSQLI_ASSOC);

    shuffle($questions);

    $_SESSION['pic_questions'] = $questions;
    $_SESSION['pic_index'] = 0;
    $_SESSION['pic_score'] = 0;
}

/* ===============================
   CURRENT STATE
================================ */
$questions = $_SESSION['pic_questions'];
$index     = $_SESSION['pic_index'];
$total     = count($questions);

/* ===============================
   QUIZ FINISHED
================================ */
if ($index >= $total) {

    $score = $_SESSION['pic_score'];

    // STORE RESULT (ONCE)
    mysqli_query($con, "
        INSERT INTO quiz_results
        (quiz_id, email, category, total_questions, score, taken_on)
        VALUES
        ('$quiz_id', '$email', '$category', '$total', '$score', NOW())
    ");

    // CLEAR SESSION
    unset($_SESSION['pic_questions']);
    unset($_SESSION['pic_index']);
    unset($_SESSION['pic_score']);

    echo json_encode([
        "finished" => true,
        "score"    => $score,
        "total"    => $total
    ]);
    exit;
}

/* ===============================
   CURRENT QUESTION
================================ */
$current = $questions[$index];

/* ===============================
   CHECK ANSWER
================================ */
if (isset($_POST['answer'])) {
    if ($_POST['answer'] === $current['answer']) {
        $_SESSION['pic_score']++;
    }
}

/* ===============================
   NEXT QUESTION
================================ */
if (isset($_POST['next'])) {
    $_SESSION['pic_index']++;
}

/* ===============================
   RESPONSE
================================ */
echo json_encode([
    "finished" => false,
    "index"    => $index + 1,
    "total"    => $total,
    "question" => $current['question'],
    "image"    => $current['image'],   // image path or URL
    "options"  => [
        $current['option1'],
        $current['option2'],
        $current['option3'],
        $current['option4']
    ],
    "answer"   => $current['answer'],
    "hint"     => $current['hint']
]);
