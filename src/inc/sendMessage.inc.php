<?php
session_start();
date_default_timezone_set('Australia/Adelaide');
include './dbconn.inc.php';
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
    $Subject = test_input($_POST["Subject"]);

    // Split the name into first and last name
    $parts = explode(" ", $_POST["user"]);
    $lastName = array_pop($parts);
    $firstName = implode(" ", $parts);
          
    // Check if user exists
    $checkUserStmt = $conn->prepare("SELECT email FROM userdata WHERE firstname = ? AND lastname = ?");
    $checkUserStmt->bind_param("ss", $firstName, $lastName);
    $checkUserStmt->execute();
    $result = $checkUserStmt->get_result();
    
    if ($result->num_rows == 0) {
    $message = "User Not Found";
    
    } else {
    $sentto = $result->fetch_assoc()['email'];
    $checkUserStmt->close();
    
    
    // Getting Sender Email from Session
    $id =$_SESSION['id'];
    $getUserEmailstmt = $conn->prepare('SELECT email FROM userdata WHERE id=?');
    $getUserEmailstmt->bind_param('i', $id);
    $getUserEmailstmt->execute();
    $emailResult = $getUserEmailstmt->get_result();
    $sender = $emailResult->fetch_assoc()['email'];
    $getUserEmailstmt->close();

    // Inserting into mailbox database
    $mailboxStmt = $conn->prepare("INSERT INTO mailbox (Subject, message, sentby, sentto, created) VALUES (?, ?, ?, ?, ?)");
    $mailboxStmt->bind_param("sssss", $Subject, $message, $sender, $sentto, $date);
    $mailboxStmt->execute();
    $mailbox_id = $conn->insert_id;
    $mailboxStmt->close();
    
    // Insert into user_mailbox

    $userMailboxStmt1 = $conn->prepare("INSERT INTO user_mailbox (user, mailbox, mailbox_id) VALUES (?, 'In', ?)");
    $userMailboxStmt1->bind_param("si", $sentto, $mailbox_id);
    $userMailboxStmt1->execute();
    $userMailboxStmt1->close();

    $userMailboxStmt2= $conn->prepare("INSERT INTO user_mailbox (user, mailbox, mailbox_id) VALUES (?, 'Out', ?)");
    $userMailboxStmt2->bind_param("si", $sender, $mailbox_id);
    $userMailboxStmt2->execute();
    $userMailboxStmt2->close();
    $message = "Success";
    
  }
  header ("Location: ../Webpages/inbox.php?$message");  
  $conn->close();
  exit();
}
?>

 
  