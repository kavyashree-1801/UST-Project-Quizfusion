<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/quizfusion/config.php';
header("Content-Type: application/json");

// ---------- AUTH ----------
if(!isset($_SESSION['user_id'])){
    echo json_encode(["error"=>"USER_NOT_LOGGED_IN"]);
    exit;
}

$user_id = $_SESSION['user_id'];

// ---------- GET USER EMAIL ----------
$userQ = mysqli_query($con,"SELECT email FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($userQ);
$email = $user['email'] ?? null;
if(!$email){
    echo json_encode(["error"=>"USER_NOT_FOUND"]);
    exit;
}

// ---------- QUIZ ----------
$category = "Technical";
$quizQ = mysqli_query($con,"SELECT id FROM quizzes WHERE category='$category' LIMIT 1");
$quiz = mysqli_fetch_assoc($quizQ);
if(!$quiz){
    echo json_encode(["error"=>"QUIZ_NOT_FOUND"]);
    exit;
}
$quiz_id = $quiz['id'];

// ---------- INIT QUESTIONS ----------
if(!isset($_SESSION['tech_questions'])){
    $q = mysqli_query($con,"SELECT question, option1, option2, option3, option4, answer, hint FROM questions WHERE quiz_id='$quiz_id'");
    $questions = mysqli_fetch_all($q, MYSQLI_ASSOC);
    if(count($questions)===0){
        echo json_encode(["error"=>"NO_QUESTIONS"]);
        exit;
    }
    shuffle($questions);
    $_SESSION['tech_questions'] = $questions;
    $_SESSION['tech_index'] = 0;
    $_SESSION['tech_score'] = 0;
}

$questions = $_SESSION['tech_questions'];
$index = $_SESSION['tech_index'];
$total = count($questions);

// ---------- CHECK ANSWER ----------
if(isset($_POST['answer'])){
    if($_POST['answer'] === $questions[$index]['answer']){
        $_SESSION['tech_score']++;
    }
}

// ---------- NEXT QUESTION ----------
if(isset($_POST['next'])){
    $_SESSION['tech_index']++;
    if($_SESSION['tech_index'] >= $total){
        $score = $_SESSION['tech_score'];
        mysqli_query($con,"
            INSERT INTO quiz_results (quiz_id,email,category,total_questions,score,taken_on)
            VALUES ('$quiz_id','$email','$category','$total','$score',NOW())
        ");
        unset($_SESSION['tech_questions']);
        unset($_SESSION['tech_index']);
        unset($_SESSION['tech_score']);
        echo json_encode(["finished"=>true,"score"=>$score,"total"=>$total]);
        exit;
    }
}

// ---------- RESTART QUIZ ----------
if(isset($_POST['restart'])){
    unset($_SESSION['tech_questions']);
    unset($_SESSION['tech_index']);
    unset($_SESSION['tech_score']);
    echo json_encode(["restarted"=>true]);
    exit;
}

// ---------- SEND QUESTION ----------
$current = $questions[$_SESSION['tech_index']];
echo json_encode([
    "finished"=>false,
    "question"=>$current['question'],
    "options"=>[$current['option1'],$current['option2'],$current['option3'],$current['option4']],
    "answer"=>$current['answer'],
    "hint"=>$current['hint'] ?? "No hint available",
    "index"=>$index+1,
    "total"=>$total
]);
