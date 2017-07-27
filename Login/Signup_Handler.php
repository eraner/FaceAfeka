<?php
require_once('..\DB\DatabaseHelper.php');

session_start();

if (isset($_POST["username"]) && isset($_POST["password"])
    && isset($_POST['rePassword'])){

    if($_POST["password"] != $_POST["rePassword"]){
        $_SESSION['error'] = "Passwords don't match";
        header("Location: Signup.php");
        return;
    }else{
        $db = new DatabaseHelper();
        if(!$db->IsUsernameAvailable($_POST['username'])){
            $_SESSION['error'] = "Username is not available";
            header("Location: Signup.php");
            return;
        }

        $result = $db->RegisterUser($_POST["username"], $_POST["password"]);

        if ($result) {
            header("Location: ..\\index.php");
            return;
        } else {
            $_SESSION['error'] = "Something went wrong, the user couldn't register on the server DB.";
            header("Location: Signup.php");
        }
    }

}else{
    $_SESSION['error'] = "Fields are empty!";
    header("Location: Signup.php");
    return;
}

