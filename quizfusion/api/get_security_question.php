<?php
session_start();
include '../config.php';
header('Content-Type: application/json');

if(!isset($_SESSION['forgot_email'])){
    echo json_encode(['success'=>false,'message'=>'Session expired']);
    exit;
}

$email = $_SESSION['forgot_email'];

$stmt = $con->prepare("SELECT security_question FROM users WHERE email=?");
$stmt->bind_param("s",$email);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();

echo json_encode(['success'=>true,'question'=>$row['security_question']]);
