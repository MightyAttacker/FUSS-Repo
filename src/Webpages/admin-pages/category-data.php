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
    $categories = [];
    $result = mysqli_query($conn, "SHOW COLUMNS FROM skills");
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['Field'] !== 'skill') {
            $countQuery = mysqli_query($conn, "SELECT COUNT(*) AS count FROM skills WHERE `{$row['Field']}` = 1");
            $countRow = mysqli_fetch_assoc($countQuery);
            $categories[] = [
                'category' => $row['Field'],
                'count' => $countRow['count']
            ];
        }
    }
    $response['categories'] = $categories;
    echo json_encode($response);
    exit;
}

/*
|--------------------------------------------------------------------------
| ADD CATEGORY
|--------------------------------------------------------------------------
*/
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add' && !empty($_POST['categoryName'])) {
    $columnName = preg_replace('/[^a-zA-Z0-9_]/', '_', trim($_POST['categoryName']));

    // Prevent duplicate columns
    $check = mysqli_query($conn, "SHOW COLUMNS FROM skills LIKE '$columnName'");
    if (mysqli_num_rows($check) > 0) {
        $response['message'] = "Error: Category already exists.";
    } else {
        $sql = "ALTER TABLE skills ADD `$columnName` TINYINT UNSIGNED NOT NULL DEFAULT 0";
        if (mysqli_query($conn, $sql)) {
            $response['success'] = true;
            $response['message'] = "Category added successfully.";
        } else {
            $response['message'] = "Error: Could not add category.";
        }
    }

    echo json_encode($response);
    exit;
}

/*
|--------------------------------------------------------------------------
| DELETE CATEGORY
|--------------------------------------------------------------------------
*/
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete' && !empty($_POST['category'])) {
    $category = preg_replace('/[^a-zA-Z0-9_]/', '_', strtolower(trim($_POST['category'])));
    if ($category === 'skill') {
        $response['message'] = "Error: Cannot delete primary column 'skill'.";
    } else {
        $query = "ALTER TABLE skills DROP COLUMN `$category`";
        if (mysqli_query($conn, $query)) {
            $response['success'] = true;
            $response['message'] = "Category deleted successfully.";
        } else {
            $response['message'] = "Error deleting category: " . mysqli_error($conn);
        }
    }
    echo json_encode($response);
    exit;
}

$conn->close();
