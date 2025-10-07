@ -1,41 +0,0 @@
<?php
include '../../inc/dbconn.inc.php';
header('Content-Type: application/json');

if (!$conn) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

// Initialize response array
$response = [
    'totalUsers' => null,
    'activeUsers' => null
];

// Get total users
$totalResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users");
if ($totalResult) {
    $totalRow = mysqli_fetch_assoc($totalResult);
    $response['totalUsers'] = $totalRow['total'];
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch total users']);
    exit;
}

// Get active users in last 30 days
$activeResult = mysqli_query($conn, "SELECT COUNT(*) AS active FROM users WHERE last_active >= CURDATE() - INTERVAL 30 DAY");
if ($activeResult) {
    $activeRow = mysqli_fetch_assoc($activeResult);
    $response['activeUsers'] = $activeRow['active'];
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch active users']);
    exit;
}

// Return JSON response
echo json_encode($response);
?>