<?php
require_once "../inc/dbconn.inc.php";
header('Content-type: application/json');

// Prepare statement
$stmt = $conn->prepare("SELECT d as date, starttime, endtime, reason
                        FROM availability
                        WHERE userid = ? AND d BETWEEN ? AND ?
                        ORDER BY date");

// Set variables
$startdate = $_GET["startdate"];
$enddate = $_GET["enddate"];
$userid = $_GET["userid"];




// Choose variable names and types for prepared statement
$stmt->bind_param("sss", $userid, $startdate, $enddate);


// Run query
$stmt->execute();

$result = ["startdate" => $startdate, "enddate" => $enddate, "userid" => $userid, "days" => []];

foreach (mysqli_stmt_get_result($stmt) as $key => $value) { // Keys are indices, values are records
    $result["days"][$key] = $value;
}

echo json_encode($result);
