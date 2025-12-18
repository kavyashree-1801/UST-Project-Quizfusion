<?php
session_start();
include '../config.php';
header('Content-Type: application/json');

if(!isset($_SESSION['forgot_email'])){
    echo json_encode(['success'=>false,'message'=>'Session expired']);
    exit;
}

$email = $_SESSION['forgot_email'];
$answer = $_POST['answer'] ?? '';

if(!$answer){
    echo json_encode(['success'=>false,'message'=>'Answer required']);
    exit;
}

$stmt = $con->prepare("SELECT password FROM users WHERE email=? AND security_answer=?");
$stmt->bind_param("ss",$email,$answer);
$stmt->execute();
$res = $stmt->get_result();

if($res->num_rows === 0){
    echo json_encode(['success'=>false,'message'=>'Incorrect answer']);
    exit;
}

$row = $res->fetch_assoc();
unset($_SESSION['forgot_email']); // clear session
echo json_encode(['success'=>true,'password'=>$row['password']]);
