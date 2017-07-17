<?php
require_once('..\DB\DatabaseHelper.php');

if (isset($_POST["username"]) && isset($_POST["password"])
    && isset($_POST['rePassword'])){
    $db = new DatabaseHelper();
    $result = $db->RegisterUser($_POST["username"], $_POST["password"]);

    if ($result){
        header("Location: ..\\index.php");
        return;
    }else{
        echo "Something wen't wrong, the user couldn't register on the server DB.";
    }

}else{
    echo "username or pass not found";
}


header("HTTP/1.0 404 Not Found");
die();
