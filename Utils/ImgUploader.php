<?php

const UPLOADED_BUILTIN_LOCATION = "../Resources/Images/";
const UPLOADED_IMAGES_LOCATION = "../Resources/UploadedImgs/";
const UPLOADED_THUMBS_LOCATION = "../Resources/Thumbs/";
const UPLOADED_PROFILE_LOCATION = "../Resources/Profiles/";

/**
 * Orginaizing the files from the $_FILES.
 * @param $file
 * @return array
 */
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

/**
 * Uploading Images array and creating Thumb for them.
 * @param $imgs
 * @return array
 */
function UploadImgs($imgs){
    $images_arr = array();

    if(!empty($imgs)) {
        $img_desc = reArrayFiles($imgs);
        foreach($img_desc as $val)
        {
            $temp = explode(".", $val['name']);
            $extension = end($temp);
            $newname = date('YmdHis',time()).mt_rand().'.'.$extension;
            move_uploaded_file($val['tmp_name'],UPLOADED_IMAGES_LOCATION.$newname);
            if (!empty($val['tmp_name'])){
                array_push($images_arr, $newname);
                CreateThumb(UPLOADED_IMAGES_LOCATION.$newname, UPLOADED_THUMBS_LOCATION.$newname, 100);
            }
        }
    }

    return $images_arr;
}

/**
 * Creating thumb for an inputted Image.
 * @param $src
 * @param $dest
 * @param $desired_width
 */
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

/**
 * Updating the given username profile picture, replacing it if already exists.
 * @param $username
 * @param $img
 * @return bool
 */
function UpdateProfilePicture($username, $img){
    $img_name = basename($img["name"]);
    $imgFileType = pathinfo($img_name,PATHINFO_EXTENSION);
    $newName = $username.".jpg";
    $target = UPLOADED_PROFILE_LOCATION.$newName;

    if (move_uploaded_file($img['tmp_name'], $target)){
        return true;
    }else{
        return false;
    }
}

function GetUserProfileImgOrDefault($username){
    $fullImgPath = UPLOADED_PROFILE_LOCATION.$username.".jpg";
    if (file_exists($fullImgPath)){
        return $fullImgPath;
    }else{
        return UPLOADED_BUILTIN_LOCATION."profile-icon.png";
    }
}