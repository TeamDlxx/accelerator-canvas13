<?php
include '../include/functions.php';
include '../include/config.php';
include("../include/resize-class.php");
if (isset($_FILES['upload']['name'])) {
    $file = $_FILES['upload']['tmp_name'];
    $file_name = $_FILES['upload']['name'];
    $file_name_array = explode(".", $file_name);
    $extension = end($file_name_array);
    //we want to save the image with timestamp and randomnumber
    $new_image_name = time() . rand() . '.' . $extension;
    chmod('upload', 0777);
    $allowed_extension = array("jpg", "gif", "png", "jpeg");
    if (in_array($extension, $allowed_extension)) {

        move_uploaded_file($file, '../uploads/upload/' . $new_image_name);

        // $cover_thumbnail1 = '../uploads/upload/thumbnail/' . $new_image_name;
        // $resizeObj = new resize('../uploads/upload/' . $new_image_name);
        // $resizeObj->resizeImage(800, 500, 'crop');
        // $resizeObj->saveImage($cover_thumbnail1, 100);

        $function_number = $_GET['CKEditorFuncNum'];
        $url = $base_url . 'uploads/upload/' . $new_image_name;
        $message = '';
        echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($function_number, '$url', '$message');</script>";
    }
}