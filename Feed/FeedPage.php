<?php
require_once ("StatusDetails.php");
require_once ("..\utils\HtmlHelper.php");
require_once ("..\Utils\ImgUploader.php");

session_start();

if (!isset($_SESSION["loggedUser"]) ){
    header("HTTP/1.0 404 Not Found");
    die();
}
$loggedUser = $_SESSION['loggedUser'];

$db = new DatabaseHelper();
$friends = $db->GetUsersFriends($loggedUser);

$statusDetailsArr = $db->GetFriendsPosts($friends);

PrintHeadHTML();
echo "<body>";

AddTopNavigationBar($loggedUser);

echo "<div class='main' style='padding-top: 30px'>";
PrintStatusesListHTML($statusDetailsArr);
echo "</div>";

echo "</body>";
echo "</html>";

function PrintStatusesListHTML($statusDetailsArr){
    foreach ($statusDetailsArr as $statusDetails) {
        echo "<div>";
        /**Add user Name*/
        echo "$statusDetails->date";
        echo "<h2>".$statusDetails->publisher."</h2>";
        /**Add image if imgSrc isn't Blank*/
        if($statusDetails->imgSrc != "") {
            echo "<p><img src=\"".UPLOADED_IMAGES_LOCATION.$statusDetails->imgSrc."\"> <a href=\"#\">Picture here</a></p>";
        }
        /**Add status*/
        echo $statusDetails->status;
        echo "</div>";
        echo "<hr>";
    }
}

