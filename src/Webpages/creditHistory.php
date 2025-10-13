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
  <title>FUSS Credit History Page</title>
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
            <li> <a href="./inbox.php"> Inbox</a> </li>
            <li> <a href="./browsePage.php"> Browse Offered Skills</a> </li>
            <li> <a href="./requests.php"> Make A Request</a> </li>
            <li> <a href="./myRequests.php">View My Requests</a> </li>
            <li> <a href="./PeerFeedback.php">Peer Reviews</a> </li>
            <li> <a href="./studentProfile.php">My Profile</a> </li>
            <li> <a href="./changeAvailability.php">Change Availability</a> </li>
            <li> <a class="active" href="./creditHistory.php">Credit History</a> </li>
            <?php if ($getUserAdmin == 1) echo '<li> <a href="./admin-pages/admin-dashboard.html">Admin Dashboard</a> </li>' ?>
</ul>
  </div>

  <main>
    <div id="Header">
    <h2>Credit History</h2>    
    <p>Below is a history of your credit transactions.</p>
    </div>

    <div id="mailboxContainer">
      <div id="inbox">
        <table id="inboxTable">
          <tr>
            <th>Requestee</th>
            <th>Requester</th>
            <th>Credits</th>
            <th>Skill Name</th>            
            <th>Date</th>
            
          </tr>
          <?php
          // Fetch the user's credit history
$creditHistoryStmt = $conn->prepare('SELECT 
requestee, 
requester, 
requestbox.credits, 
skillName, 
proposedDate, 
ur.firstName AS requesterFirstName,
ur.lastName AS requesterLastName,
ue.firstName AS requesteeFirstName,
ue.lastName AS requesteeLastName
FROM requestbox 
INNER JOIN userdata ur ON requester = ur.id
INNER JOIN userdata ue ON requestee = ue.id WHERE requestee=? OR requester=? AND creditsReleased = 1 ORDER BY proposedDate DESC');
$creditHistoryStmt->bind_param('ii', $id, $id);
$creditHistoryStmt->execute();
$creditHistory = $creditHistoryStmt->get_result();

          if ($creditHistory->num_rows > 0) {
            while ($row = $creditHistory->fetch_assoc()) {
    $isRequestee = ($row['requestee'] == $id);
    $creditValue = $isRequestee ? '+' . $row['credits'] : '-' . $row['credits'];
    echo "<tr>";
    echo "<td>". $row["requesteeFirstName"] . " " . $row["requesteeLastName"] . "</td>";
    echo "<td>". $row["requesterFirstName"] . " " . $row["requesterLastName"] . "</td>";
    echo "<td>". $creditValue . "</td>";
    echo "<td>". $row["skillName"] . "</td>";               
    echo "<td>". date('H:i d/m/Y', strtotime($row["proposedDate"])) . "</td>";
    echo "</tr>";
            }
        } else {
            echo "<h3>"."No Transactions Found"."</h3>";
                  }
$creditHistoryStmt->close();
          ?>
        </table>
      </div>