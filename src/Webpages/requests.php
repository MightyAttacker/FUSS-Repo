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
$getUserCreditsStmt = $conn->prepare('SELECT credits FROM userdata WHERE id=?');
$getUserCreditsStmt->bind_param('i', $id);
$getUserCreditsStmt->execute();
$userCredits = $getUserCreditsStmt->get_result()->fetch_assoc()['credits'];

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

?>

<!DOCTYPE html>
<html lang="en-AU">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="inboxStyle.css">
  <meta name="author" content="Jayden">
  <script src="inbox.js"> </script>
  <title>FUSS Requests Page</title>
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
      <h4> <a id="profileLink" href="./studentProfile.php">
          <?php echo "Hello, " . $user . "<br>" . "You have " . $userCredits . " Credits!" ?> </a></h4>
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
            <li> <a class="active" href="./requests.php"> Make A Request</a> </li>
            <li> <a href="./myRequests.php">View My Requests</a> </li>
            <li> <a href="./PeerFeedback.php">Peer Reviews</a> </li>
            <li> <a href="./studentProfile.php">My Profile</a> </li>
            <li> <a href="#History">Credit History</a> </li>
            <?php if ($getUserAdmin == 1) echo '<li> <a href="./admin-pages/admin-dashbaord.html">Admin Dashboard</a> </li>' ?>
    </ul>
  </div>

 <main>
    <div id="Header">
      <h2> <Button onclick="showInbox()" class="button">Incoming Requests</Button> <Button class="button" onclick="showMessage()">Send Request</Button> <Button onclick="showOutbox()" class="button" >Sent Requests</Button> </h2>
    </div>

    <div id="mailboxContainer">
      <div id="inbox">
        <h3 class="currentMailbox">Requests For Help</h3>
        <table id="inboxTable">
          <tr>
            <th>From</th>
            <th>Skill Name</th>   
            <th>Credits Offered</th>         
            <th>Message</th>
            <th>Proposed Date and Time</th>
            <th>Date Sent</th>
            <th>Agree to Request</th>
          </tr>
          <?php
          $getRequestsInstmt = $conn->prepare("SELECT 
          userdata.firstName AS requesterFirstName, 
          userdata.lastName AS requesterLastName,
          user_requestbox.requestbox_id, 
          requesteeAgreed, 
          skillName, 
          requester, 
          message, 
          requestbox.credits, 
          DATE_FORMAT(proposedDate, '%T %d/%m/%Y') AS formattedProposedDate, 
          DATE_FORMAT(created,'%T %d/%m/%Y') AS formattedCreated 
          FROM user_requestbox 
          INNER JOIN requestBox ON requestBox.id = user_requestbox.requestbox_id 
          INNER JOIN userdata ON userdata.id = user_requestbox.user
          WHERE user_requestbox.user =? AND user_requestbox.requestBoxType = 'In' 
          ORDER BY created DESC;");
          $getRequestsInstmt->bind_param("i", $id);
          $getRequestsInstmt->execute();
          $result = $getRequestsInstmt->get_result();
           if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>". $row["requesterFirstName"] . $row["requesterLastName"] ."</td>";
                echo "<td>". $row["skillName"] . "</td>";
                echo "<td>". $row["credits"] . "</td>";
                echo "<td>". $row["message"] . "</td>";                 
                echo "<td>". $row["formattedProposedDate"]. "</td>";
                echo "<td>". $row["formattedCreated"]. "</td>";
                if ($row['requesteeAgreed'] == 0){
                echo '<td> 
                <form action="agreeRequest.php" method="post" style="display:inline;">
            <input type="hidden" name="requestbox_id" value="' . $row['requestbox_id'] . '">
            <input type="hidden" name="agreeType" value="requestee">
            <button class="button" type="submit">Agree</button>
            </form> </td>';            
            } else { echo '<td> Agreed </td>' ;}
            echo "</tr>";}
        } else {
            echo "<h3>"."No Messages Found"."</h3>";
                  }
          $getRequestsInstmt->close();
          
          ?>
        </table>
      </div>
      <div id="sendMessage">
        <h3 class="currentMailbox">Send a Request</h3>
        <form action="requestSend.php" method="post" id="messageForm">
          <div class="form-card">
          <div class="form-section">
          <label for="user">To </label><br>
          <input class="form-item" type="text" id="user" name="user" required><br>
          </div>
          <div class="form-section">
          <label for="subject">Skill Name:</label><br>
          <input class="form-item" type="text" id="skillName" name="SkillName" required><br>
          </div>
          <div class="form-section">
                  <label for="creditsOffered"> How Many Credits?</label>
            <input class="form-item" type="number" id="creditsOffered" name="creditsOffered" min="1" max="<?php echo $userCredits ?>" required><br>
          <div class="form-section">
          <label for="message">Message:</label><span id="charNum"></span>
          <br>
          <textarea id="message" name="message" rows="4" cols="50" maxlength="255" onkeyup="limitText(this,255)" required></textarea>
          <br>
          </div>
          <div class="form-section">
            <label for="proposedDateTime"> Proposed Date and Time:</label><br>
            <input class="form-item" type="datetime-local" id="proposedDateTime" name="proposedDateTime" required><br>
            
          </div><br>
          <input id="submitButtons" class="button" type="submit" value="Send" href="requestSend.php"> 
          <input id="submitButtons" class="button" type="reset" value="Clear">
          </div>
      </div>
                </div>
      <div id="outbox">
        <h3 class="currentMailbox">Outbox</h3>
        <table id="outboxTable">
          <tr>
            <th>To</th>
            <th>Skill Name</th>   
            <th>Credits Offered</th>         
            <th>Message</th>
            <th>Proposed Date and Time</th>
            <th>Date Sent</th>
            <th>Agree to Request</th>
          </tr>
         <?php
          $getRequestsOutStmt = $conn->prepare("SELECT 
          userdata.firstName AS requesteeFirstName,
          userdata.lastName AS requesteeLastName,
          user_requestbox.requestbox_id,
           requesterAgreed, 
           skillName, 
           requestee, 
           message, 
           requestbox.credits, 
           DATE_FORMAT(proposedDate, '%T %d/%m/%Y') AS formattedProposedDate, 
           DATE_FORMAT(created,'%T %d/%m/%Y') AS formattedCreated 
           FROM user_requestbox 
           INNER JOIN requestBox ON requestBox.id = user_requestbox.requestbox_id 
           INNER JOIN userdata ON userdata.id = user_requestbox.user
           WHERE user_requestbox.user =? AND user_requestbox.requestBoxType = 'Out' 
           ORDER BY created DESC;");
          $getRequestsOutStmt->bind_param("i", $id);
          $getRequestsOutStmt->execute();
          $result = $getRequestsOutStmt->get_result();
           if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>". $row["requesteeFirstName"] . $row["requesteeLastName"] . "</td>";
                echo "<td>". $row["skillName"] . "</td>";
                echo "<td>". $row["credits"] . "</td>";
                echo "<td>". $row["message"] . "</td>"; 
                echo "<td>". $row["formattedProposedDate"]. "</td>";
                echo "<td>". $row["formattedCreated"]. "</td>";
               if ($row['requesterAgreed'] == 0){
                echo '<td> 
                <form action="agreeRequest.php" method="post" style="display:inline;">
            <input type="hidden" name="requestbox_id" value="' . $row['requestbox_id'] . '">
            <input type="hidden" name="agreeType" value="requester">
            <button class="button" type="submit">Agree</button>
            </form> </td>';            
            } else { echo '<td> Agreed </td>' ;}
            echo "</tr>";}
        } else {
            echo "<h3>"."No Messages Found"."</h3>";
                  }
          $getRequestsOutStmt->close(); 
          
          ?>
        </table>
      </div>

    </div>

  </main>
