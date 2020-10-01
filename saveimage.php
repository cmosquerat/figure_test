<?php
header("Access-Control-Allow-Origin: *");
$file_name = $_FILES['file']['name'];
$directory = $_POST['directory'];
$tmp_file = $_FILES['file']['tmp_name'];


if (!file_exists('upload'.$directory)) {
    mkdir('upload/'.$directory, 0777, true);
}

$file_path = 'upload/'.$directory.'/'.$file_name;



$r = move_uploaded_file($tmp_file, $file_path);



?>