<?php
require_once ("..\Utils\HtmlHelper.php");
require_once ("..\Utils\ImgUploader.php");

$status = $_POST['status'];
$imgScr = $_FILES['pic'];
$privacy = $_POST['privacy'];
$username = $_POST['loggedUser'];


PrintHeadHTML();
$imgs = UploadImgs($imgScr);


echo $status."</br>";
echo $privacy."</br>";
var_dump($imgs);
echo $username."</br>";


echo "</html>";
