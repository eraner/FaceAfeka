<?php
require_once('..\DB\DatabaseHelper.php');
require_once('ImgUploader.php');
require_once ('..\Feed\Comment.php');


function PrintHeadHTML(){
    echo "<!doctype html>
        <html lang=\"en\">
        <head>
            <meta charset=\"UTF-8\">
            <meta name=\"viewport\"
                content=\"width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0\">
            <meta http-equiv=\"X-UA-Compatible\" content=\"ie=edge\">
            <title>FaceAfeka</title>
            <link href=\"../CSS/css.css\" rel=\"stylesheet\" type='text/css'/>
            <link href=\"../CSS/postCss.css\" rel=\"stylesheet\" type='text/css'/>
            <link href=\"../CSS/SearchFriends.css\" rel=\"stylesheet\" type='text/css'/>
            <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\">
            <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js\"></script>
            <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js\"></script>
            <script src=\"../JS/FriendsBar.js\"></script>
            <script src=\"../JS/SetLike.js\"></script>
            <script src=\"../JS/PrivacyHandler.js\"></script>
            <script src=\"../JS/PostHandler.js\"></script>
            <script src=\"../JS/CommentHandler.js\"></script>
        </head>";
}

function AddTopNavigationBar($loggedUser){
    $userProfileImgSrc = GetUserProfileImgOrDefault($loggedUser);

    /** Navigation Bar Init*/
    echo "<div class='navbar'>
           <ul>
                <li><a class=\"active\" href='FeedPage.php'>FaceAfeka</a> </li>
                <li>
                    <button type='button' data-toggle='modal' data-target='#profileModal'> 
                        <span class=\"glyphicon glyphicon-user\"></span> Profile
                    </button> 
                </li>
                <li><a href='#' onclick='openNav()'> <span class=\"glyphicon glyphicon-link\"></span> Friends</a> </li>
                <li><button type='button' data-toggle='modal' data-target='#myPost'>
                    <span class=\"glyphicon glyphicon-plus-sign\"></span> Post</button>
                </li>
                <li>
                <form style='margin-top: 8px;' class='form-inline' method='post' action='AddFriend.php'>
                    <div class='input-group'>
                        <input class='form-control' type=\"text\" id=\"search-box\" name='search-box' placeholder=\"Look for Friends\" />
                        
                        <div class='input-group-btn'>
                            <button type=\"submit\" class=\"btn btn-default\"/>
                            <span class=\"glyphicon glyphicon-link\">Add</span>
                        </div>
                    </div>
                </form>
                <div id=\"suggesstion-box\"></div>
                        <script src='../JS/SearchFriends.js'></script>";
    if (isset($_SESSION['error'])){
        echo "<script>alert('".$_SESSION['error']."')</script>";
    }
    unset($_SESSION['error']);

    echo "</li>
                    <li><a class='avatar'>
                        Hi ".$loggedUser." <img class='avatar' src=\"$userProfileImgSrc\" 
                                    onclick=\"EnlargeImg('$userProfileImgSrc')\"> </a>
                    </li>
                    <li><a href='#' class='logout' onclick='document.location.href=\"../Login/Logout.php\"'>
                        <span class=\"glyphicon glyphicon-log-out\"></span>  Logout</a> 
                    </li>
                
           </ul>";
    echo "</div>"; /**navbar /div*/

    /**Setup Friends SideBar */
    echo "<div id=\"mySidenav\" class=\"sidenav\">
    <a href=\"#\" class=\"closebtn\" onclick=\"closeNav()\">&times;</a>";
    $db = new DatabaseHelper();
    $friends = $db->GetUsersFriends($loggedUser);
    foreach ($friends as $friend){
        echo "<a href=\"#\"><img class='friendImg' src=\"".GetUserProfileImgOrDefault($friend)."\">".$friend."</a>\n";
    }
    echo "</div>";

    /**Setup Post window popup*/
    echo "<div class='modal fade' id='myPost' role='dialog'>
            <div class='modal-dialog'>";
    /**Set Post window content*/
    echo "<div class=\"modal-style\">
    <form id='postForm' method='post' multipart=\"multiple\" enctype=\"multipart/form-data\">
        <input type='hidden' id='loggedUser' value='".$loggedUser."'/>
        <center><table>
            <tr><td><h1>Your Post</h1></td></tr>
            <tr>
                <td>
                <textarea id=\"status\" placeholder=\"Enter your status here\" rows=\"10\" cols=\"70\" required></textarea>
                </td>
            </tr>
            <tr>
                <td><input type=\"file\" id=\"pic[]\" multiple accept=\"image/*\"></td>
            </tr></br>
            <table>
                <tr>
                    <td>
                        <div class=\"input-group\" data-toggle=\"buttons\" >
                          <label class=\"btn\" id='publicID'>
                            <input type=\"radio\" name=\"privacy\" value='Public' required> Public
                          </label>
                          <label class=\"btn\" id='privateID'>
                            <input type=\"radio\" name=\"privacy\" value='Private' required> Private
                          </label>
                        </div>
                    </td>
                </tr>
            </table>
            <tr></br>
                <td><input onclick='UploadPost()' type=\"submit\" value=\"Post Now!\"></td>
            </tr>
        </table>
        </center>
    </form>
    </div>";
    echo "</div>"; /**modal fade /div*/
    echo "</div>"; /**post-style /div*/

    /** Setup Profile window popup */
    echo "<div class='modal fade' id='profileModal' role='dialog'>
            <div class='modal-dialog'>";
    echo "<div class=\"modal-style\">
    <form action=\"UpdateProfilePicture.php\" method='post' multipart=\"multiple\" enctype=\"multipart/form-data\">
        <input type='hidden' name='loggedUser' value='".$loggedUser."'/>
        <center><table>
            <tr><td><h1>".$loggedUser." Profile</h1></td></tr>
            <tr>
                <td>
                <img class='profileImg' name=\"currentImg\" src='".$userProfileImgSrc."' />
                </td>
            </tr>
            <tr>
                <td><input type=\"file\" name=\"pic\" placeholder='Change picture?' accept=\"image/*\"></td>
            </tr></br>
            <tr></br>
                <td><input type=\"submit\" value=\"Update Picture\"></td>
            </tr>
        </table>
        </center>
    </form>
    </div>";
    echo "</div>";
    echo "</div>";
    echo "<script>
    $('#postForm').on('submit', function(e) {
      e.preventDefault();
    })
</script>";

}

