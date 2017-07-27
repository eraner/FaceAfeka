<?php
require_once ("..\Utils\HtmlHelper.php");
require_once ("..\DB\DatabaseHelper.php");
require_once ("..\Utils\ImgUploader.php");

$status = $_POST['status'];
$imgScr = $_FILES['pic'];

$privacy = $_POST['privacy'];
$username = $_POST['loggedUser'];

$imgs = UploadImgs($imgScr);
var_dump($imgScr, $status, $privacy, $username);
return;
$db = new DatabaseHelper();
$result = $db->InsertNewPost($status, $imgs, $username, $privacy);
if($result == true){
    echo true;
    return;
}

echo "Error to post the status";

