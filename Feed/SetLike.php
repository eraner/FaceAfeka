<?php
require_once ('../DB/DatabaseHelper.php');

if(!isset($_POST['postID']) ||
    !isset($_POST['likeUnlike'])){
    echo -1;
    return;
}

$postID = $_POST['postID'];
$likeUnlike = $_POST['likeUnlike'];

$db = new DatabaseHelper();

$numOfLikes = $db->GetLikes($postID);

if ($likeUnlike == "Like") {
    $result = $db->SetLikes($postID, $numOfLikes + 1);
} else {
    $result = $db->SetLikes($postID, $numOfLikes - 1);
}

echo $result;






