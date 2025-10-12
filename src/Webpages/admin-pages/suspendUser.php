<?php
session_start();
include "../../inc/dbconn.inc.php";



if (isset($_POST["studentId"]) && isset($_POST["suspendDate"])){
    $studentId = $_POST["studentId"];
    $suspendDate = $_POST["suspendDate"];
   

    // Prepare and execute the update statement
    $updateStmt = $conn->prepare("UPDATE userdata SET Suspended = 1, suspendedUntil = ? WHERE id = ?");
    $updateStmt->bind_param("si", $suspendDate, $studentId);

    if ($updateStmt->execute()) {
        // Redirect back to the view-students page with a success message
        header("Location: view-students.php?message=User Suspened successfully");
        exit();
    } else {
        // Handle error
        echo "Error updating Suspension: " . $conn->error;
    }

    $updateStmt->close();    

}
$conn->close();
?>