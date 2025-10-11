<?php
session_start();
include "../inc/dbconn.inc.php";


$id = $_SESSION["id"];

if (isset($_POST["updateName"])) {
    
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    // Prepare and execute the update query
    $updateNamestmt = $conn->prepare("UPDATE userdata SET firstName =?, lastName =?  WHERE id =?");
    $updateNamestmt->bind_param("ssi", $firstName,$lastName , $id);

    if ($updateNamestmt->execute()) {
        $_SESSION["success"] = "Name updated successfully.";
    } else {
        $_SESSION["error"] = "Failed to update name. Please try again.";
    }

    $updateNamestmt->close();
}    

if (isset($_POST["academicYear"])) {
    
    $newYear = $_POST["academicYear"];

    // Validate the academic year input
    if (!is_numeric($newYear) || $newYear < 1 || $newYear > 10) {
        $_SESSION["error"] = "Invalid academic year. Please enter a number between 1 and 10.";
        header("Location: editProfile.php");
        exit();
    }

    // Prepare and execute the update query
    $updateYearstmt = $conn->prepare("UPDATE userdata SET academicYear = ? WHERE id = ?");
    $updateYearstmt->bind_param("ii", $newYear, $id);

    if ($updateYearstmt->execute()) {
        $_SESSION["success"] = "Academic year updated successfully.";
    } else {
        $_SESSION["error"] = "Failed to update academic year. Please try again.";
    }

    $updateYearstmt->close();
}   

if (isset($_POST["updateCollege"])) {
    
    $newCollege = $_POST["college"];

    
    // Prepare and execute the update query
    $updateCollegestmt = $conn->prepare("UPDATE userdata SET college = ? WHERE id = ?");
    $updateCollegestmt->bind_param("si", $newCollege, $id);

    if ($updateCollegestmt->execute()) {
        $_SESSION["success"] = "College updated successfully.";
    } else {
        $_SESSION["error"] = "Failed to update College. Please try again.";
    }

    $updateCollegestmt->close();
}    
if (isset($_POST["updateBio"])) {
    
    $newBio = $_POST["bio"];

    
    // Prepare and execute the update query
    $updateBiostmt = $conn->prepare("UPDATE userdata SET bio = ? WHERE id = ?");
    $updateBiostmt->bind_param("si", $newBio, $id);

    if ($updateBiostmt->execute()) {
        $_SESSION["success"] = "Bio updated successfully.";
    } else {
        $_SESSION["error"] = "Failed to update bio. Please try again.";
    }

    $updateBiostmt->close();
}   

if (isset($_POST["addAcademicSkills"])) {
    
    $newAcademicSkill = $_POST["academicSkillsOffered"];

    
    // Prepare and execute the update query
    $updateAcademicSkillstmt = $conn->prepare("INSERT INTO userskills (id, skillName) VALUES (? , ?)");
    $updateAcademicSkillstmt->bind_param("is",  $id,$newAcademicSkill);
    
    if ($updateAcademicSkillstmt->execute()) {
        $_SESSION["success"] = "Skills updated successfully.";
    } else {
        $_SESSION["error"] = "Failed to update Skills. Please try again.";
    }

    $updateAcademicSkillstmt->close();
} 
if (isset($_POST["removeAcademicSkills"])) {
    
    $academicSKillToRemove = $_POST["academicSkillToRemove"];
    
    // Prepare and execute the update query
    $removeAcademicSKillstmt = $conn->prepare("DELETE FROM userskills WHERE id = ? AND skillName = ?");
    $removeAcademicSKillstmt->bind_param("is",  $id,$academicSKillToRemove);
    
    if ($removeAcademicSKillstmt->execute()) {
        $_SESSION["success"] = "Skill Removed successfully.";
    } else {
        $_SESSION["error"] = "Failed to remove skill. Please try again.";
    }

    $removeAcademicSKillstmt->close();
} 

if (isset($_POST["updateOtherSkills"])) {
    
    $newOtherSkill = $_POST["otherSkillsOffered"];
    
    // Prepare and execute the update query
    $updateOtherSkillstmt = $conn->prepare("INSERT INTO userskills (id, skillName) VALUES (? , ?)");
    $updateOtherSkillstmt->bind_param("is",  $id,$newOtherSkill);
    
    if ($updateOtherSkillstmt->execute()) {
        $_SESSION["success"] = "Skills updated successfully.";
    } else {
        $_SESSION["error"] = "Failed to update Skills. Please try again.";
    }

    $updateOtherSkillstmt->close();
} 
if (isset($_POST["removeOtherSkills"])) {
    
    $otherSKillToRemove = $_POST["otherSkillToRemove"];
    
    // Prepare and execute the update query
    $removeOtherSKillstmt = $conn->prepare("DELETE FROM userskills WHERE id = ? AND skillName = ?");
    $removeOtherSKillstmt->bind_param("is",  $id,$otherSKillToRemove);
    
    if ($removeOtherSKillstmt->execute()) {
        $_SESSION["success"] = "Skill Removed successfully.";
    } else {
        $_SESSION["error"] = "Failed to remove skill. Please try again.";
    }

    $removeOtherSKillstmt->close();
} 

if (isset($_POST["updateRequestedSkills"])) {
    
    $newRequestedSKill = $_POST["requestedSKills"];
    
    // Prepare and execute the update query
    $updateRequestedSKillstmt = $conn->prepare("INSERT INTO userrequestedskills (id, skillName) VALUES (? , ?)");
    $updateRequestedSKillstmt->bind_param("is",  $id,$newRequestedSKill);
    
    if ($updateRequestedSKillstmt->execute()) {
        $_SESSION["success"] = "Skills updated successfully.";
    } else {
        $_SESSION["error"] = "Failed to update Skills. Please try again.";
    }

    $updateRequestedSKillstmt->close();
}     
if (isset($_POST["removeRequestedSkills"])) {
    
    $requestedSKillToRemove = $_POST["requestedSkillToRemove"];
    
    // Prepare and execute the update query
    $removerequestedSKillstmt = $conn->prepare("DELETE FROM userrequestedskills WHERE id = ? AND skillName = ?");
    $removerequestedSKillstmt->bind_param("is",  $id,$requestedSKillToRemove);
    
    if ($removerequestedSKillstmt->execute()) {
        $_SESSION["success"] = "Skill Removed successfully.";
    } else {
        $_SESSION["error"] = "Failed to remove skill. Please try again.";
    }

    $removerequestedSKillstmt->close();
} 







    $conn->close();

    header("Location: editProfile.php");
    exit();




?>