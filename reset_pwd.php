<?php
session_start();
require_once 'config.php';

$error = array();
$resp = array();

if (empty($_POST['new_password'])) {
    $error['new_password'] = "New Password is required";
}

if (empty($_POST['confirm_new_password'])) {
    $error['confirm_new_password'] = "Confirm New Password is required";
}

// Trim the input values to remove white spaces
$new_password = trim($_POST['new_password']);
$confirm_new_password = trim($_POST['confirm_new_password']);

if ($new_password !== $confirm_new_password) {
    $error['confirm_new_password'] = "New Passwords do not match";
}

if (count($error) > 0) {
    $resp['msg'] = $error;
    $resp['status'] = false;
    echo json_encode($resp);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['id']; 

    $new_password = $_POST['new_password'];
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    $update_stmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :user_id");
    $update_stmt->bindParam(':password', $hashed_password);
    $update_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    if ($update_stmt->execute()) {
        // Password update was successful
        $resp['status'] = true;
        $resp['redirect'] = "sign-in.php";
        echo json_encode($resp);
    } else {
        $resp['status'] = false;
        $resp['msg']['update_error'] = "Error updating password.";
        echo json_encode($resp);
    }
}
?>
