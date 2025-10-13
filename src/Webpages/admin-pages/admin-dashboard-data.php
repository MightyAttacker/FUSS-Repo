<?php
session_start();
include '../../inc/dbconn.inc.php';
header('Content-Type: application/json');

// Make sure user is logged in
if (!isset($_SESSION['id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

$id = $_SESSION['id'];

// --- Fetch logged-in user info ---
$getUserStmt = $conn->prepare('SELECT firstName, credits, admin FROM userdata WHERE id = ?');
$getUserStmt->bind_param('i', $id);
$getUserStmt->execute();
$result = $getUserStmt->get_result();
$userData = $result->fetch_assoc();
$getUserStmt->close();

$loggedFirstName = $userData['firstName'];
$loggedUserCredits = $userData['credits'];
$isAdmin = $userData['admin'];

// --- Initialize response ---
$response = [
    'loggedFirstName' => $loggedFirstName,
    'loggedUserCredits' => $loggedUserCredits,
    'isAdmin' => $isAdmin,
    'totalUsers' => 0,
    'activeUsers' => 0,
    'services' => [],
    'totalCredits' => 0,
    'FUSScreditDistribution' => [],
    'topSkills' => []
];

// --- Total users ---
$totalResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM userdata");
if ($totalResult) {
    $response['totalUsers'] = (int)mysqli_fetch_assoc($totalResult)['total'];
}

// --- Active users last 30 days ---
$activeResult = mysqli_query($conn, "SELECT COUNT(*) AS active FROM userdata WHERE last_active >= CURDATE() - INTERVAL 30 DAY");
if ($activeResult) {
    $response['activeUsers'] = (int)mysqli_fetch_assoc($activeResult)['active'];
}

// --- Services (limit 10) ---
$servicesResult = mysqli_query($conn, "SELECT skillName, status FROM skills LIMIT 10");
while ($row = mysqli_fetch_assoc($servicesResult)) {
    $response['services'][] = $row;
}

// --- FUSS Credit Distribution ---
$creditDistribution = [];
$distributionResult = mysqli_query($conn, "SELECT id, credits FROM userdata ORDER BY credits DESC");
$totalCreditsResult = mysqli_query($conn, "SELECT SUM(credits) AS total FROM userdata");

$totalCreditsRow = mysqli_fetch_assoc($totalCreditsResult);
$totalCredits = (int)$totalCreditsRow['total'];
$response['totalCredits'] = $totalCredits;

while ($row = mysqli_fetch_assoc($distributionResult)) {
    $creditDistribution[] = [
        'id' => $row['id'],
        'credits' => (int)$row['credits']
    ];
}
$response['FUSScreditDistribution'] = $creditDistribution;

// --- Top 5 Skills ---
$skillsResult = mysqli_query($conn, "SELECT skillName, COUNT(*) AS count FROM userskills GROUP BY skillName ORDER BY count DESC LIMIT 5");
while ($row = mysqli_fetch_assoc($skillsResult)) {
    $response['topSkills'][] = [
        'skillName' => $row['skillName'],
        'count' => (int)$row['count']
    ];
}

// --- Return JSON ---
echo json_encode($response, JSON_PRETTY_PRINT);
