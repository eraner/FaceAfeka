<?php

class StatusDetails
{
    public $status;
    public $imgSrc;
    public $name;

    function __construct($status, $imgSrc, $name)
    {
        $this->status = $status;
        $this->imgSrc = $imgSrc;
        $this->name = $name;
    }
}