<?php
session_start();
include '../config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success'=>false, 'message'=>'Not logged in']);
    exit;
}

$user_id = intval($_SESSION['user_id']);

$name = isset($_POST['name']) ? trim($_POST['name']) : null;
$email = isset($_POST['email']) ? trim($_POST['email']) : null;
$old_pass = isset($_POST['old_password']) ? trim($_POST['old_password']) : null;
$new_pass = isset($_POST['new_password']) ? trim($_POST['new_password']) : null;

// Update profile info
if ($name !== null && $email !== null) {
    if ($name === '' || $email === '') {
        echo json_encode(['success'=>false,'message'=>'Name and email cannot be empty']);
        exit;
    }

    // Check duplicate email
    $stmt = $con->prepare("SELECT id FROM users WHERE email=? AND id!=?");
    $stmt->bind_param("si",$email,$user_id);
    $stmt->execute();
    if($stmt->get_result()->num_rows > 0){
        echo json_encode(['success'=>false,'message'=>'Email already in use']);
        exit;
    }

    $stmt = $con->prepare("UPDATE users SET name=?, email=? WHERE id=?");
    $stmt->bind_param("ssi",$name,$email,$user_id);
    if(!$stmt->execute()){
        echo json_encode(['success'=>false,'message'=>'Profile update failed']);
        exit;
    }
}

// Update password
if ($old_pass !== null && $new_pass !== null) {
    if ($old_pass === '' || $new_pass === '') {
        echo json_encode(['success'=>false,'message'=>'Please fill both old and new password']);
        exit;
    }

    $stmt = $con->prepare("SELECT password FROM users WHERE id=?");
    $stmt->bind_param("i",$user_id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if(!password_verify($old_pass, $user['password'])){
        echo json_encode(['success'=>false,'message'=>'Old password is incorrect']);
        exit;
    }

    $new_hash = password_hash($new_pass, PASSWORD_DEFAULT);
    $stmt = $con->prepare("UPDATE users SET password=? WHERE id=?");
    $stmt->bind_param("si",$new_hash,$user_id);
    if(!$stmt->execute()){
        echo json_encode(['success'=>false,'message'=>'Password update failed']);
        exit;
    }
}

echo json_encode(['success'=>true,'message'=>'Update successful']);
?>
