<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="../CSS/postCss.css" rel="stylesheet" type='text/css'/>
    <link href="../CSS/css.css" rel="stylesheet" type='text/css'/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="../JS/FriendsBar.js"></script>
    <title>Title</title>
</head>
<body>

<!--<div class="timeline row" data-toggle="isotope">-->

    <!--<div class="col-xs-12 col-md-80 col-lg-4 item">-->
        <!--<div class="timeline-block">-->
            <!--<div class="panel panel-default">-->

                <!--<div class="panel-heading" style="background-color: #4CAF50">-->
                    <!--<div class="postLayout">-->

                        <!--<div class="postLayout-left">-->
                            <!--<a href="">-->
                                <!--<img src="../Resources/UploadedImgs/man.png" class="postLayout-object">-->
                            <!--</a>-->
                        <!--</div>-->
                        <!--<div class="postLayout-header-body">-->
                            <!--<div class="postLayout-heading"><a class="user">Jonathan</a></div>-->
                            <!--<div class="postLayout-bottom"><div class="header-date">on 15th January, 2014</div></div>-->
                        <!--</div>-->
                    <!--</div>-->
                <!--</div>-->

                <!--<div class="panel-body">-->
                    <!--Amazing 3D Animation-->
                    <!--<div class="timeline-added-images">-->
                        <!--<img src="../Resources/UploadedImgs/201707141001241501264039.png" width="80" alt="photo" />-->
                        <!--<img src="../Resources/UploadedImgs/20170719153646889933074.jpg" width="80" alt="photo" />-->
                        <!--<img src="../Resources/UploadedImgs/201707181724441840804854.png" width="150" alt="photo" />-->
                        <!--<img src="../Resources/UploadedImgs/201707141001241501264039.png" width="80" alt="photo" />-->

                    <!--</div>-->
                <!--</div>-->
                <!--<div class="comments-header">-->
                    <!--<button type="button" class="btn btn-primary"  style="position:relative; margin:5px">-->
                        <!--<span class="glyphicon glyphicon-thumbs-up"></span> Likes-->
                        <!--<span class="badge">7</span>-->
                    <!--</button>-->
                    <!--<p><span class="glyphicon glyphicon-comment"> </span> Be the first to comment</p>-->

                <!--</div>-->
                <!--<ul class="comments">-->
                    <!--<li class="postLayout">-->
                        <!--<div class="postLayout-left">-->
                            <!--<a href="">-->
                                <!--<img src="../Resources/UploadedImgs/woman.png" class="commenter-img">-->
                            <!--</a>-->
                        <!--</div>-->
                        <!--<div class="postLayout-body">-->
                            <!--<a href="" class="author">Mary</a>-->
                            <!--<span>Wow</span>-->
                            <!--<div class="date">2 days</div>-->
                        <!--</div>-->
                    <!--</li>-->
                    <!--<li class="postLayout">-->
                        <!--<div class="postLayout-left">-->
                            <!--<a href="">-->
                                <!--<img src="../Resources/UploadedImgs/man.png" class="commenter-img">-->
                            <!--</a>-->
                        <!--</div>-->
                        <!--<div class="postLayout-body">-->
                            <!--<a href="" class="author">John</a>-->
                            <!--<span>Yes I Know</span>-->
                            <!--<div class="date">1 days</div>-->
                        <!--</div>-->
                    <!--</li>-->
                    <!--<li class="postLayout">-->
                        <!--<div class="postLayout-left">-->
                            <!--<a href="">-->
                                <!--<img src="../Resources/UploadedImgs/201707181724441840804854.png" class="commenter-img">-->
                            <!--</a>-->
                        <!--</div>-->
                        <!--<div class="postLayout-body">-->
                            <!--<a href="" class="author">Cat</a>-->
                            <!--<span>:-)</span>-->
                            <!--<div class="date">now</div>-->
                        <!--</div>-->
                    <!--</li>-->
                    <!--<li class="comment-form">-->
                        <!--<div class="input-group">-->

                            <!--<input type="text" class="form-control" />-->

                            <!--<span class="input-group-btn">-->
                                <!--<a href="" class="btn btn-default"><span class="glyphicon glyphicon-comment"> </span></a>-->
                            <!--</span>-->
                        <!--</div>-->
                    <!--</li>-->
                <!--</ul>-->
            <!--</div>-->
        <!--</div>-->
    <!--</div>-->

<!--</div>-->

<?php
require_once("PostDetails.php");
require_once ("..\utils\HtmlHelper.php");
$v = new PostDetails("This is My Status to Show!! :-)", "201707141001241501264039.png,201707181724441840804854.png", "OhadCohen",12,"06-14-2017 15:30:00","Public");
printSinglePost($v);

?>


</body>
</html>