<?php
require_once ('../DB/DatabaseHelper.php');

session_start();

if (!isset($_SESSION["loggedUser"]) ){
    header("HTTP/1.0 404 Not Found");
    die();
}
$loggedUser = $_SESSION['loggedUser'];


if (isset($_POST['comment']) && isset($_POST['postID'])){
    $comment = $_POST['comment'];
    $postID = $_POST['postID'];

    $db = new DatabaseHelper();
    $result = $db->InsertNewComment($postID, $comment, $loggedUser);

    if ($result){
        header("Location: FeedPage.php");
        return;
    }else{
        header("HTTP/1.0 404 Not Found");
        die();
    }
}

header("Location: FeedPage.php");
return;