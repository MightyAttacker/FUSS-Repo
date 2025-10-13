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

// Fetch User's Admin Status
$getUserAdmin = 0;
$getUserAdminStmt = $conn->prepare('SELECT admin FROM userdata WHERE id=?');
$getUserAdminStmt->bind_param('i', $id);
$getUserAdminStmt->execute();
$getUserAdmin = $getUserAdminStmt->get_result();
  if ($row = $getUserAdmin->fetch_assoc()) {
    $getUserAdmin = $row['admin'];
  }
$getUserAdminStmt->close();

// Fetch the user's FussCredits
$getUserCreditStmt = $conn->prepare('SELECT credits FROM userdata WHERE id=?');
$getUserCreditStmt->bind_param('i', $id);
$getUserCreditStmt->execute();
$userCredits = $getUserCreditStmt->get_result()->fetch_assoc()['credits'];
$getUserCreditStmt->close();
?>

<!DOCTYPE html>
<html lang="en-AU">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="inboxStyle.css">
  <meta name="author" content="Jayden">
  <script src="inbox.js"> </script>
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
      <h4>
          <?php echo "Hello, " . $user . "<br>" . "You have " . $userCredits . " Credits!" ?> </h4>

    </div>
    <div id="logoutButton">
      <input id="logButton" class="button" type="button" onclick="location.href='./loginPages/logout.php';"
        value="Logout"/>
    </div>
  </div>

<div id="sideBar">
    <ul class="sidebar">
            <li> <a href="./student-homepage.php">Home</a> </li>
            <li> <a class="active" href="./inbox.php"> Inbox</a> </li>
            <li> <a href="./browsePage.php"> Browse Offered Skills</a> </li>
            <li> <a href="./requests.php"> Make A Request</a> </li>
            <li> <a href="./myRequests.php">View My Requests</a> </li>
            <li> <a href="./PeerFeedback.php">Peer Reviews</a> </li>
            <li> <a href="./studentProfile.php">My Profile</a> </li>
            <li> <a href="./changeAvailability.php">Change Availability</a> </li>
            <li> <a href="./creditHistory.php">Credit History</a> </li>
            <?php if ($getUserAdmin == 1) echo '<li> <a href="./admin-pages/admin-dashboard.html">Admin Dashboard</a> </li>' ?>
    </ul>
  </div>

  <main>
    <div id="Header">
      <h2> <Button onclick="showInbox()" class="button">Inbox</Button> <Button class="button" onclick="showMessage()">Send Message</Button> <Button onclick="showOutbox()" class="button" >Outbox</Button> </h2>
    </div>

    <div id="mailboxContainer">
      <div id="inbox">
        <h3 class="currentMailbox">Inbox</h3>
        <table id="inboxTable">
          <tr>
            <th>From</th>
            <th>Subject</th>
            <th>Message</th>
            <th>Date</th>
          </tr>
          <?php
          $stmt = $conn->prepare("SELECT Subject, sentby, message, DATE_FORMAT(created,'%T %d/%m/%Y') FROM user_mailbox INNER JOIN mailbox ON mailbox.id = user_mailbox.mailbox_id WHERE user_mailbox.user =? AND user_mailbox.mailbox = 'In' ORDER BY created DESC;");
          $stmt->bind_param("s", $email);
          $stmt->execute();
          $result = $stmt->get_result();
           if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>". $row["sentby"] . "</td>";
                echo "<td>". $row["Subject"] . "</td>";
                echo "<td>". $row["message"] . "</td>"; 
                echo "<td>". $row["DATE_FORMAT(created,'%T %d/%m/%Y')"]. "</td>";
                echo "</tr>";
            }
        } else {
            echo "<h3>"."No Messages Found"."</h3>";
                  }
          $stmt->close();
          
          ?>
        </table>
      </div>
      <div id="sendMessage">
        <h3 class="currentMailbox">Sending Message</h3>
        <form action="../inc/sendMessage.inc.php" method="post" id="messageForm">
          <div class="form-card">
          <div class="form-section">
          <label for="user">To </label><br>
          <input class=".form-item" type="text" id="user" name="user" required><br>
          </div>
          <div class="form-section">
          <label for="subject">Subject:</label><br>
          <input class=".form-item" type="text" id="Subject" name="Subject" required><br>
          </div>
          <div class="form-section">
          <label for="message">Message:</label><span id="charNum"></span>
          <br>
          <textarea id="message" name="message" rows="4" cols="50" maxlength="255" onkeyup="limitText(this,255)" required></textarea>
          <br>
          </div>
          <input id="submitButtons" class="button" type="submit" value="Send" href="../inc/sendMessage.inc.php"> 
          <input id="submitButtons" class="button" type="reset" value="Clear">
          </div>
      </div>
      <div id="outbox">
        <h3 class="currentMailbox">Outbox</h3>
        <table id="outboxTable">
          <tr>
            <th>To</th>
            <th>Subject</th>
            <th>Message</th>
            <th>Date</th>
          </tr>
          <?php
          $stmt4 = $conn->prepare("SELECT Subject, sentto, message, DATE_FORMAT(created,'%T %d/%m/%Y') FROM user_mailbox INNER JOIN mailbox ON mailbox.id = user_mailbox.mailbox_id WHERE user_mailbox.user =? AND user_mailbox.mailbox = 'Out' ORDER BY created DESC;");
          $stmt4->bind_param("s", $email);
          $stmt4->execute();
          $result = $stmt4->get_result();
           if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>". $row["sentto"] . "</td>";
                echo "<td>". $row["Subject"] . "</td>";
                echo "<td>". $row["message"] . "</td>"; 
                echo "<td>". $row["DATE_FORMAT(created,'%T %d/%m/%Y')"]. "</td>";
                echo "</tr>";
                
            }
        } else {
            echo "<h3>"."No Messages Found"."</h3>";
                  }
          $stmt4->close();
          
          ?>
        </table>
      </div>

    </div>

  </main>