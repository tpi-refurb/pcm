<?php

function make_unique($full_path) {
    $file_name = basename($full_path);
    $directory = dirname($full_path).DIRECTORY_SEPARATOR;

    $i = 2;
    while (file_exists($directory.$file_name)) {
        $parts = explode('.', $file_name);
        // Remove any numbers in brackets in the file name
        $parts[0] = preg_replace('/\(([0-9]*)\)$/', '', $parts[0]);
        $parts[0] .= '('.$i.')';
		
        $new_file_name = implode('.', $parts);
        if (!file_exists($new_file_name)) {
            $file_name = $new_file_name;
        }
        $i++;
    }
    return $directory.$file_name;
}

function file_newname($path, $filename){
    if ($pos = strrpos($filename, '.')) {
           $name = substr($filename, 0, $pos);
           $ext = substr($filename, $pos);
    } else {
           $name = $filename;
    }

    $newpath = $path.'/'.$filename;
    $newname = $filename;
    $counter = 0;
    while (file_exists($newpath)) {
           $newname = $name .'_'. $counter . $ext;
           $newpath = $path.'/'.$newname;
           $counter++;
     }

    return $newname;
}

defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
/*
	This file receives the JPEG snapshot
	from webcam.swf as a POST request.
*/

// We only need to handle POST requests:
if(strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
	exit;
}

$brand_name = strtoupper($_GET['b']);

$temp_folder = 'uploads/temp/';
$orig_folder = 'uploads/brands/';

$filename = $brand_name.'.jpg';


/****** START--- Create Batch folder inside Original/Thumb Folder ******/
if (!is_dir($temp_folder)) {
    mkdir($temp_folder,0777,true);
}

if (!is_dir($orig_folder)) {
    mkdir($orig_folder,0777,true);
}


/****** END--- Create Batch folder inside Original/Thumb Folder ******/

$temp_filename = $temp_folder.$filename;

// The JPEG snapshot is sent as raw input:
$input = file_get_contents('php://input');

if(md5($input) == '7d4df9cc423720b7f1f3d672b89362be'){
	// Blank image. We don't need this one.
	exit;
}

$result = file_put_contents($temp_filename, $input);
if (!$result) {
	echo '{
		"error"		: 1,
		"message"	: "Failed save the image. Make sure you chmod the uploads folder and its subfolders to 777."
	}';
	exit;
}

$info = getimagesize($temp_filename);
if($info['mime'] != 'image/jpeg'){
	unlink($temp_filename);
	exit;
}

$final_filename = $orig_folder.$filename;

if(file_exists($final_filename)){
	$final_filename = make_unique($final_filename);
}
// Moving the temporary file to the originals folder:
rename($temp_filename,$final_filename);

// Using the GD library to resize 
// the image into a thumbnail:

$origImage	= imagecreatefromjpeg($final_filename);
$newImage	= imagecreatetruecolor(154,110);
imagecopyresampled($newImage,$origImage,0,0,0,0,154,110,520,370); 

$new_thumb_filename = str_replace($orig_folder,$thumb_folder,$final_filename);
imagejpeg($newImage,$new_thumb_filename);

echo '{"status":1,"message":"Success!","filename":"'.$filename.'"}';
