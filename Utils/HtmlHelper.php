<?php

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
        </head>";
}

function AddTopNavigationBar($loggedUser){
    /** Navigation Bar Init*/
    echo "<div class='navbar'>
           <ul>
            <li><a class=\"active\" href='#'>FaceAfeka</a> </li>
            <li><a href='#'>Profile</a> </li>
            <li><a href='#'>Friends</a> </li>
            <li><button type='button' data-toggle='modal'
            data-target='#myPost'>Post</button></li>
           </ul>";
    echo "</div>"; /**navbar /div*/

    /**Setup Post window popup*/
    echo "<div class='modal fade' id='myPost' role='dialog'>
            <div class='modal-dialog'>";
    /**Set Post window content*/
    echo "<div class=\"post-style\">
    <form action=\"UploadPost.php\" method='post'>
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
                <td><input type=\"file\" name=\"pic\" accept=\"image/*\"></td>
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