<?php
require_once ('../DB/DatabaseHelper.php');

session_start();
if (!isset($_SESSION["loggedUser"]) ){
    header("HTTP/1.0 404 Not Found");
    die();
}
$loggedUser = $_SESSION['loggedUser'];

$db = new DatabaseHelper();
$tempArr = array($loggedUser);
$friends = $db->GetUsersFriends($loggedUser);
$friends = array_merge($tempArr, $friends);

$userToAdd = $_POST['search-box'];

if(in_array($userToAdd, $friends)){          //already in friends or self
    sendError("Already your friend or yourself..");
    return;
}
if($userToAdd == "") {                      //empty string
    sendError("Wrong Input!");
    return;
}
if($db->IsUsernameAvailable($userToAdd)){   //username not exists.
    sendError("User doesn't exist!");
    return;
}

function sendError($errorMsg){
    $errorMsg = addslashes($errorMsg);
    $_SESSION['error'] = $errorMsg;
    header("Location: FeedPage.php");
}

$result = $db->MakeFriends($loggedUser, $userToAdd);
if ($result) {
    header("Location: FeedPage.php");
    return;
} else {
    $_SESSION['error'] = "Something wen't wrong, the user couldn't register on the server DB.";
    header("Location: FeedPage.php");
}