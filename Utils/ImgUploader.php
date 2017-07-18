<?php

const UPLOADED_IMAGES_LOCATION = "../Resources/UploadedImgs/";
const UPLOADED_THUMBS_LOCATION = "../Resources/Thumbs/";

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
            CreateThumb(UPLOADED_IMAGES_LOCATION.$newname, UPLOADED_THUMBS_LOCATION.$newname, 100);
        }
    }

    return $images_arr;
}

function CreateThumb($src, $dest, $desired_width) {

    $info = getimagesize($src);

    /* read the source image */
    switch($info['mime']){
        case 'image/png':
            $source_image = imagecreatefrompng($src);
            break;
        case 'image/jpeg':
            $source_image = imagecreatefromjpeg($src);
            break;
        case 'image/gif':
            $source_image = imagecreatefromgif($src);
            break;
    }

    $width = imagesx($source_image);
    $height = imagesy($source_image);

    /* find the "desired height" of this thumbnail, relative to the desired width  */
    $desired_height = floor($height * ($desired_width / $width));

    /* create a new, "virtual" image */
    $virtual_image = imagecreatetruecolor($desired_width, $desired_height);

    /* copy source image at a resized size */
    imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

    /* create the physical thumbnail image to its destination */
    switch($info['mime']){
        case 'image/png':
            imagepng($virtual_image, $dest);
            break;
        case 'image/jpeg':
            imagejpeg($virtual_image, $dest);
            break;
        case 'image/gif':
            imagegif($virtual_image, $dest);
            break;
    }

}