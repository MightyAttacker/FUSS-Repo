<?php
include '../../inc/dbconn.inc.php';

// Get total users
$totalResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users");
$totalRow = mysqli_fetch_assoc($totalResult);

// Get active users in last 30 days
$activeResult = mysqli_query($conn, "SELECT COUNT(*) AS active FROM users WHERE last_active >= CURDATE() - INTERVAL 30 DAY");
$activeRow = mysqli_fetch_assoc($activeResult);

echo json_encode([
    'totalUsers' => $totalRow['total'],
    'activeUsers' => $activeRow['active']
]);
?>