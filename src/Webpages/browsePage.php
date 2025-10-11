<?php
session_start();

if (!isset($_SESSION['id'])) {

  session_unset();
  session_destroy();

  header('location: ./loginPages/studentLoginPage.php');

} else {
  // session logged
}
//getting a user profile based on id passed in URL, if no id passed then show logged in user profile

$id = $_SESSION['id'];
$uid = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : $_SESSION['id'];

include '../inc/dbconn.inc.php';

// Fetch the logged user's first name
$getloggedFirstNamestmt = $conn->prepare('SELECT firstName FROM userdata WHERE id=?');
$getloggedFirstNamestmt->bind_param('i', $id);
$getloggedFirstNamestmt->execute();
$loggedFirstName = $getloggedFirstNamestmt->get_result()->fetch_assoc()['firstName'];
$getloggedFirstNamestmt->close();

// Fetch the logged in user's FussCredits
$getUserCreditStmt = $conn->prepare('SELECT credits FROM userdata WHERE id=?');
$getUserCreditStmt->bind_param('i', $id);
$getUserCreditStmt->execute();
$loggedUserCredits = $getUserCreditStmt->get_result()->fetch_assoc()['credits'];
$getUserCreditStmt->close();

?>

<!DOCTYPE html>
<html lang="en-AU">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="browsePage.css">
    <script src="browsePage.js"></script>
  <meta name="author" content="Jayden">

  <title>FUSS Browse Offered Skills</title>
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
          <?php echo "Hello, " . $loggedFirstName . "<br>" . "You have " . $loggedUserCredits . " Credits!" ?> </a></h4>

    </div>
    <div id="logoutButton">
      <input id="logButton" class="button" type="button" onclick="location.href='./loginPages/logout.php';"
        value="Logout" />
    </div>
  </div>

  <div id="sideBar">
    <ul class="sidebar">
      <li> <a href="./student-homepage.html">Home</a> </li>
      <li> <a href="./inbox.php"> Inbox</a> </li>
      <li> <a class="active" href="./browsePage"> Browse Offered Skills</a> </li>
      <li> <a href="#Requests"> Make A Request</a> </li>
      <li> <a href="#ViewRequests">View My Requests</a> </li>
      <li> <a href="#BrowseRequests">Browse Requests</a> </li>
      <li> <a href="./studentProfile.php">My Profile</a> </li>
      <li> <a href="#History">Credit History</a> </li>
    </ul>
  </div>

<main>
    <h2>Browse Other Students Offered Skills</h2>
    <input type="text" id="searchInput" onkeyup="searchFunction()" placeholder="Search for skills..">
    <table id="skillsTable">
        <tr>
            <th>Skill Name</th>
            <th>Offered By</th>
            <th>Skill Type</th>
            <th>Offerer's Availability </th>
            <th>Contact</th>
        </tr>
        <?php
        // Fetch all skills along with the user who offers them
        $getSkillsStmt = $conn->prepare('
            SELECT userdata.firstName,userdata.availability, userdata.lastName, skills.skillName, skills.academic, userdata.id FROM skills
            JOIN userskills ON skills.skillName = userskills.skillName
            JOIN userdata ON userskills.id = userdata.id WHERE userdata.id != ? ORDER BY skills.skillName ASC
            
        ');
        $getSkillsStmt->bind_param('i', $id);
        $getSkillsStmt->execute();
        $skillsResult = $getSkillsStmt->get_result();
    
        while ($skill = $skillsResult->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($skill['skillName']) . '</td>';
            echo '<td>' . htmlspecialchars($skill['firstName'] . ' ' . $skill['lastName']) . '</td>';
            if ($skill['academic'] == '1') {
                echo '<td>'. 'Academic' . '</td>';
            } else {
                echo '<td>'. 'Non-Academic' . '</td>';
            }
            echo '<td>'. $skill['availability'] . '</td>';
            echo '<td><a href="./studentProfile.php?id=' . $skill['id'] . '">View Profile</a></td>';
            echo '</tr>';
        }
    
        $getSkillsStmt->close();
        $conn->close();
        ?>

    </table>
</main>