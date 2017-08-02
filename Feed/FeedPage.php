<?php
require_once("PostDetails.php");
require_once ("..\utils\HtmlHelper.php");
require_once ("..\Utils\ImgUploader.php");

session_start();

if (!isset($_SESSION["loggedUser"]) ){
    header("Location: ..\\index.php");
    return;
}
$loggedUser = $_SESSION['loggedUser'];

$db = new DatabaseHelper();

/**setting friends array with logged user in first position*/
$tempArr = array($loggedUser);
$friends = $db->GetUsersFriends($loggedUser);
$friends = array_merge($tempArr, $friends);
$postDetailsArr = $db->GetFriendsPosts($friends);
if ($postDetailsArr == -1){
    header("HTTP/1.0 404 Not Found");
    die();
}

PrintHeadHTML();
echo "<body>";

AddTopNavigationBar($loggedUser);

echo "<div class='main' id='feed'>";
echo "<div id='posts'>";
PrintStatusesListHTML($postDetailsArr, $loggedUser);
echo "</div>";
echo "</div>";
PrintThumbModalScript();
echo "</body>";
echo "</html>";



