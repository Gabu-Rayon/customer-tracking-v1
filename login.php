<?php
require_once 'config.php';
require 'vendor/autoload.php';


use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$logger = new Logger('login_attempts');
$logger->pushHandler(new StreamHandler('log-files/login_attempts.log', Level::Warning));

require_once 'config.php';

$error = array();
$res = array();

if (empty($_POST['email'])) {
    $error['email'] = "Email field is required";
}

if (empty($_POST['password'])) {
    $error['password'] = "Password field is required";
}
if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $error['email'] = "Enter Valid Email address";
}

if (count($error) > 0) {
    $resp['msg'] = $error;
    $resp['status'] = false;
    echo json_encode($resp);
    exit;
}

$statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
$statement->execute(array(':email' => $_POST['email']));
$row = $statement->fetchAll(PDO::FETCH_ASSOC);
if (count($row) > 0) {
    if (!password_verify($_POST['password'], $row[0]['password'])) {
        $error['password'] = "Password is not valid";
        $resp['msg'] = $error;
        $resp['status'] = false;
        echo json_encode($resp);
        exit;
    }
    session_start();
    $_SESSION['id'] = $row[0]['id'];
    $_SESSION['id'] = $row[0]['id'];
    $_SESSION['username'] = $row[0]['username'];
    $_SESSION['email'] = $_POST['email'];

    // Log the successful login attempt
    $logger->info('Successful login attempt for user: ' . $_POST['email']);


    $resp['redirect'] = "index.php";
    $resp['status'] = true;
    echo json_encode($resp);
    exit;
} else {
    $error['email'] = "Email does not match";
    $resp['msg'] = $error;
    $resp['status'] = false;

    // Log the failed login attempt
    $logger->warning('Failed login attempt for user: ' . $_POST['email']);
    echo json_encode($resp);
    exit;
}
