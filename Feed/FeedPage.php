<?php
include ("StatusDetails.php");
require_once ("..\utils\HtmlHelper.php");
//$statusDetailsArr = $_POST['allStatuses'];
$statusDetailsArr = [new StatusDetails("blala", "dog.jpg", "Eran"),
                        new StatusDetails("lala", "", "Ohad"),
                        new StatusDetails("blala", "dog.jpg", "Eran"),
                        new StatusDetails("lala", "", "nir"),
new StatusDetails("blala", "dog.jpg", "Eran"),
                        new StatusDetails("lala", "", "omri"),
new StatusDetails("blala", "dog.jpg", "Eran"),
                        new StatusDetails("lala", "", "marlen")];
/*$status = $_POST['status'];
$imgSrc = $_POST['imgsrc'];
$name = $_POST['name'];
$statusDetails = new StatusDetails($status, $imgSrc, $name);*/

PrintHeadHTML();
echo "<body>";

AddTopNavigationBar();

echo "<div style='padding-top: 30px'>";
PrintStatusesListHTML($statusDetailsArr);
echo "</div>";
echo "</body>
        </html>";

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

