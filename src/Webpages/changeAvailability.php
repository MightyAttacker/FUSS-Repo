<?php
session_start();
include '../inc/dbconn.inc.php';
$id = $_SESSION["id"];
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
<html lang="en">

<head>
    <?php

    require_once "../inc/dbconn.inc.php";
    ?>
    <meta charset="UTF-8">
    <meta name="author" content="Thomas Wachmer">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
    <?php echo "<div id=\"data\" class='hidden'>" . $id . "</div>"; ?>

    <script type="module" src="../Scripts/account-page-script.js" defer></script>
    <script type="module" src="../Scripts/account-page-availability.js" defer></script>
    <script type="module" src="../Scripts/account-page-submit.js" defer></script>
    <link rel="stylesheet" href="../Styles/account-page-styles.css">
    <link rel="icon" href="data:,">

</head>

<body>
<div id="banner">
    <div id="flindersLogo">
        <img src="images/Logo_Flinders_white.png" alt="Logo for Flinders University" id="flindersLogo">
    </div>
    <div id="header">

        <h1>Flinders University Skill Share</h1>

    </div>
    <div id="logoutButton">
        <input id="logButton" class="button" type="button"
               onclick="location.href='../studentLoginPage/logout.php';" value="Logout"/>
    </div>
</div>
<div id="sidebar">
    <ul class="sidebar">
        <li> <a  href="./student-homepage.php">Home</a> </li>
            <li> <a href="./inbox.php"> Inbox</a> </li>
            <li> <a href="./browsePage.php"> Browse Offered Skills</a> </li>
            <li> <a href="./requests.php"> Make A Request</a> </li>
            <li> <a href="./myRequests.php">View My Requests</a> </li>
            <li> <a href="./PeerFeedback.php">Peer Reviews</a> </li>
            <li> <a href="./studentProfile.php">My Profile</a> </li>
            <li> <a class="active" href="./changeAvailability.php">Change Availability</a> </li>
            <li> <a href="./creditHistory.php">Credit History</a> </li>
            <?php if ($getUserAdmin == 1) echo '<li> <a href="./admin-pages/admin-dashboard.html">Admin Dashboard</a> </li>' ?>
    </ul>
</div>
<h2 id="title">Change availability</h2>
<main>
        <button
                name="availability"
                id="changeavailability"
                class="button">Change availability
        </button>

        <div id="availability-popup" class="popup hidden">
            <button name="by-day"
                    id="daily"
                    class="button popup">By Day
            </button>
            <br>
            <button name="by-week"
                    id="weekly"
                    class="button popup">By Week
            </button>
        </div>
    </div>


    <div id="availability">

    </div>
</main>
</body>

</html>