<?php

const UPLOADED_IMAGES_LOCATION = "../Resources/UploadedImgs/";

function reArrayFiles($file)
{
    $file_ary = array();
    $file_count = count($file['name']);
    $file_key = array_keys($file);

    for($i=0; $i<$file_count; $i++)
    {
        foreach($file_key as $val)
        {
            $file_ary[$i][$val] = $file[$val][$i];
        }
    }
    return $file_ary;
}

function UploadImgs($imgs){
    $images_arr = array();

    if(!empty($imgs))
    {
        $img_desc = reArrayFiles($imgs);
        //return $img_desc;
        foreach($img_desc as $val)
        {
            $temp = explode(".", $val['name']);
            $extension = end($temp);
            $newname = date('YmdHis',time()).mt_rand().'.'.$extension;
            move_uploaded_file($val['tmp_name'],UPLOADED_IMAGES_LOCATION.$newname);
            if (!empty($val['tmp_name'])){
                array_push($images_arr, $newname);
            }
        }
    }

    return $images_arr;
}