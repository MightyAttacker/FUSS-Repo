<?php


session_start();

if (!isset($_SESSION['id'])) {

  session_unset();
  session_destroy();

  header('location: ./loginPages/studentLoginPage.php');

} else {
  // session logged
}

include '../inc/dbconn.inc.php';

$id = $_SESSION['id'];
$stmt2 = $conn->prepare('SELECT email FROM userdata WHERE id=?');
$stmt2->bind_param('i', $id);
$stmt2->execute();
$email = $stmt2->get_result()->fetch_assoc()['email'];

$stmt3 = $conn->prepare('SELECT firstName FROM userdata WHERE id=?');
$stmt3->bind_param('i', $id);
$stmt3->execute();
$user = $stmt3->get_result()->fetch_assoc()['firstName'];

?>

<!DOCTYPE html>
<html lang="en-AU">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="messagesStyle.css">
  <meta name="author" content="Jayden">
  <script src="login.js"> </script>
  <title>FUSS Messages Page</title>
</head>

<body>
  <div id="topBanner">
    <div id="flindersLogo">
      <img id="imgLogo" src="./images/Logo_Flinders_white.png" alt="Logo for Flinders University" id="flindersLogo">
    </div>
    <div id="title">
      <header>
        <h1>Flinders University Skill Share</h1>
      </header>
    </div>
    <div id="UserDetails">
      <h4> <?php echo "Hello, " . $user ?></h4>
    </div>
    <div id="logoutButton">
      <input id="logButton" class="button" type="button" onclick="location.href='./loginPages/logout.php';"
        value="Logout"/>
    </div>
  </div>

  <div id="sideBar">
    <ul class="sidebar">
      <li> <a href="#home">Home</a> </li>
      <li> <a class="active" href="#Requests"> Make A Request</a> </li>
      <li> <a href="#ViewRequests">View My Requests</a> </li>
      <li> <a href="#BrowseRequests">Browse Requests</a> </li>
      <li> <a href="#ManageProfile">Manage Profile</a> </li>
      <li> <a href="#History">History</a> </li>
    </ul>
  </div>

  <main>
    <div id="Header">
      <h2> <Button class="button">Inbox</Button> <Button class="button">Send Message</Button> <Button class="button">Outbox</Button> </h2>
    </div>

    <div id="inboxContainer">
      <div id="inboxMessages">
        <table id="inboxTable">
          <tr>
            <th>From</th>
            <th>Subject</th>
            <th>Message</th>
            <th>Date</th>
          </tr>
          <?php
          $stmt = $conn->prepare("SELECT Subject, sentby, message, DATE_FORMAT(created,'%d/%m/%Y') FROM user_mailbox INNER JOIN mailbox ON mailbox.id = user_mailbox.message_id WHERE user_mailbox.user =? AND user_mailbox.mailbox = 'In';");
          $stmt->bind_param("s", $email);
          $stmt->execute();
          $result = $stmt->get_result();
           if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<td>". $row["sentby"] . "</td>" . "<td>". $row["Subject"] . "</td>" . "<td>". $row["message"] . "</td>" ."<td>". $row["DATE_FORMAT(created,'%d/%m/%Y')"]. "</td>" . "<br>";
            }
        } else {
            echo "<h3>"."No Messages Found"."</h3>";
                  }
          $stmt->close();
          $conn->close();
          ?>
        </table>
      </div>


  </main>