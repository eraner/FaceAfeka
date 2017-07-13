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
            <link href=\"../CSS/css.css\" rel=\"stylesheet\" type='text/css'>
        </head>";
}

function AddTopNavigationBar($user){
    $db = new DatabaseHelper();
    $friends = $db->GetUsersFriends($user);

    echo "<div class='navbar'>
           <ul>
            <li><a class=\"active\" href='#'>FaceAfeka</a> </li>
            <li><a href='#'>Profile</a> </li>";
    echo "    <ul class=\"sub-menu\">
                    <a href=\"#\">1st Friend </a>
                    <a href=\"#\">2nd Friend</a>
              </ul>";
    echo "<li><a href='#'>Friends</a> </li>
           </ul>
</div>";
}