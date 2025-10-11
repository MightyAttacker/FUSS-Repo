<?php
session_start();
// Database connection 
include "../inc/dbconn.inc.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $target_dir = "../userProfilePictures/"; // Directory where images will be stored
    $target_file = $target_dir . basename($_FILES["imageUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $message="";
    
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["imageUpload"]["tmp_name"]);
    if ($check === false) {
        $message="notImage";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        $message= "fileExists";
        $uploadOk = 0;
    }

    // Check file size (50MB Limit)
    if ($_FILES["imageUpload"]["size"] > 50000000) {
        $message= "fileTooLarge";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
        $message= "invalidFormat";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 1) {
       // if everything is ok, try to upload file
        if (move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $target_file)) {

            // Store file path in database
            $image_name = basename($_FILES["imageUpload"]["name"]);
            $image_path = $target_file;


            $id = $_SESSION['id'];
            $uploadStmt = $conn ->prepare("UPDATE userdata SET imageName=?, imagePath=? WHERE id=?");
            $uploadStmt -> bind_param('ssi',$image_name,$image_path, $id);
            $uploadStmt -> execute();
            $uploadStmt -> close();
            $message="uploadSuccess";
            
        } else {
            $message="errorUploading";
        }
    }
}
header("location: ./editProfile.php?$message");
$conn->close();
exit();
?>