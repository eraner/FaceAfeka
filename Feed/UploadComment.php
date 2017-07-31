<?php
require_once ('../DB/DatabaseHelper.php');
require_once ('../Utils/HtmlHelper.php');

if (!isset($_POST["loggedUser"]) ){
    echo "Failed";
    return;
}
$loggedUser = $_POST['loggedUser'];

if (isset($_POST['comment']) && isset($_POST['postID'])){
    $comment = $_POST['comment'];
    $postID = $_POST['postID'];

//    if ($comment == ""){
//        $_SESSION['error'] = "Oops you can\'t enter empty comment.";
//        header("Location: FeedPage.php");
//        return;
//    }

    $db = new DatabaseHelper();
    $result = $db->InsertNewComment($postID, $comment, $loggedUser);

    if ($result){
        $post = $db->GetPostByID($postID);
        $commentDetails = GetCommentSection($post);
        echo json_encode(
            array("post" => $commentDetails[0],
                "commentsHeader" => $commentDetails[1])
        );

    }else{
        echo "Failed";

    }
}
