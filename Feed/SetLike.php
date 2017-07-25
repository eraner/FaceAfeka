<?php
require_once ('../DB/DatabaseHelper.php');

$postID = $_POST['postID'];



$script = <<<EOT
<script>
    var likeID = "like$postID";
    var numOfLikesID = "numOfLikes$postID";
    "<?php SetTheLikes(document.getElementById(likeID).innerHTML, document.getElementById(numOfLikesID).innerHTML) ?>";
</script>
EOT;
echo $script;

function SetTheLikes($likeUnlike, $numOfLikes, $postID){
    $db = new DatabaseHelper();
    if ($likeUnlike == "Like") {
        $db->SetLikes($postID, $numOfLikes + 1);
    } else {
        $db->SetLikes($postID, $numOfLikes - 1);
    }
    header("Location: FeedPage.php");
    return;
}