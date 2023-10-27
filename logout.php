<?php
session_start();
if (isset($_SESSION['id'])) {
    $_SESSION = array();

    session_destroy();
    header("Location: sign-in.php");
    exit();
} else {
    header("Location: login.php");
    exit();
}