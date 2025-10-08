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
// Fetch the user's email
$getEmailstmt = $conn->prepare('SELECT email FROM userdata WHERE id=?');
$getEmailstmt->bind_param('i', $id);
$getEmailstmt->execute();
$email = $getEmailstmt->get_result()->fetch_assoc()['email'];
$getEmailstmt->close();

// Fetch the user's first name
$getfirstNamestmt = $conn->prepare('SELECT firstName FROM userdata WHERE id=?');
$getfirstNamestmt->bind_param('i', $id);
$getfirstNamestmt->execute();
$firstName = $getfirstNamestmt->get_result()->fetch_assoc()['firstName'];
$getfirstNamestmt->close();

// Fetch the user's last name
$getlastNamestmt = $conn->prepare('SELECT lastName FROM userdata WHERE id=?');
$getlastNamestmt->bind_param('i', $id);
$getlastNamestmt->execute();
$lastName = $getlastNamestmt->get_result()->fetch_assoc()['lastName'];
$getlastNamestmt->close();

// Fetch the user's profile image and name for alt text
$getUserImageStmt = $conn->prepare('SELECT imagePath FROM userdata WHERE id=?');
$getUserImageStmt->bind_param('i', $id);
$getUserImageStmt->execute();
$imagePath = $getUserImageStmt->get_result()->fetch_assoc()['imagePath'];
$getUserImageStmt->close();

$getUserImageAltStmt = $conn->prepare('SELECT imageName FROM userdata WHERE id=?');
$getUserImageAltStmt->bind_param('i', $id);
$getUserImageAltStmt->execute();
$imageAlt = $getUserImageAltStmt->get_result()->fetch_assoc()['imageName'];
$getUserImageAltStmt->close();

// Fetch the user's academic year
$getUserYearStmt = $conn->prepare('SELECT academicYear FROM userdata WHERE id=?');
$getUserYearStmt->bind_param('i', $id);
$getUserYearStmt->execute();
$userYear = $getUserYearStmt->get_result()->fetch_assoc()['academicYear'];
$getUserYearStmt->close();

// Fetch the user's FussCredits
$getUserCreditStmt = $conn->prepare('SELECT credits FROM userdata WHERE id=?');
$getUserCreditStmt->bind_param('i', $id);
$getUserCreditStmt->execute();
$userCredits = $getUserCreditStmt->get_result()->fetch_assoc()['credits'];
$getUserCreditStmt->close();

// Fetch the User's College
$getUserCollegeStmt = $conn->prepare('SELECT college FROM userdata WHERE id=?');
$getUserCollegeStmt->bind_param('i', $id);
$getUserCollegeStmt->execute();
$userCollege = $getUserCollegeStmt->get_result()->fetch_assoc()['college'];
$getUserCollegeStmt->close();

// Fetch the User's Bio
$getUserBioStmt = $conn->prepare('SELECT bio FROM userdata WHERE id=?');
$getUserBioStmt->bind_param('i', $id);
$getUserBioStmt->execute();
$userBio = $getUserBioStmt->get_result()->fetch_assoc()['bio'];
$getUserBioStmt->close();

?>

<!DOCTYPE html>
<html lang="en-AU">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="studentProfileEdit.css">
    <meta name="author" content="Jayden">
    <script src="./editProfile.js"></script>
    <title>FUSS Edit Your Profile Page</title>
</head>

