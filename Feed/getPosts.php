<?php
require_once ('..\Utils\HtmlHelper.php');

session_start();

$status = $_POST['status'];
$imgScr = $_FILES['pic'];
$privacy = $_POST['privacy'];
$username = $_POST['loggedUser'];

$imgs = UploadImgs($imgScr);

$db = new DatabaseHelper();
$result = $db->InsertNewPost($status, $imgs[0], $username, $privacy);

if (!isset($_SESSION["loggedUser"]) ){
    header("HTTP/1.0 404 Not Found");
    die();
}
$loggedUser = $_SESSION['loggedUser'];

$friends = $db->GetUsersFriends($loggedUser);
$friends[] = $loggedUser;
$statusDetailsArr = $db->GetFriendsPosts($friends);

PrintStatusesListHTML($friends);