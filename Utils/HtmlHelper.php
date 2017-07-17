<?php
require_once('..\DB\DatabaseHelper.php');


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