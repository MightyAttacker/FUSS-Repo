<?php
session_start();
// Database connection 
include "../inc/dbconn.inc.php";


if (isset($_POST["submit"])) {
    $target_dir = "../userProfilePictures/"; // Directory where images will be stored
    $target_file = $target_dir . basename($_FILES["imageToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["imageToUpload"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size (50MB Limit)
    if ($_FILES["imageToUpload"]["size"] > 50000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["imageToUpload"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["imageToUpload"]["name"])) . " has been uploaded.";

            // Store file path in database
            $image_name = basename($_FILES["imageToUpload"]["name"]);
            $image_path = $target_file;

            $sql = "INSERT INTO images (name, path) VALUES ('$image_name', '$image_path')";

            if ($conn->query($sql) === TRUE) {
                $message="Success";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

        } else {
            $message="errorUploading";
        }
    }
}
header("location: ./studentProfileEdit.php?$message");
$conn->close();
exit();
?>