<?php
require_once ("..\Utils\HtmlHelper.php");

$status = $_POST['status'];
$imgScr = $_POST['pic'];
$privacy = $_POST['privacy'];
$username = $_POST['loggedUser'];


PrintHeadHTML();

echo $status."</br>";
echo $imgScr."</br>";
echo $privacy."</br>";
echo $username."</br>";


echo "</html>";
