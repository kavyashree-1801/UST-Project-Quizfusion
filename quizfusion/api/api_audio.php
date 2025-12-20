<?php
session_start();
include "../config.php";

$quiz_id = 4;
$category = "Audio";

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "login"]);
    exit;
}

/* USER EMAIL */
$uid = $_SESSION['user_id'];
$u = mysqli_query($con, "SELECT email FROM users WHERE id=$uid");
$email = mysqli_fetch_assoc($u)['email'];

/* RESTART */
if (isset($_POST['restart'])) {
    unset($_SESSION['audio_questions']);
    unset($_SESSION['audio_index']);
    unset($_SESSION['audio_score']);
    exit;
}

/* INIT */
if (!isset($_SESSION['audio_questions'])) {
    $q = mysqli_query($con, "SELECT * FROM questions WHERE quiz_id=4");
    $rows = mysqli_fetch_all($q, MYSQLI_ASSOC);

    if (count($rows) == 0) {
        echo json_encode(["error" => "No questions"]);
        exit;
    }

    shuffle($rows);
    $_SESSION['audio_questions'] = $rows;
    $_SESSION['audio_index'] = 0;
    $_SESSION['audio_score'] = 0;
}

$questions = $_SESSION['audio_questions'];
$index = $_SESSION['audio_index'];
$total = count($questions);

/* ANSWER */
if (isset($_POST['answer'])) {
    if ($_POST['answer'] === $questions[$index]['answer']) {
        $_SESSION['audio_score']++;
    }
}

/* NEXT */
if (isset($_POST['next'])) {
    $_SESSION['audio_index']++;
}

/* FINISH */
if ($index >= $total) {

    $score = $_SESSION['audio_score'];

    mysqli_query($con, "
        INSERT INTO quiz_results
        (quiz_id, email, category, total_questions, score, taken_on)
        VALUES
        ($quiz_id, '$email', '$category', $total, $score, NOW())
    ");

    unset($_SESSION['audio_questions']);
    unset($_SESSION['audio_index']);
    unset($_SESSION['audio_score']);

    echo json_encode([
        "finished" => true,
        "score" => $score,
        "total" => $total
    ]);
    exit;
}

/* CURRENT */
$q = $questions[$index];

echo json_encode([
    "finished" => false,
    "index" => $index + 1,
    "total" => $total,
    "question" => $q['question'],
    "options" => [
        $q['option1'],
        $q['option2'],
        $q['option3'],
        $q['option4']
    ],
    "answer" => $q['answer'],
    "hint" => $q['hint'],
    "audio" => $q['audio']   // ✅ correct column
]);
