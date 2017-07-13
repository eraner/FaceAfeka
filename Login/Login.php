<?php
require_once('..\DB\DatabaseHelper.php');

session_start();

if (isset($_POST["username"]) && isset($_POST["password"])){
    $db = new DatabaseHelper();
    $username = $_POST["username"];
    $result = $db->ValidateUser($_POST["username"], $_POST["password"]);

    if ($result){
        $_SESSION['loggedUser'] = $username;
        header("Location: ../Feed/friends.php");
        return;
    } else {
        echo "Not Cool At All!!!";
    }
}

header("HTTP/1.0 404 Not Found");
die();
