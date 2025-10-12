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


// Fetch the user's email
$getEmailstmt = $conn->prepare('SELECT email FROM userdata WHERE id=?');
$getEmailstmt->bind_param('i', $uid);
$getEmailstmt->execute();
$email = $getEmailstmt->get_result()->fetch_assoc()['email'];
$getEmailstmt->close();

// Fetch the user's first name
$getfirstNamestmt = $conn->prepare('SELECT firstName FROM userdata WHERE id=?');
$getfirstNamestmt->bind_param('i', $uid);
$getfirstNamestmt->execute();
$firstName = $getfirstNamestmt->get_result()->fetch_assoc()['firstName'];
$getfirstNamestmt->close();

// Fetch the logged user's first name
$getloggedFirstNamestmt = $conn->prepare('SELECT firstName FROM userdata WHERE id=?');
$getloggedFirstNamestmt->bind_param('i', $id);
$getloggedFirstNamestmt->execute();
$loggedFirstName = $getloggedFirstNamestmt->get_result()->fetch_assoc()['firstName'];
$getloggedFirstNamestmt->close();

// Fetch the user's last name
$getlastNamestmt = $conn->prepare('SELECT lastName FROM userdata WHERE id=?');
$getlastNamestmt->bind_param('i', $uid);
$getlastNamestmt->execute();
$lastName = $getlastNamestmt->get_result()->fetch_assoc()['lastName'];
$getlastNamestmt->close();

// Fetch the user's profile image and name for alt text
$getUserImageStmt = $conn->prepare('SELECT imagePath FROM userdata WHERE id=?');
$getUserImageStmt->bind_param('i', $uid);
$getUserImageStmt->execute();
$imagePath = $getUserImageStmt->get_result()->fetch_assoc()['imagePath'];
$getUserImageStmt->close();

$getUserImageAltStmt = $conn->prepare('SELECT imageName FROM userdata WHERE id=?');
$getUserImageAltStmt->bind_param('i', $uid);
$getUserImageAltStmt->execute();
$imageAlt = $getUserImageAltStmt->get_result()->fetch_assoc()['imageName'];
$getUserImageAltStmt->close();

// Fetch the user's academic year
$getUserYearStmt = $conn->prepare('SELECT academicYear FROM userdata WHERE id=?');
$getUserYearStmt->bind_param('i', $uid);
$getUserYearStmt->execute();
$userYear = $getUserYearStmt->get_result()->fetch_assoc()['academicYear'];
$getUserYearStmt->close();

// Fetch the user's FussCredits
$getUserCreditStmt = $conn->prepare('SELECT credits FROM userdata WHERE id=?');
$getUserCreditStmt->bind_param('i', $uid);
$getUserCreditStmt->execute();
$userCredits = $getUserCreditStmt->get_result()->fetch_assoc()['credits'];
$getUserCreditStmt->close();

// Fetch the logged in user's FussCredits
$getUserCreditStmt = $conn->prepare('SELECT credits FROM userdata WHERE id=?');
$getUserCreditStmt->bind_param('i', $id);
$getUserCreditStmt->execute();
$loggedUserCredits = $getUserCreditStmt->get_result()->fetch_assoc()['credits'];
$getUserCreditStmt->close();

// Fetch the User's College
$getUserCollegeStmt = $conn->prepare('SELECT college FROM userdata WHERE id=?');
$getUserCollegeStmt->bind_param('i', $uid);
$getUserCollegeStmt->execute();
$userCollege = $getUserCollegeStmt->get_result()->fetch_assoc()['college'];
$getUserCollegeStmt->close();

// Fetch the User's Bio
$getUserBioStmt = $conn->prepare('SELECT bio FROM userdata WHERE id=?');
$getUserBioStmt->bind_param('i', $uid);
$getUserBioStmt->execute();
$userBio = $getUserBioStmt->get_result()->fetch_assoc()['bio'];
$getUserBioStmt->close();

