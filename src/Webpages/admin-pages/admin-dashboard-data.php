<?php
include '../../inc/dbconn.inc.php';
header('Content-Type: application/json');



// Initialize response array
$response = [
    'totalUsers' => null,
    'activeUsers' => null,
    'services' => []
];

// Get total users
$totalResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users");
if ($totalResult) {
    $totalRow = mysqli_fetch_assoc($totalResult);
    $response['totalUsers'] = $totalRow['total'];
}

// Get active users in last 30 days
$activeResult = mysqli_query($conn, "SELECT COUNT(*) AS active FROM users WHERE last_active >= CURDATE() - INTERVAL 30 DAY");
if ($activeResult) {
    $activeRow = mysqli_fetch_assoc($activeResult);
    $response['activeUsers'] = $activeRow['active'];
} 
// get services and their statuses
$services = [];
$servicesResult = mysqli_query($conn, "SELECT service_name, status FROM services");
while($row = mysqli_fetch_assoc($servicesResult)) {
    $services[] = $row;
}
 $response['services'] = $services;

// Return JSON response
echo json_encode($response);
?>
