<?php
include '../../inc/dbconn.inc.php';
header('Content-Type: application/json');

$response = ['success' => false, 'message' => '', 'categories' => []];

/*
|--------------------------------------------------------------------------
| FETCH CATEGORIES
|--------------------------------------------------------------------------
*/
if (isset($_GET['action']) && $_GET['action'] === 'fetch') {
    $degree = [];
    $result = mysqli_query($conn, "SELECT `degreeName` FROM degree"); // backticks for space
    while ($row = mysqli_fetch_assoc($result)) {
        $degree[] = [
            'degree' => $row['degreeName'], // match the column
        ];
    }
    $response['degree'] = $degree;
    echo json_encode($response);
    exit;
}

/*
|--------------------------------------------------------------------------
| ADD CATEGORY
|--------------------------------------------------------------------------
*/
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add' && !empty($_POST['degreeName'])) {
    $degreeName = preg_replace('/[^a-zA-Z0-9_]/', '_', trim($_POST['degreeName']));

    // Prevent duplicate columns
    $check = mysqli_query($conn, "SELECT * FROM degree WHERE `degreeName` LIKE '$degreeName'");
    if (mysqli_num_rows($check) > 0) {
        $response['message'] = "Error: Degree already exists.";
    } else {
        $sql = "INSERT INTO degree (`degreeName`) VALUES ('$degreeName')";
        if (mysqli_query($conn, $sql)) {
            $response['success'] = true;
            $response['message'] = "Degree added successfully.";
        } else {
            $response['message'] = "Error: Could not add degree.";
        }
    }

    echo json_encode($response);
    exit;
}

/*
|--------------------------------------------------------------------------
| DELETE Degree
|--------------------------------------------------------------------------
*/
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete' && !empty($_POST['degree'])) {
    $degree = preg_replace('/[^a-zA-Z0-9_]/', '_', strtolower(trim($_POST['degree'])));
    if ($degree === 'degree') {
        $response['message'] = "Error: Cannot delete primary column 'degree'.";
    } else {
        $query = "DELETE FROM degree where `degreeName` = '$degree'";
        if (mysqli_query($conn, $query)) {
            $response['success'] = true;
            $response['message'] = "Degree deleted successfully.";
        } else {
            $response['message'] = "Error deleting Degree: " . mysqli_error($conn);
        }
    }
    echo json_encode($response);
    exit;
}

$conn->close();
?>