<?php
require_once ("..\Utils\HtmlHelper.php");
require_once ("..\DB\DatabaseHelper.php");
require_once ("..\Utils\ImgUploader.php");


$status = $_POST['status'];
$imgScr = $_FILES['pic'];
$privacy = $_POST['privacy'];
$username = $_POST['loggedUser'];

$imgs = UploadImgs($imgScr);

$db = new DatabaseHelper();
$result = $db->InsertNewPost($status, $imgs[0], $username, $privacy);
if($result == true){
    header("Location: FeedPage.php");
    return;
}

echo "Error to post the status";

