<?php
require_once("PostDetails.php");
require_once ("..\utils\HtmlHelper.php");
require_once ("..\Utils\ImgUploader.php");

session_start();

if (!isset($_SESSION["loggedUser"]) ){
    header("HTTP/1.0 404 Not Found");
    die();
}
$loggedUser = $_SESSION['loggedUser'];

$db = new DatabaseHelper();
$tempArr = array($loggedUser);
$friends = $db->GetUsersFriends($loggedUser);
$friends = array_merge($tempArr, $friends);
$postDetailsArr = $db->GetFriendsPosts($friends);
if ($postDetailsArr == -1){
    header("HTTP/1.0 404 Not Found");
    die();
}

PrintHeadHTML();
echo "<body>";

//PrintScript();

AddTopNavigationBar($loggedUser);

echo "<div class='main' id='feed'>";
PrintStatusesListHTML($postDetailsArr);
echo "</div>";

echo "</body>";
echo "</html>";

function PrintStatusesListHTML($postDetailsArr){

    foreach ($postDetailsArr as $postDetails) {
        printSinglePost($postDetails);
    }
    PrintThumbModalScript();
}

function PrintThumbModalScript(){
    echo "<div id=\"myModal\" class=\"modal\">
                      <span class=\"close\">X</span>
                      <img class=\"modal-content\" id=\"img01\">
                      <div id=\"caption\"></div>
                    </div>
                    <script src=\"../JS/ThumbModal.js\"></script>";
}

//function PrintScript(){
//    echo "<script>
//                var cacheData;
//                var data = $('#main').html();
//                $('#submitPost').click(function() {
//                    alert('works');
//                  $.ajax({
//                    url: 'getPosts.php',
//                    method: 'POST',
//                    data: data,
//                    dataType: 'html',
//                    success: function(data) {
//                      if(data !== cacheData){
//                          cacheData = data;
//                          var result = $('<div />').append(data).find('#main').html();
//                          $('#main').html(result);
//                      }
//                    }
//                  });
//                });
//            </script>";
//}

