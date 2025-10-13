<?php
include '../../inc/dbconn.inc.php';
header('Content-Type: application/json');

$response = ['success' => false, 'message' => '', 'skills' => []];

/*
FETCH SKILLS
*/
if(isset($_GET['action']) && $_GET['action'] === 'fetch') {
    $skills = [];
    $result = mysqli_query($conn, "SELECT skillName FROM skills ORDER BY skillName ASC");
    while($row = mysqli_fetch_assoc($result)) {
        $skills[] = $row;
    }
    $response['skills'] = $skills;
    echo json_encode($response);
    exit;
}

/*
ADD SKILL
*/
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['skillName'])) {
    $skillName = trim($_POST['skillName']);

    $stmt = $conn->prepare("SELECT COUNT(*) FROM skills WHERE skill = ?");
    $stmt->bind_param("s", $skillName);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if($count > 0) {
        $response['message'] = "Error: Skill already exists.";
    } else {
        $stmt = $conn->prepare("INSERT INTO skills (skillName) VALUES ?");
        $stmt->bind_param("s", $skillName);
        if($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = "Skill added successfully.";
        } else {
            $response['message'] = "Error: Could not add skill.";
        }
        $stmt->close();
    }

    echo json_encode($response);
    exit;
}

/*
|--------------------------------------------------------------------------
| DELETE SKILL
|--------------------------------------------------------------------------
*/
if(isset($_POST['action']) && $_POST['action'] === 'delete' && !empty($_POST['skill'])) {
    $skillToDelete = trim($_POST['skill']);

    $stmt = $conn->prepare("SELECT COUNT(*) FROM userskills WHERE skillName = ?");
    $stmt->bind_param("s", $skillToDelete);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if($count > 0) {
        $response['message'] = "Error: Skill is in use and cannot be deleted.";
    } else {
        $stmt = $conn->prepare("DELETE FROM skills WHERE skillName = ?");
        $stmt->bind_param("s", $skillToDelete);
        if($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = "Skill deleted successfully.";
        } else {
            $response['message'] = "Error: Could not delete skill.";
        }
        $stmt->close();
    }

    echo json_encode($response);
    exit;
}

$conn->close();
