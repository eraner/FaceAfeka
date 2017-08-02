<?php
require_once ("..\Utils\HtmlHelper.php");
require_once ("..\DB\DatabaseHelper.php");
require_once ("..\Utils\ImgUploader.php");

$status = $_POST['status'];
if (isset($_FILES['pic'])){
    $imgScr = $_FILES['pic'];
}else{
    $imgScr ="";
}

$privacy = $_POST['privacy'];
$username = $_POST['loggedUser'];

$imgs = UploadImgs($imgScr);
$db = new DatabaseHelper();
$result = $db->InsertNewPost($status, $imgs, $username, $privacy);
if(!$result){
    echo false;
    return;
}

$tempArr = array($username);
$friends = $db->GetUsersFriends($username);
$friends = array_merge($tempArr, $friends);
$postDetailsArr = $db->GetFriendsPosts($friends);

PrintStatusesListHTML($postDetailsArr, $username);
