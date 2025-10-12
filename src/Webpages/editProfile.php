<?php


session_start();

if (!isset($_SESSION['id'])) {

    session_unset();
    session_destroy();

    header('location: ./loginPages/studentLoginPage.php');

} else {
    // session logged
}

$uid = $_SESSION['id'];

include '../inc/dbconn.inc.php';


$checkIfAdmin = $conn->prepare('SELECT Admin FROM userdata WHERE id=?');
$checkIfAdmin->bind_param('i', $uid);
$checkIfAdmin->execute();
$checkIfAdmin = $checkIfAdmin->get_result();
$isAdmin = 0;
if ($checkIfAdmin->num_rows > 0) {
    $adminRow = $checkIfAdmin->fetch_assoc();
    if (isset($adminRow['Admin']) && $adminRow['Admin'] == 1) {
        $isAdmin = 1;

    }
}
$checkIfAdmin->close();

// Decide which user profile to edit
if ($isAdmin == 1 && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
} else {
    $id = $uid;
}


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

// Fetch the logged user's first name
$getloggedFirstNamestmt = $conn->prepare('SELECT firstName FROM userdata WHERE id=?');
$getloggedFirstNamestmt->bind_param('i', $uid);
$getloggedFirstNamestmt->execute();
$loggedFirstName = $getloggedFirstNamestmt->get_result()->fetch_assoc()['firstName'];
$getloggedFirstNamestmt->close();

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

//Fetch User's Availablity
$getUserAvailabilityStmt = $conn->prepare('SELECT availability FROM userdata WHERE id=?');
$getUserAvailabilityStmt->bind_param('i', $id);
$getUserAvailabilityStmt->execute();
$userAvailability = $getUserAvailabilityStmt->get_result()->fetch_assoc()['availability'];
$getUserAvailabilityStmt->close();

// Fetch the user's FussCredits
$getUserCreditStmt = $conn->prepare('SELECT credits FROM userdata WHERE id=?');
$getUserCreditStmt->bind_param('i', $id);
$getUserCreditStmt->execute();
$userCredits = $getUserCreditStmt->get_result()->fetch_assoc()['credits'];
$getUserCreditStmt->close();

