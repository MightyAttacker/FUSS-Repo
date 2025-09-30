<?php
require_once "../inc/dbconn.inc.php";
header('Content-type: application/json');

// Prepare statement
$stmt = $conn->prepare("SELECT userid, d, starttime, endtime, reason
                        FROM availability
                        WHERE userid = ? AND d BETWEEN ? AND ?");

// Set variables
$startdate = $_GET["startdate"];
$enddate = $_GET["enddate"];
$userid = $_GET["userid"];

// Choose variable names and types for prepared statement
$stmt->bind_param("sss", $userid, $startdate, $enddate);


// Run query
$stmt->execute();

$result = ["startdate" => $startdate, "enddate" => $enddate, "days" => []];

foreach (mysqli_stmt_get_result($stmt) as $key => $value) {
    if ($key == "d") {
        $result["days"]["date"] = $value;
    } else {
        $result["days"][$key] = $value;
    }
}

echo json_encode($result);