function printSinglePost(PostDetails $post, $loggedUser){
    /** Post images setup. */
    $imgs = explode(',', $post->imgSrc);
    $imgs_print = "";
    foreach ($imgs as $img_src){
        if ($img_src != ""){
            $actualSrc = UPLOADED_IMAGES_LOCATION.$img_src."";
            $imgs_print .= "<img class='thumb' onclick='EnlargeImg(\"$actualSrc\")' src=\"" . UPLOADED_THUMBS_LOCATION . $img_src . "\" alt=\"photo\">";
        }
    }
    if ($imgs_print != ""){ //there is images in the post
        $imgs_print = "<hr />".$imgs_print;
    }

    /** Post user profile image setup. */
    $userProfileSrc = GetUserProfileImgOrDefault($post->publisher);

    /** Comments setup */
    $arr = GetCommentSection($post);
    $comments_print = $arr[0];
    $comment_header = $arr[1];


    /** Setup privacy change option */
    $privacyLayout = "";
    if ($loggedUser == $post->publisher){
        if ($post->privacy == "Private"){
            $privateBtn = "active";
            $privateChecked = "checked";
            $publicBtn = "";
            $publicChecked = "";
        }else{
            $privateBtn = "";
            $privateChecked = "";
            $publicBtn = "active";
            $publicChecked = "checked";
        }
        $privacyLayout = <<<EOT
                        <div class="postLayout-right">
                            <div class="input-group" data-toggle="buttons" >
                                  <label class="btn btn-primary btn-sm $privateBtn" id='Privatelbl_$post->postID'  style="width: 70px">
                                    <input type="radio" name="options" onchange="ChangePrivacy($post->postID, 'Private')" 
                                        id="PrivateRadio_$post->postID" autocomplete="off" $privateChecked> Private
                                  </label>
                                  <label class="btn btn-primary btn-sm $publicBtn" id='Publiclbl_$post->postID' style="width: 70px">
                                    <input type="radio" name="options" onchange="ChangePrivacy($post->postID, 'Public')" 
                                        id="PublicRadio_$post->postID" autocomplete="off" $publicChecked> Public
                                  </label>
                            </div>
                        </div>
EOT;

    }

    $postStr = <<<EOT
<div class="timeline row" data-toggle="isotope">

    <div class="col-xs-12 col-md-80 col-lg-4 item">
        <div class="timeline-block">
            <div class="panel panel-default">

                <div class="panel-heading" style="background-color: #4CAF50">
                    <div class="postLayout">

                        <div class="postLayout-left">
                                <img src="$userProfileSrc" onclick="EnlargeImg('$userProfileSrc')" class="postLayout-object"/>
                        </div>
                        <div class="postLayout-header-body">
                            <div class="postLayout-heading"><a class="user">$post->publisher</a></div>
                            <div class="postLayout-bottom"><div class="header-date">on $post->date</div></div>
                        </div>
                        $privacyLayout
                    </div>
                </div>

                <div class="panel-body">
                    $post->status
    <div class="timeline-added-images">
                        $imgs_print

                    </div>
                </div>
                <div class="comments-header">
                    <button onclick="SendLikesAjax($post->postID)" id='LikeBtn' type="submit" class="btn btn-primary" style="position:relative; margin:5px">
                        <span class="glyphicon glyphicon-thumbs-up"></span> <span id="like$post->postID">Like</span>
                        <span class="badge" id="numOfLikes$post->postID">$post->likes</span>
                        <input type="hidden" name="postID" value="$post->postID">
                    </button>
                    <div id="comment-header_$post->postID">
                        $comment_header
                    </div>
                </div>
                <ul class="comments">
                    <div id="CommentsSection_$post->postID">
                        $comments_print
                    </div>
                    <li class="comment-form">
                        <div class="input-group">
                            <input type="text" id="comment_$post->postID" class="form-control" />
                             
                            <span class="input-group-btn">
                                <button onclick="UploadComment($post->postID)" class="btn btn-default">
                                <span class="glyphicon glyphicon-comment"></span>
                            </span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
EOT;

    echo $postStr;
}

