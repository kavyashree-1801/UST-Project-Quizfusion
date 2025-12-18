<?php
session_start();
include '../config.php';
header('Content-Type: application/json');

$email = $_POST['email'] ?? '';

if(!$email){
    echo json_encode(['success'=>false,'message'=>'Email required']); exit;
}

$stmt = $con->prepare("SELECT id FROM users WHERE email=?");
$stmt->bind_param("s",$email);
$stmt->execute();
$res = $stmt->get_result();

if($res->num_rows === 0){
    echo json_encode(['success'=>false,'message'=>'Email not found']); exit;
}

// store email in session
$_SESSION['forgot_email'] = $email;
echo json_encode(['success'=>true]);
