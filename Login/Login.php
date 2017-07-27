<?php
require_once('..\DB\DatabaseHelper.php');

session_start();

if (isset($_POST["username"]) && isset($_POST["password"])){
    $db = new DatabaseHelper();
    $username = $_POST["username"];
    $result = $db->ValidateUser($_POST["username"], $_POST["password"]);

    if ($result){
        $_SESSION['loggedUser'] = $username;
        header("Location: ../Feed/FeedPage.php");
        return;
    } else {
        $_SESSION['error'] = "Oops, username or password is incorrect.";
        header("Location: ../index.php");
        return;
    }
}

header("HTTP/1.0 404 Not Found");
die();
