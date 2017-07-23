<?php
require_once('..\DB\DatabaseHelper.php');
require_once('ImgUploader.php');


function PrintHeadHTML(){
    echo "<!doctype html>
        <html lang=\"en\">
        <head>
            <meta charset=\"UTF-8\">
            <meta name=\"viewport\"
                content=\"width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0\">
            <meta http-equiv=\"X-UA-Compatible\" content=\"ie=edge\">
            <title>Document</title>
            <link href=\"../CSS/css.css\" rel=\"stylesheet\" type='text/css'/>
            <link href=\"../CSS/postCss.css\" rel=\"stylesheet\" type='text/css'/>
            <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\">
            <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js\"></script>
            <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js\"></script>
            <script src=\"../JS/FriendsBar.js\"></script>
        </head>";
}

function AddTopNavigationBar($loggedUser){
    /** Navigation Bar Init*/
    echo "<div class='navbar'>
           <ul>
                <li><a class=\"active\" href='#'>FaceAfeka</a> </li>
                <li><a href='#'> <span class=\"glyphicon glyphicon-user\"></span> Profile</a> </li>
                <li><a href='#' onclick='openNav()'> <span class=\"glyphicon glyphicon-link\"></span> Friends</a> </li>
                <li><button type='button' data-toggle='modal' data-target='#myPost'>
                    <span class=\"glyphicon glyphicon-plus-sign\"></span> Post</button>
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
        echo "<a href=\"#\"><img class='friendImg' src=\"../Resources/Images/profile-icon.png\">".$friend."</a>\n";
    }
    echo "</div>";

    /**Setup Post window popup*/
    echo "<div class='modal fade' id='myPost' role='dialog'>
            <div class='modal-dialog'>";
    /**Set Post window content*/
    echo "<div class=\"post-style\">
    <form action=\"UploadPost.php\" method='post' multipart=\"multiple\" enctype=\"multipart/form-data\">
        <input type='hidden' name='loggedUser' value='".$loggedUser."'/>
        <center><table>
            <tr><td><h1>Your Post</h1></td></tr>
            <tr>
                <td>
                <textarea name=\"status\" placeholder=\"Enter your status here\" rows=\"10\" cols=\"70\" required></textarea>
                </td>
            </tr>
            <!--TODO:Multiple pictures -->
            <tr>
                <td><input type=\"file\" name=\"pic[]\" multiple accept=\"image/*\"></td>
            </tr></br>
            <table>
                <tr>
                    <td><input type=\"radio\" name=\"privacy\" value=\"Public\" required>Public </br>
                    <input type=\"radio\" name=\"privacy\" value=\"Private\">Private</td> 
                </tr>
            </table>
            <tr></br>
                <td><input type=\"submit\" value=\"Post Now!\"></td>
            </tr>
        </table>
        </center>
    </form>
    </div>";
    echo "</div>"; /**modal fade /div*/
    echo "</div>"; /**post-style /div*/
}

function printSinglePost(PostDetails $post){
    #echo date_format($date, 'g:ia \o\n l jS F Y');
    #output: 5:45pm on Saturday 24th March 2012

    #$tempDate = strtotime($post->date);
    #$tempDate = date('d/M/Y H:i:s', $tempDate);
    #$formattedDate = date_format($tempDate, 'jS F Y \@ g:ia');

    $imgs = explode(',', $post->imgSrc);
    $imgs_print = "";
    foreach ($imgs as $img_src){
        if ($img_src != ""){
            $actualSrc = UPLOADED_IMAGES_LOCATION.$img_src."";
            $imgs_print .= "<img onclick='EnlargeImg(\"$actualSrc\")' src=\"" . UPLOADED_THUMBS_LOCATION . $img_src . "\" alt=\"photo\">";
        }
    }

    $postStr = <<<EOT
<div class="timeline row" data-toggle="isotope">

    <div class="col-xs-12 col-md-80 col-lg-4 item">
        <div class="timeline-block">
            <div class="panel panel-default">

                <div class="panel-heading" style="background-color: #4CAF50">
                    <div class="postLayout">

                        <div class="postLayout-left">
                            <a href="">
                                <img src="../Resources/UploadedImgs/man.png" class="postLayout-object">
                            </a>
                        </div>
                        <div class="postLayout-header-body">
                            <div class="postLayout-heading"><a class="user">$post->publisher</a></div>
                            <div class="postLayout-bottom"><div class="header-date">on $post->date</div></div>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    $post->status
    <div class="timeline-added-images">
                        $imgs_print

                    </div>
                </div>
                <div class="comments-header">
                    <button type="button" class="btn btn-primary"  style="position:relative; margin:5px">
                        <span class="glyphicon glyphicon-thumbs-up"></span> Likes
                        <span class="badge">$post->likes</span>
                    </button>
                    <p><span class="glyphicon glyphicon-comment"> </span> Be the first to comment</p>

                </div>
                <ul class="comments">
                    <li class="postLayout">
                        <div class="postLayout-left">
                            <a href="">
                                <img src="../Resources/UploadedImgs/woman.png" class="commenter-img">
                            </a>
                        </div>
                        <div class="postLayout-body">
                            <a href="" class="author">Mary</a>
                            <span>Wow</span>
                            <div class="date">2 days</div>
                        </div>
                    </li>
                    <li class="postLayout">
                        <div class="postLayout-left">
                            <a href="">
                                <img src="../Resources/UploadedImgs/man.png" class="commenter-img">
                            </a>
                        </div>
                        <div class="postLayout-body">
                            <a href="" class="author">John</a>
                            <span>Yes I Know</span>
                            <div class="date">1 days</div>
                        </div>
                    </li>
                    <li class="postLayout">
                        <div class="postLayout-left">
                            <a href="">
                                <img src="../Resources/UploadedImgs/201707181724441840804854.png" class="commenter-img">
                            </a>
                        </div>
                        <div class="postLayout-body">
                            <a href="" class="author">Cat</a>
                            <span>:-)</span>
                            <div class="date">now</div>
                        </div>
                    </li>
                    <li class="comment-form">
                        <div class="input-group">

                            <input type="text" class="form-control" />

                            <span class="input-group-btn">
                                <a href="" class="btn btn-default"><span class="glyphicon glyphicon-comment"> </span></a>
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