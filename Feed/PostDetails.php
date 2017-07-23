<?php

class PostDetails
{
    public $postID;
    public $status;
    public $imgSrc;
    public $publisher;
    public $likes;
    public $date;
    public $privacy;
    public $commentArray;

    function __construct($postID, $status, $imgSrc, $publisher, $likes, $date, $privacy, $commentsArr)
    {
        $this->postID = $postID;
        $this->status = $status;
        $this->imgSrc = $imgSrc;
        $this->publisher = $publisher;
        $this->likes = $likes;
        $this->date = $date;
        $this->privacy = $privacy;
        $this->commentArray = $commentsArr;
    }
}