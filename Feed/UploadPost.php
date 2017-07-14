<?php
require_once ("..\Utils\HtmlHelper.php");
require_once ("..\DB\DatabaseHelper.php");

$status = $_POST['status'];
$imgScr = $_POST['pic'];
$privacy = $_POST['privacy'];
$username = $_POST['loggedUser'];

$db = new DatabaseHelper();
$result = $db->InsertNewPost($status, $imgScr, $username, $privacy);
if($result == true){
    header("Location: FeedPage.php");
    return;
}

echo "Error to post the status";

//PrintHeadHTML();
//
//
//
//echo $status."</br>";
//if($imgScr != "") {
//    echo $imgScr . "</br>";
//}
//echo $privacy."</br>";
//echo $username."</br>";
//
//
//echo "</html>";
