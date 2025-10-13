<?php
include '../../inc/dbconn.inc.php';
header('Content-Type: application/json');



// Initialize response array
$response = [
    'totalUsers' => null,
    'activeUsers' => null,
    'services' => [],
    'totalCredits' => null,
    'FUSScreditDistribution' => [],
    'topSkills' => []
];

// Get total users
$totalResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM userdata");
if ($totalResult) {
    $totalRow = mysqli_fetch_assoc($totalResult);
    $response['totalUsers'] = $totalRow['total'];
}

// Get active users in last 30 days
$activeResult = mysqli_query($conn, "SELECT COUNT(*) AS active FROM userdata WHERE last_active >= CURDATE() - INTERVAL 30 DAY");
if ($activeResult) {
    $activeRow = mysqli_fetch_assoc($activeResult);
    $response['activeUsers'] = $activeRow['active'];
}
// get services and their statuses
$services = [];
$servicesResult = mysqli_query($conn, "SELECT skillName, status FROM skills LIMIT 10");
while($row = mysqli_fetch_assoc($servicesResult)) {
  $services[] = $row;
}
 $response['services'] = $services;

 //FUSScredit Distribution
$creditDistribution = [];
$distributionResult = mysqli_query($conn, "SELECT id, credits FROM userdata ORDER BY credits DESC");
$totalCreditsResult = mysqli_query($conn, "SELECT SUM(credits) AS total FROM userdata");

$totalCreditsRow = mysqli_fetch_assoc($totalCreditsResult);
$totalCredits = $totalCreditsRow['total'];

while($row = mysqli_fetch_assoc($distributionResult)) {
    $creditDistribution[] = $row;
}

$response['totalCredits'] = $totalCredits;
$response['FUSScreditDistribution'] = $creditDistribution;

//get top 5 skills and their counts
$skills = [];
$skillsResult = mysqli_query($conn, "SELECT skillName, COUNT(*) AS count FROM userskills GROUP BY skillName ORDER BY count DESC LIMIT 5");
while($row = mysqli_fetch_assoc($skillsResult)) {
    $skills[] = $row;
}
$response['topSkills'] = $skills;

// Return JSON response
echo json_encode($response);
?>
