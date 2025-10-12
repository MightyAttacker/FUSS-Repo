<?php
session_start();
include "../../inc/dbconn.inc.php";



if ((isset($_POST["studentId"])) && (isset($_POST["newCredits"]))){
    $studentId = $_POST["studentId"];
    $newCredits = $_POST["newCredits"];

    // Prepare and execute the update statement
    $updateStmt = $conn->prepare("UPDATE userdata SET credits = ? WHERE id = ?");
    $updateStmt->bind_param("ii", $newCredits, $studentId);

    if ($updateStmt->execute()) {
        // Redirect back to the view-students page with a success message
        header("Location: view-students.php?message=Credits updated successfully");
        exit();
    } else {
        // Handle error
        echo "Error updating credits: " . $conn->error;
    }

    $updateStmt->close();    

}
$conn->close();
?>