//Fetch User's Availablity
$getUserAvailabilityStmt = $conn->prepare('SELECT availability FROM userdata WHERE id=?');
$getUserAvailabilityStmt->bind_param('i', $uid);
$getUserAvailabilityStmt->execute();
$userAvailability = $getUserAvailabilityStmt->get_result()->fetch_assoc()['availability'];
$getUserAvailabilityStmt->close();

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
  <link rel="stylesheet" href="studentProfile.css">
  <meta name="author" content="Jayden">

  <title>FUSS Your Profile Page</title>
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
            <li> <a href="./student-homepage.php">Home</a> </li>
            <li> <a  href="./inbox.php"> Inbox</a> </li>
            <li> <a href="./browsePage.php"> Browse Offered Skills</a> </li>
            <li> <a href="#Requests"> Make A Request</a> </li>
            <li> <a href="#ViewRequests">View My Requests</a> </li>
            <li> <a href="#BrowseRequests">Browse Requests</a> </li>
            <li> <a class="active" href="./studentProfile.php">My Profile</a> </li>
            <li> <a href="#History">Credit History</a> </li>
            <?php if ($getUserAdmin == 1) echo '<li> <a href="./admin-pages/admin-dashbaord.html">Admin Dashboard</a> </li>' ?>
    </ul>
  </div>
  <main>
    <div id="mainContent">
      <h2 id="header"><?php echo $firstName?>'s Profile </h2>
      <div class="profileContainer">
        <div class="profileDetails">
            <img id="profilePic" src="<?php echo $imagePath ?>" alt="<?php echo $imageAlt ?>"> <br>
            <div id="pesonalInfo">
            
            <h3 id="name" class="profileItem"> Name: <?php echo $firstName. " ". $lastName ?> </h3> 
            <h3 id="adademicYear" class="profileItem"> Academic Year: <?php echo $userYear ?> </h3>
            <h3 id="availability" class="profileItem"> General Availability: <?php echo $userAvailability ?> </h3>
            <h3 id="credits" class="profileItem"> FussCredits: <?php echo $userCredits ?></h3>
            <h3 id="college" class="profileItem"> College: <?php echo $userCollege ?></h3> 
            <h3 id="BioTitle" class="profileItem"> Bio</h3>
            <p id="bioText" class="profileItem"> <?php echo $userBio ?> </p>
            </div>
         
        </div>

        <div id="skillsList">
          <h3> Academic Skills Offered: </h3>

          <?php
          // Fetch the user's academic skills from the database
          $getAcademicSkillsStmt = $conn->prepare('SELECT userSkills.skillName FROM userskills INNER JOIN skills ON userskills.skillName = skills.skillName WHERE skills.academic=1 AND userskills.id=?');
          $getAcademicSkillsStmt->bind_param('i', $uid);
          $getAcademicSkillsStmt->execute();
          $academicSkills = $getAcademicSkillsStmt->get_result();
          if ($academicSkills->num_rows > 0) {
            echo "<ul>";
            while ($row = $academicSkills->fetch_assoc()) {
              echo "<li>" . htmlspecialchars($row['skillName']) . "</li>";
            }
            echo "</ul>";
          } else {
            echo "<p>No academic skills listed.</p>";
          }
          $getAcademicSkillsStmt->close();
          ?>

          <h3> Other Skills Offered: </h3>

          <?php
          // Fetch the user's other skills from the database
          $getOtherSkillsStmt = $conn->prepare('SELECT userSkills.skillName FROM userskills INNER JOIN skills ON userskills.skillName = skills.skillName WHERE skills.academic=0 AND userskills.id=?');
          $getOtherSkillsStmt->bind_param('i', $uid);
          $getOtherSkillsStmt->execute();
          $otherSkills = $getOtherSkillsStmt->get_result();
          if ($otherSkills->num_rows > 0) {
            echo "<ul>";
            while ($row = $otherSkills->fetch_assoc()) {
              echo "<li>" . htmlspecialchars($row['skillName']) . "</li>";
            }
            echo "</ul>";
          } else {
            echo "<p>No Other skills Offered.</p>";
          }
          $getOtherSkillsStmt->close();
          ?>

          <h3> Skills Requested: </h3>
          <?php
          // Fetch the user's other skills from the database
          $getRequestedSkillsStmt = $conn->prepare('SELECT skillName FROM userRequestedSkills WHERE id=?');
          $getRequestedSkillsStmt->bind_param('i', $uid);
          $getRequestedSkillsStmt->execute();
          $requestedSkills = $getRequestedSkillsStmt->get_result();
          if ($requestedSkills->num_rows > 0) {
            echo "<ul>";
            while ($row = $requestedSkills->fetch_assoc()) {
              echo "<li>" . htmlspecialchars($row['skillName']) . "</li>";
            }
            echo "</ul>";
          } else {
            echo "<p>No Skills Requested.</p>";
          }
          $getRequestedSkillsStmt->close();
          ?>
        </div>
      </div>
      <?php
            

      if (($uid == $id) || ($getUserAdmin == 1)) {
        echo '<div class="editProfile"><button id="editProfileButton" class="button" onclick="location.href=\'./editProfile.php?id=' . $uid . '\';">Edit Profile</button></div>';
      }
      ?>
    </div>
    </div>

  </main>