<?php
require_once ("StatusDetails.php");
require_once ("..\utils\HtmlHelper.php");

$statusDetailsArr = [new StatusDetails("blala", "dog.jpg", "Eran"),
                        new StatusDetails("lala", "", "Ohad"),
                        new StatusDetails("blala", "dog.jpg", "Eran"),
                        new StatusDetails("lala", "", "nir"),
                        new StatusDetails("blala", "dog.jpg", "Eran"),
                        new StatusDetails("lala", "", "omri"),
                        new StatusDetails("blala", "dog.jpg", "Eran"),
                        new StatusDetails("lala", "", "marlen")];
session_start();

if (!isset($_SESSION["loggedUser"]) ){
    header("HTTP/1.0 404 Not Found");
    die();
}
$loggedUser = $_SESSION['loggedUser'];

/*$statusDetailsArr = $_POST['allStatuses'];
$status = $_POST['status'];
$imgSrc = $_POST['imgsrc'];
$name = $_POST['name'];
$statusDetails = new StatusDetails($status, $imgSrc, $name);*/

PrintHeadHTML();
echo "<body>";

AddTopNavigationBar($loggedUser);

echo "<div style='padding-top: 30px'>";
PrintStatusesListHTML($statusDetailsArr);
echo "</div>";

echo "</body>";
echo "</html>";

function PrintStatusesListHTML($statusDetailsArr){
    foreach ($statusDetailsArr as $statusDetails) {
        echo "<div>";
        /**Add user Name*/
        echo "<h2>".$statusDetails->name."</h2>";
        /**Add image if imgSrc isn't Blank*/
        if($statusDetails->imgSrc != ""){
            echo "<p><img src=\"".$statusDetails->imgSrc."\"> <a href=\"#\">Picture here</a></p>";
        }
        echo "<hr>";
        /**Add status*/
        echo $statusDetails->status;
        echo "</div>";
    }
}

