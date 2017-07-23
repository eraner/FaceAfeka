<?php
require_once ("StatusDetails.php");
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
$statusDetailsArr = $db->GetFriendsPosts($friends);
if ($statusDetailsArr == -1){
    header("HTTP/1.0 404 Not Found");
    die();
}

PrintHeadHTML();
echo "<body>";

//PrintScript();

AddTopNavigationBar($loggedUser);

echo "<div class='main' id='feed' style='padding-top: 30px'>";
PrintStatusesListHTML($statusDetailsArr);
echo "</div>";

echo "</body>";
echo "</html>";

function PrintStatusesListHTML($statusDetailsArr){
    $imgNames = array();
    $counter = 0;
    foreach ($statusDetailsArr as $statusDetails) {
        echo "<div>";
        /**Add user Name*/
        echo "$statusDetails->date";
        echo "<h2>" . $statusDetails->publisher . "</h2>";
        /**Add image if imgSrc isn't Blank*/
        if ($statusDetails->imgSrc != "") {
            $actualSrc = UPLOADED_IMAGES_LOCATION.$statusDetails->imgSrc."";
            echo "<div class='myImage'>";
            echo "<img onclick='EnlargeImg(\"$actualSrc\")' id='myImg$counter' src=\"".UPLOADED_THUMBS_LOCATION.$statusDetails->imgSrc."\">";
            $imgNames = 'myImage'.$counter;
            $counter++;
            echo "</div>";
        }
        /**Add status*/
        echo $statusDetails->status;
        echo "</div>";
        echo "<hr>";
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