// Fetch the logged in user's FussCredits
$getUserCreditStmt = $conn->prepare('SELECT credits FROM userdata WHERE id=?');
$getUserCreditStmt->bind_param('i', $uid);
$getUserCreditStmt->execute();
$loggedUserCredits = $getUserCreditStmt->get_result()->fetch_assoc()['credits'];
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
            <h4> <a id="profileLink" href="./studentProfile.php">
                    <?php echo "Hello, " . $loggedFirstName . "<br>" . "You have " . $loggedUserCredits . " Credits!" ?>
                </a></h4>

        </div>
        <div id="logoutButton">
            <input id="logButton" class="button" type="button" onclick="location.href='./loginPages/logout.php';"
                value="Logout" />
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

                    <form id="editPic" action="imageUpload.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
                        <label for="imageUpload">
                            <h3>Select Image:</h3>
                        </label>
                        <input type="file" name="imageUpload" id="imageUpload" accept="image/*" required>

                        <input class="button" type="submit" value="Upload Image" name="submit" id="picUpload">
                    </form>

                    <div id="InfoSection">
                        <div id="personalInfo">
                            <div id="nameYearEdit">

                                <form action="updateProfile.php?id=<?php echo $id; ?>" method="post" id="editNameForm">
                                    <h3 id="name" class="profileItem"> Name: <?php echo $firstName . " " . $lastName ?>
                                    </h3>
                                    <button type="button" class="collapsible" onclick="">Edit Name</button>
                                    <div class="content" style="display:<?php echo ($isAdmin == 1) ? 'block' : 'none'; ?>">

                                        <label for="firstName">First Name:</label>
                                        <input type="text" id="firstName" name="firstName"
                                            value="<?php echo htmlspecialchars($firstName); ?>" required><br><br>

                                        <label for="lastName">Last Name:</label>
                                        <input type="text" id="lastName" name="lastName"
                                            value="<?php echo htmlspecialchars($lastName); ?>" required><br><br>

                                        <button type="submit" class="button" name="updateName"
                                            href="updateProfile.php">Update Name</button>
                                    </div>
                                </form>
                                <form action="updateProfile.php?id=<?php echo $id; ?>" method="post" id="editYearForm">
                                    <h3 id="adademicYear" class="profileItem"> Academic Year: <?php echo $userYear ?>
                                    </h3>
                                    <button type="button" class="collapsible" onclick="">Edit Academic Year</button>
                                    <div class="content" style="display:<?php echo ($isAdmin == 1) ? 'block' : 'none'; ?>">
                                        <label for="academicYear">Academic Year:</label>

                                        <input type="number" id="academicYear" name="academicYear" min="1" max="10"
                                            value="<?php echo htmlspecialchars($userYear); ?>" required><br> <br>

                                        <button href="updateProfile.php" type="submit" class="button"
                                            name="updateYear">Update Year</button>
                                    </div>
                                </form>
                                <form action="updateProfile.php" method="post" id="editAvailabilityForm">
                                    <h3 id="availability" class="profileItem"> General Availability: <?php echo $userAvailability ?>
                                    </h3>
                                    <button type="button" class="collapsible" onclick="">Edit General Availability</button>
                                    <div class="content">
                                        <label for="academicYear">General Availability:</label>

                                        <textarea id="availability" name="availability" rows="4" cols="25" maxlength="255"
                                            onkeyup="limitText(this,255)"
                                            value="<?php echo htmlspecialchars($userAvailability); ?>" required></textarea>

                                        <button href="updateProfile.php" type="submit" class="button"
                                            name="updateAvailability">Update Availability</button>
                                    </div>
                                </form>
                            </div>
                            <div id="editAvailability">
                                <form action="updateProfile.php" method="post" id="editAvailabilityForm">
                                    <h3 id="availability" class="profileItem"> General Availability: <?php echo $userAvailability ?>
                                    </h3>
                                    <button type="button" class="collapsible" onclick="">Edit General Availability</button>
                                    <div class="content">
                                        <label for="academicYear">General Availability:</label>

                                        <textarea id="availability" name="availability" rows="4" cols="25" maxlength="255"
                                            onkeyup="limitText(this,255)"
                                            value="<?php echo htmlspecialchars($userAvailability); ?>" required></textarea>

                                        <button href="updateProfile.php" type="submit" class="button"
                                            name="updateAvailability">Update Availability</button>
                                    </div>
                                </form>
                            </div>
                            
                            <div id="collegeBioEdit">
                                <form action="updateProfile.php?id=<?php echo $id; ?>" method="post"
                                    id="editCollegeForm">
                                    <h3 id="college" class="profileItem"> College: <?php echo $userCollege ?></h3>

                                    <button type="button" class="collapsible" onclick="" >Edit College</button>
                                    <div class="content" style="display:<?php echo ($isAdmin == 1) ? 'block' : 'none'; ?>">
                                        <label for="college">College:</label>

                                        <input type="text" id="college" name="college"
                                            value="<?php echo htmlspecialchars($userCollege); ?>" required><br> <br>

                                        <button href="updateProfile.php" type="submit" class="button"
                                            name="updateCollege">Update
                                            College</button>
                                    </div>
                                </form>
                                <form action="updateProfile.php?id=<?php echo $id; ?>" method="post" id="editBioForm">
                                    <h3 id="BioTitle" class="profileItem"> Bio</h3>
                                    <p id="bioText" class="profileItem"> <?php echo $userBio ?> </p>
                                    <button type="button" class="collapsible" onclick="" >Edit Bio</button>
                                    <div class="content" style="display:<?php echo ($isAdmin == 1) ? 'block' : 'none'; ?>">
                                        <label for="bio">Bio:</label><span id="charNum"></span>

                                        <textarea id="bio" name="bio" rows="4" cols="25" maxlength="255"
                                            onkeyup="limitText(this,255)"
                                            value="<?php echo htmlspecialchars($userBio); ?>" required></textarea>

                                        <button href="updateProfile.php" type="submit" class="button"
                                            name="updateBio">Update Bio</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div id="swapButtons">
                            <h2> <Button onclick="showAcademic()" class="button">Academic Skills</Button> <Button
                                    class="button" onclick="showOther()">Other Skills</Button> <Button
                                    onclick="showRequested()" class="button">Requested Skills</Button> </h2>
                        </div>
                        <div id="academicEdit">
                            <form action="updateProfile.php?id=<?php echo $id; ?>" method="post" id="academicSkillsForm"
                                name="academicSkillToAddForm">
                                <h3> Academic Skills Offered: </h3>

                                <?php
                                $userAcademicSkills = [];
                                // Fetch the user's academic skills from the database
                                $getAcademicSkillsStmt = $conn->prepare('SELECT userSkills.skillName FROM userskills INNER JOIN skills ON userskills.skillName = skills.skillName WHERE skills.academic=1 AND userskills.id=?');
                                $getAcademicSkillsStmt->bind_param('i', $id);
                                $getAcademicSkillsStmt->execute();
                                $academicSkills = $getAcademicSkillsStmt->get_result();
                                if ($academicSkills->num_rows > 0) {
                                    echo "<ul>";                                    
                                    while ($row = $academicSkills->fetch_assoc()) {
                                        echo "<li>" . htmlspecialchars($row['skillName']) . "</li>";
                                        $userAcademicSkills[] = $row['skillName'];
                                    }
                                    echo "</ul>";
                                } else {
                                    echo "<p>No academic skills listed.</p>";
                                }


                                $getAcademicSkillsStmt->close();
                                ?>

                                <label for="academicSkillsOffered">Add Academic Skills Offered:</label>
                                <select id="academicSkillsOffered" name="academicSkillsOffered" class="addList"
                                    onclick="">

                                    <!-- fetch all academic skills from skills table -->
                                    <?php
                                    $getAcademicListStmt = $conn->prepare('SELECT skillName FROM skills WHERE academic =1 ORDER BY skillName ASC');
                                    $getAcademicListStmt->execute();
                                    $academicList = $getAcademicListStmt->get_result();
                                    $hasSkill = true;
                                    if ($academicList->num_rows > 0) {
                                        while ($row = $academicList->fetch_assoc()) {
                                            if (!in_array($row['skillName'], $userAcademicSkills)) {
                                                echo "<option value='" . htmlspecialchars($row['skillName']) . "'>" . htmlspecialchars($row['skillName']) . "</option>";
                                                $hasSkill = false;
                                            }
                                        }
                                    } else {
                                        echo "<option value=''>No skills available</option>";
                                    }

                                    $getAcademicListStmt->close();


                                    ?>
                                </select>

                                <button type="submit" class="button" name="addAcademicSkills">Add Academic
                                    Skills</button>
                            </form>
                            <form action="updateProfile.php?id=<?php echo $id; ?>" method="post"
                                id="removeAcademicSkillsForm">

                                <br>
                                <label for="academicSkillToRemove">Remove Academic Skill Offered:</label>
                                <select id="academicSkillToRemove" name="academicSkillToRemove" class="removeList"
                                    onclick="">
                                    <?php
                                    if (!empty($userAcademicSkills)) {
                                        foreach ($userAcademicSkills as $academicSkill) {
                                            echo "<option value='" . htmlspecialchars($academicSkill) . "'>" . htmlspecialchars($academicSkill) . "</option>";
                                        }
                                    } else {
                                        echo "<option value=''>No skills to remove</option>";
                                    }
                                    ?>
                                </select>

                                <button type="submit" class="button" name="removeAcademicSkills">Remove Academic
                                    Skill</button>
                            </form>
                        </div>

                        <div id="otherEdit">
                            <form action="updateProfile.php?id=<?php echo $id; ?>" method="post" id="otherSkillsForm">
                                <h3> Other Skills Offered: </h3>
                                <?php
                                $userOtherSkills = [];
                                // Fetch the user's other skills from the database
                                $getOtherSkillsStmt = $conn->prepare('SELECT userSkills.skillName FROM userskills INNER JOIN skills ON userskills.skillName = skills.skillName WHERE skills.academic=0 AND userskills.id=?');
                                $getOtherSkillsStmt->bind_param('i', $id);
                                $getOtherSkillsStmt->execute();
                                $otherSkills = $getOtherSkillsStmt->get_result();
                                if ($otherSkills->num_rows > 0) {
                                    echo "<ul>";                                    
                                    while ($row = $otherSkills->fetch_assoc()) {
                                        echo "<li>" . htmlspecialchars($row['skillName']) . "</li>";
                                        $userOtherSkills[] = $row['skillName'];
                                    }
                                    echo "</ul>";
                                } else {
                                    echo "<p>No Other skills Offered.</p>";
                                }
                                $getOtherSkillsStmt->close();
                                ?>

                                <label for="otherSkillsOffered">Add Other Skills Offered:</label>
                                <select id="otherSkillsOffered" name="otherSkillsOffered" class="addList" onclick="">

                                    <!-- fetch all non academic skills from skills table -->
                                    <?php
                                    $getOtherListStmt = $conn->prepare('SELECT skillName FROM skills WHERE academic =0 ORDER BY skillName ASC');
                                    $getOtherListStmt->execute();
                                    $OtherList = $getOtherListStmt->get_result();
                                    $hasSkill = true;
                                    if ($OtherList->num_rows > 0) {
                                        while ($row = $OtherList->fetch_assoc()) {
                                            if (!in_array($row['skillName'], $userOtherSkills)) {
                                                echo "<option value='" . htmlspecialchars($row['skillName']) . "'>" . htmlspecialchars($row['skillName']) . "</option>";
                                                $hasSkill = false;
                                            }
                                        }
                                    } else {
                                        echo "<option value=''>No skills available</option>";
                                    }
                                    $getOtherListStmt->close()
                                        ?>
                                </select>
                                <button type="submit" class="button" name="updateOtherSkills">Update Other
                                    Skills</button>

                            </form>
                            <form action="updateProfile.php?id=<?php echo $id; ?>" method="post"
                                id="removeOtherSkillsForm">

                                <br>
                                <label for="otherSkillToRemove">Remove Other Skill Offered:</label>
                                <select id="otherSkillToRemove" name="otherSkillToRemove" class="removeList" onclick="">
                                    <?php
                                    if (!empty($userOtherSkills)) {
                                        foreach ($userOtherSkills as $otherSkill) {
                                            echo "<option value='" . htmlspecialchars($otherSkill) . "'>" . htmlspecialchars($otherSkill) . "</option>";
                                        }
                                    } else {
                                        echo "<option value=''>No skills to remove</option>";
                                    }
                                    ?>
                                </select>

                                <button type="submit" class="button" name="removeOtherSkills">Remove Other
                                    Skill</button>
                            </form>
                        </div>

                        <div id="requestedEdit">
                            <form action="updateProfile.php?id=<?php echo $id; ?>" method="post"
                                id="requestedSkillsForm">
                                <h3> Skills Requested: </h3>
                                <?php
                                $userRequestedSkills = [];
                                // Fetch the user's requested skills from the database
                                $getRequestedSkillsStmt = $conn->prepare('SELECT skillName FROM userRequestedSkills WHERE id=?');
                                $getRequestedSkillsStmt->bind_param('i', $id);
                                $getRequestedSkillsStmt->execute();
                                $requestedSkills = $getRequestedSkillsStmt->get_result();

                                if ($requestedSkills->num_rows > 0) {
                                    echo "<ul>";                                  
                                    while ($row = $requestedSkills->fetch_assoc()) {
                                        echo "<li>" . htmlspecialchars($row['skillName']) . "</li>";
                                        $userRequestedSkills[] = $row['skillName'];
                                    }
                                    echo "</ul>";
                                } else {
                                    echo "<p>No Skills Requested.</p>";
                                }

                                $getRequestedSkillsStmt->close();
                                ?>

                                <label for="requestedSKills">Add Requested Skills:</label>
                                <select id="requestedSKills" name="requestedSKills" class="addList" onclick="">
                                    <!-- fetch all skills from skills table -->
                                    <?php
                                    $getAllSkillsStmt = $conn->prepare('SELECT skillName FROM skills ORDER BY skillName ASC');
                                    $getAllSkillsStmt->execute();
                                    $AllSkills = $getAllSkillsStmt->get_result();
                                    $hasSkill = true;
                                    if ($AllSkills->num_rows > 0) {
                                        while ($row = $AllSkills->fetch_assoc()) {
                                            if (!in_array($row['skillName'], $userRequestedSkills)) {
                                                echo "<option value='" . htmlspecialchars($row['skillName']) . "'>" . htmlspecialchars($row['skillName']) . "</option>";
                                                $hasSkill = false;
                                            }
                                        }
                                    } else {
                                        echo "<option value=''>No skills available</option>";
                                    }
                                    $getAllSkillsStmt->close();

                                    ?>
                                </select>
                                <button type="submit" class="button" name="updateRequestedSkills">Update Requested
                                    Skills</button>

                            </form>
                            <form action="updateProfile.php?id=<?php echo $id; ?>" method="post"
                                id="removeRequestedSkillsForm">

                                <br>
                                <label for="requestedSkillToRemove">Remove Requested Skill:</label>
                                <select id="requestedSkillToRemove" name="requestedSkillToRemove" class="removeList"
                                    onclick="">
                                    <?php
                                    if (!empty($userRequestedSkills)) {
                                        foreach ($userRequestedSkills as $requestedSkill) {
                                            echo "<option value='" . htmlspecialchars($requestedSkill) . "'>" . htmlspecialchars($requestedSkill) . "</option>";
                                        }
                                    } else {
                                        echo "<option value=''>No skills to remove</option>";
                                    }
                                    ?>
                                </select>

                                <button type="submit" class="button" name="removeRequestedSkills">Remove Requested
                                    Skill</button>
                            </form>

                        </div>

                    </div>

                </div>
               <div class="editProfile">
                    <?php                 

                    if (($isAdmin == 1 || $uid == $id))  {
                        echo '<div class="editProfile"><button id="editProfileButton" class="button" onclick="location.href=\'./studentProfile.php?id=' . $id . '\';">Back to Profile</button></div>';
                    }
                    ?> 
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