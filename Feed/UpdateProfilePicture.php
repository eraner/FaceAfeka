<?php

require_once ('../Utils/ImgUploader.php');

session_start();

if (!isset($_SESSION["loggedUser"]) ){
    header("HTTP/1.0 404 Not Found");
    die();
}
$loggedUser = $_SESSION['loggedUser'];
$img = $_FILES['pic'];

$result = UpdateProfilePicture($loggedUser, $img);
 if ($result == true){
     header("Location: FeedPage.php");
     return;
 }else{
     $_SESSION['error'] = "Your Picture upload failed.";
     header("Location: FeedPage.php");
     return;
 }
