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
     echo "Picture uploaded successfully";
     return;
 }else{
     echo "Picture upload failed.";
     return;
 }
