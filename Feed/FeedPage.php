<?php
include ("StatusDetails.php");
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
PrintStatusesListHTML($statusDetailsArr);
echo "</body>
        </html>";

function AddTopNavigationBar(){
    echo "<ul>
            <li><a class=\"active\" href='#'>FaceAfeka</a> </li>
            <li><a href='#'>Friends</a> </li>
            <li><a href='#'>Profile</a> </li>
           </ul>";
}

function PrintHeadHTML(){
    echo "<!doctype html>
        <html lang=\"en\">
        <head>
            <meta charset=\"UTF-8\">
            <meta name=\"viewport\"
                content=\"width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0\">
            <meta http-equiv=\"X-UA-Compatible\" content=\"ie=edge\">
            <title>Document</title>
            <link href=\"../CSS/css.css\" rel=\"stylesheet\" type='text/css'>
        </head>";
}

function PrintStatusesListHTML($statusDetailsArr){
    foreach ($statusDetailsArr as $statusDetails) {
        /**Start div for status panel.*/
        echo "<div class=\"panel panel-default\">";
        /**Add user Name.*/
        echo "<h2>".$statusDetails->name."</h2>";
        echo "<div class=\"panel-body\">";
        /**Add image if imgSrc isn't Blank*/
        if($statusDetails->imgSrc != ""){
            echo "<p><img src=\"".$statusDetails->imgSrc."\" class=\"img-circle pull-right\"> <a href=\"#\">Picture here</a></p>";
        }
        echo "<div class=\"clearfix\"></div>
            <hr>";
        /**Add status*/
        echo $statusDetails->status;
        echo "</div>";
    }
}
/*
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="panel panel-default">
        <div class="panel-heading">
            <a href="#" class="pull-right">View all</a>
            <h4>Bootply Editor &amp; Code Library</h4>
        </div>
        <div class="panel-body">
            <p><img src="//placehold.it/150x150" class="img-circle pull-right"> <a href="#">Picture here</a></p>
            <div class="clearfix"></div>
            <hr>
            HERE is the STATUS from user.
        </div>
    </div>
</body>
</html>
*/