function PrintStatusesListHTML($postDetailsArr, $loggedUser){

    foreach ($postDetailsArr as $postDetails) {
        printSinglePost($postDetails, $loggedUser);
    }
}

function PrintThumbModalScript(){
    echo "<div id=\"myModal\" class=\"modal\">
                      <span class=\"close\">X</span>
                      <img class=\"modal-content\" id=\"img01\">
                    </div>
                    <script src=\"../JS/ThumbModal.js\"></script>";
}

function GetCommentSection($post){
    /** Comments setup */
    $comments_count = count($post->commentArray);
    if ($comments_count > 0){
        $comment_header = "<a class='userComment'><span class=\"glyphicon glyphicon-comment\"> </span>  ".$comments_count." comments </a>";
    }else{
        $comment_header = "<p><span class=\"glyphicon glyphicon-comment\"> </span> Be the first to comment</p>";
    }
    $comments_print = "";
    foreach ($post->commentArray as  $comment) {
        $userImgSrc = GetUserProfileImgOrDefault($comment->username);
        $temp = <<<EOT
        <li class="postLayout">
                        <div class="postLayout-left">
                                <img src="$userImgSrc" class="commenter-img">
                        </div>
                        <div class="postLayout-body">
                            <a class="author">$comment->username</a>
                            <span>$comment->comment</span>
                            <div class="date">$comment->date</div>
                        </div>
                    </li>
EOT;
        $comments_print .= $temp;
    }
    return array($comments_print, $comment_header);
}

