<?php

require_once ('../DB/DatabaseHelper.php');

if (!isset($_POST['PostId']) || !isset($_POST['Privacy'])){
    echo "Failed";
    return;
}

$postID = $_POST['PostId'];
$newPrivacy = $_POST['Privacy'];

$db = new DatabaseHelper();
$result = $db->UpdatePostPrivacy($postID, $newPrivacy);

if ($result){
    echo "Success";
}else{
    echo "Failed";
}