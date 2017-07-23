<?php
session_start();

if (!isset($_SESSION["loggedUser"]) ){
    header("HTTP/1.0 404 Not Found");
    die();
}
$loggedUser = $_SESSION['loggedUser'];


if (isset($_POST['comment'])){
    $comment = $_POST['comment'];

    echo "Comment ".$comment." by ".$loggedUser.".";
}