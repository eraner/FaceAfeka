<?php
require_once('..\DB\DatabaseHelper.php');

if (isset($_POST["username"]) && isset($_POST["password"])){
    $db = new DatabaseHelper();
    $result = $db->ValidateUser($_POST["username"], $_POST["password"]);

    if ($result){
        header("Location: ../Feed/FeedPage.php");
        return;
    } else {
        echo "Not Cool At All!!!";
    }
}

header("HTTP/1.0 404 Not Found");
die();
