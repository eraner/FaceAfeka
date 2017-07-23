<?php

class PostDetails
{
    public $status;
    public $imgSrc;
    public $publisher;
    public $likes;
    public $date;
    public $privacy;
    public $commentArray;

    function __construct($status, $imgSrc, $publisher, $likes, $date, $privacy, $commentsArr)
    {
        $this->status = $status;
        $this->imgSrc = $imgSrc;
        $this->publisher = $publisher;
        $this->likes = $likes;
        $this->date = $date;
        $this->privacy = $privacy;
        $this->commentArray = $commentsArr;
    }
}