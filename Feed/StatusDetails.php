<?php

class StatusDetails
{
    public $status;
    public $imgSrc;
    public $publisher;
    public $likes;
    public $date;
    public $privacy;

    function __construct($status, $imgSrc, $publisher, $likes, $date, $privacy)
    {
        $this->status = $status;
        $this->imgSrc = $imgSrc;
        $this->publisher = $publisher;
        $this->likes = $likes;
        $this->date = $date;
        $this->privacy = $privacy;
    }
}