<body>
    <div id="topBanner">
        <div id="flindersLogo">
            <img id="imgLogo" src="./images/Logo_Flinders_white.png" alt="Logo for Flinders University"
                id="flindersLogo">
        </div>
        <div id="title">
            <header>
                <h1>Flinders University Skill Share</h1>
            </header>
        </div>
        <div id="UserDetails">
            <h4 id="credits" class="profileItem"> FussCredits: <?php echo $userCredits ?></h4>
            <h4> <a id="profileLink" href="./studentProfile.php"> <?php echo "Hello, " . $firstName ?> </a></h4>

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
            <li> <a href="#Requests"> Make A Request</a> </li>
            <li> <a href="#ViewRequests">View My Requests</a> </li>
            <li> <a href="#BrowseRequests">Browse Requests</a> </li>
            <li> <a class="active" href="./studentProfile.php">My Profile</a> </li>
            <li> <a href="#History">Credit History</a> </li>
        </ul>
    </div>
    <main>
        <div id="mainContent">
            <h2 id="header">Your Profile </h2>
            <div class="profileContainer">
                <div class="profileDetails">


                    <img id="profilePic" src="<?php echo $imagePath ?>" alt="<?php echo $imageAlt ?>"> <br>

                    <form id="editPic" action="imageUpload.php" method="post" enctype="multipart/form-data">
                        <label for="imageUpload">
                            <h3>Select Image:</h3>
                        </label>
                        <input type="file" name="imageUpload" id="imageUpload" accept="image/*" required>

                        <input class="button" type="submit" value="Upload Image" name="submit">
                    </form>

                    <form action="" method="post" id="editProfileForm">
                        <div id="InfoSection">
                            <div id="personalInfo">
                                <div id="nameYearEdit">
                                    <h3 id="name" class="profileItem"> Name: <?php echo $firstName . " " . $lastName ?>
                                    </h3>
                                    <button type="button" class="collapsible" onclick="">Edit Name</button>
                                    <div class="content">

                                        <label for="firstName">First Name:</label>
                                        <input type="text" id="firstName" name="firstName"
                                            value="<?php echo htmlspecialchars($firstName); ?>" required><br><br>

                                        <label for="lastName">Last Name:</label>
                                        <input type="text" id="lastName" name="lastName"
                                            value="<?php echo htmlspecialchars($lastName); ?>" required><br><br>

                                        <button type="submit" class="button" name="updateName">Update Name</button>
                                    </div>
                                    <h3 id="adademicYear" class="profileItem"> Academic Year: <?php echo $userYear ?>
                                    </h3>
                                    <button type="button" class="collapsible" onclick="">Edit Academic Year</button>
                                    <div class="content">
                                        <label for="academicYear">Academic Year:</label>

                                        <input type="number" id="academicYear" name="academicYear"
                                            value="<?php echo htmlspecialchars($userYear); ?>" required><br> <br>

                                        <button type="submit" class="button" name="updateYear">Update Year</button>
                                    </div>
                                </div>
                                <div id="collegeBioEdit">
                                    <h3 id="college" class="profileItem"> College: <?php echo $userCollege ?></h3>

                                    <button type="button" class="collapsible" onclick="">Edit College</button>
                                    <div class="content">
                                        <label for="college">College:</label>

                                        <input type="text" id="college" name="college"
                                            value="<?php echo htmlspecialchars($userCollege); ?>" required><br> <br>

                                        <button type="submit" class="button" name="updateCollege">Update
                                            College</button>
                                    </div>
                                    <h3 id="BioTitle" class="profileItem"> Bio</h3>
                                    <p id="bioText" class="profileItem"> <?php echo $userBio ?> </p>
                                    <button type="button" class="collapsible" onclick="">Edit Bio</button>
                                    <div class="content">
                                        <label for="bio">Bio:</label><span id="charNum"></span>

                                        <textarea id="bio" name="bio" rows="4" cols="25" maxlength="255"
                                            onkeyup="limitText(this,255)"
                                            value="<?php echo htmlspecialchars($userBio); ?>" required></textarea>

                                        <button type="submit" class="button" name="updateBio">Update Bio</button>
                                    </div>
                                </div>
                            </div>

                            <div id="academicEdit">
                                <h3> Academic Skills Offered: </h3>

                                <?php
                                // Fetch the user's academic skills from the database
                                $getAcademicSkillsStmt = $conn->prepare('SELECT userSkills.skillName FROM userskills INNER JOIN skills ON userskills.skillName = skills.skillName WHERE skills.academic=1 AND userskills.id=?');
                                $getAcademicSkillsStmt->bind_param('i', $id);
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
                                <label for="academicSkillsOffered">Edit Academic Skills Offered:</label>
                                <select id="academicSkillsOffered" name="academicSkillsOffered" class="" onclick="">

                                    <!-- fetch all academic skills from skills table -->
                                </select>
                            </div>
                            <div id="otherEdit">
                                <h3> Other Skills Offered: </h3>
                                <?php
                                // Fetch the user's other skills from the database
                                $getOtherSkillsStmt = $conn->prepare('SELECT userSkills.skillName FROM userskills INNER JOIN skills ON userskills.skillName = skills.skillName WHERE skills.academic=0 AND userskills.id=?');
                                $getOtherSkillsStmt->bind_param('i', $id);
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
                                <label for="otherSkillsOffered">Edit Other Skills Offered:</label>
                                <select id="otherSkillsOffered" name="otherSkillsOffered" class="" onclick="">
                                    
                                    <!-- fetch all non academic skills from skills table -->
                                 </select>    
                            </div>

                            <div id="skillsEdit">
                                <h3> Skills Requested: </h3>
                                <?php
                                // Fetch the user's other skills from the database
                                $getRequestedSkillsStmt = $conn->prepare('SELECT skillName FROM userRequestedSkills WHERE id=?');
                                $getRequestedSkillsStmt->bind_param('i', $id);
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
                                <label for="requestedSKills">Edit Requested Skills:</label>
                                <select id="requestedSKills" name="requestedSKills" class="" onclick="">
                                    <!-- fetch all skills from skills table -->
                                </select>
                            </div>
                            
                        </div>
                    </form>
                </div>
                <div class="editProfile">
                    <button id="editProfileButton" type="submit" class="button"
                        onclick="location.href='./studentProfile.php';"> Confirm Edit</button>
                </div>
                
            </div>
        </div>

    </main>
    <script>
        var coll = document.getElementsByClassName("collapsible");
        var i;

        for (i = 0; i < coll.length; i++) {
            coll[i].addEventListener("click", function () {
                this.classList.toggle("active");
                var content = this.nextElementSibling;
                if (content.style.display === "block") {
                    content.style.display = "none";
                } else {
                    content.style.display = "block";
                }
            });
        }
    </script>
</body>

</html>