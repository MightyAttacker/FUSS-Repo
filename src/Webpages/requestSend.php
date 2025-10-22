<?php
session_start();
date_default_timezone_set('Australia/Adelaide');
include '../inc/dbconn.inc.php';
$date = date('Y-m-d H:i:s');
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $message = test_input($_POST["message"]);
    $user = test_input($_POST["user"]);
    $skillName = test_input($_POST["skillName"]);
    $credits = test_input($_POST["creditsOffered"]);
    $proposedDate = test_input($_POST["proposedDateTime"]);

    // Split the name into first and last name
    $parts = explode(" ", $_POST["user"]);
    $lastName = array_pop($parts);
    $firstName = implode(" ", $parts);
          
    // Check if user exists
    $checkUserStmt = $conn->prepare("SELECT id FROM userdata WHERE firstname = ? AND lastname = ?");
    $checkUserStmt->bind_param("ss", $firstName, $lastName);
    $checkUserStmt->execute();
    $result = $checkUserStmt->get_result();
    
    if ($result->num_rows == 0) {
    $message = "User Not Found";
    
    } else {
    $requestee = $result->fetch_assoc()['id'];
    $checkUserStmt->close();
    
    
    // Getting Sender Email from Session
    $id =$_SESSION['id'];
    

    // Inserting into requestbox database
    $requestboxStmt = $conn->prepare("INSERT INTO requestbox (skillName, message, credits, requestee, requester, proposedDate, created) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $requestboxStmt->bind_param("ssiiiss", $skillName, $message, $credits, $requestee, $id, $proposedDate ,$date);
    $requestboxStmt->execute();
    $requestbox_id = $conn->insert_id;
    $requestboxStmt->close();
    
    // Insert into user_requestbox

    $userRequestBoxStmt1 = $conn->prepare("INSERT INTO user_requestbox (user, requestBoxType, requestBox_id) VALUES (?, 'In', ?)");
    $userRequestBoxStmt1->bind_param("ii", $requestee, $requestbox_id);
    $userRequestBoxStmt1->execute();
    $userRequestBoxStmt1->close();

    $userRequestBoxStmt2= $conn->prepare("INSERT INTO user_requestbox (user, requestBoxType, requestBox_id) VALUES (?, 'Out', ?)");
    $userRequestBoxStmt2->bind_param("ii", $id, $requestbox_id);
    $userRequestBoxStmt2->execute();
    $userRequestBoxStmt2->close();
    $message = "Success";
    
  }
  header ("Location: ../Webpages/requests.php?$message");  
  $conn->close();
  exit();
}
?>