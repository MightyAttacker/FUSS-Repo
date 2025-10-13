<?php
session_start();
include "../../inc/dbconn.inc.php";



if (isset($_POST["studentId"])){
    $studentId = $_POST["studentId"];
    
    // Prepare and execute the update statement
    $updateStmt = $conn->prepare("UPDATE userdata SET Deleted = 1 WHERE id = ?");
    $updateStmt->bind_param("i", $studentId);

    if ($updateStmt->execute()) {
        // Redirect back to the view-students page with a success message
        header("Location: view-students.php?message=User Account Deleted successfully");
        exit();
    } else {
        // Handle error
        echo "Error Deleting User: " . $conn->error;
    }

    $updateStmt->close();    

}
$conn->close();
?>