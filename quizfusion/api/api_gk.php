<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/quizfusion/config.php';
header("Content-Type: application/json");

// ---------- AUTH ----------
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "USER_NOT_LOGGED_IN"]);
    exit;
}

$user_id = $_SESSION['user_id'];

// ---------- USER ----------
$userQ = mysqli_query($con, "SELECT email FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($userQ);
$email = $user['email'] ?? null;

if (!$email) {
    echo json_encode(["error" => "USER_NOT_FOUND"]);
    exit;
}

// ---------- QUIZ ----------
$category = "General_knowledge";
$quizQ = mysqli_query($con, "SELECT id FROM quizzes WHERE category='$category'");
$quiz = mysqli_fetch_assoc($quizQ);

if (!$quiz) {
    echo json_encode(["error" => "QUIZ_NOT_FOUND"]);
    exit;
}

$quiz_id = $quiz['id'];

// ---------- LOAD QUESTIONS ----------
if (!isset($_SESSION['questions'])) {

    $q = mysqli_query($con, "
        SELECT question, option1, option2, option3, option4, answer, hint
        FROM questions
        WHERE quiz_id='$quiz_id'
    ");

    $questions = mysqli_fetch_all($q, MYSQLI_ASSOC);

    if (count($questions) === 0) {
        echo json_encode(["error" => "NO_QUESTIONS"]);
        exit;
    }

    shuffle($questions);
    $_SESSION['questions'] = $questions;
    $_SESSION['index'] = 0;
    $_SESSION['score'] = 0;
}

$questions = $_SESSION['questions'];
$index = $_SESSION['index'];
$total = count($questions);

// ---------- CHECK ANSWER ----------
if (isset($_POST['answer'])) {
    if ($_POST['answer'] === $questions[$index]['answer']) {
        $_SESSION['score']++;
    }
}

// ---------- NEXT ----------
if (isset($_POST['next'])) {
    $_SESSION['index']++;

    if ($_SESSION['index'] >= $total) {

        $score = $_SESSION['score']; // save score before clearing

        mysqli_query($con, "
            INSERT INTO quiz_results
            (quiz_id, email, category, total_questions, score, taken_on)
            VALUES
            ('$quiz_id', '$email', '$category', '$total', '$score', NOW())
        ");

        // Clear only quiz session variables
        unset($_SESSION['questions']);
        unset($_SESSION['index']);
        unset($_SESSION['score']);

        echo json_encode([
            "finished" => true,
            "score" => $score,
            "total" => $total
        ]);

        exit;
    }
}

// ---------- RESTART QUIZ ----------
if (isset($_POST['restart'])) {
    unset($_SESSION['questions']);
    unset($_SESSION['index']);
    unset($_SESSION['score']);

    echo json_encode(["restarted" => true]);
    exit;
}

// ---------- SEND QUESTION ----------
$current = $questions[$_SESSION['index']];

echo json_encode([
    "finished" => false,
    "question" => $current['question'],
    "options" => [
        $current['option1'],
        $current['option2'],
        $current['option3'],
        $current['option4']
    ],
    "answer" => $current['answer'],
    "hint" => $current['hint'],
    "index" => $_SESSION['index'] + 1,
    "total" => $total
]);
