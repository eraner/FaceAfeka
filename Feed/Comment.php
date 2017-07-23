<?php

class Comment
{
    public $postID;
    public $comment;
    public $username;
    public $date;

    function __construct($postID, $comment, $username, $date)
    {
        $this->postID = $postID;
        $this->comment = $comment;
        $this->username = $username;
        $this->date = $date;
    }
}