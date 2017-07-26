<?php
require_once ('../DB/DatabaseHelper.php');

if(!isset($_POST['postID']) ||
    !isset($_POST['likeUnlike'])||
    !isset($_POST['numOfLikes'])){
    echo -1;
    return;
}

$postID = $_POST['postID'];
$likeUnlike = $_POST['likeUnlike'];
$numOfLikes = $_POST['numOfLikes'];

$db = new DatabaseHelper();
if ($likeUnlike == "Like") {
    $result = $db->SetLikes($postID, $numOfLikes + 1);
} else {
    $result = $db->SetLikes($postID, $numOfLikes - 1);
}

echo $result;






