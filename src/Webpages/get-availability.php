<?php
require_once "../inc/dbconn.inc.php";
header('Content-type: application/json');
// Usage http://localhost:8010/Webpages/get-availability.php?startdate=2025-09-15
// Usage http://localhost:8010/Webpages/get-availability.php?startdate={YYYY-MM-DD}
// Prepare statement
$stmt = $conn->prepare("SELECT userid, dayindex, starttime, endtime
                        FROM recurringAvailability
                        WHERE userid = ? AND weekstartdate = (SELECT MAX(weekstartdate) 
                                                                      FROM recurringAvailability
                                                                      WHERE weekstartdate <= ? AND userid = ?)");
// Selects latest date which is on or before the supplied date

// Choose variable names and types for prepared statement
$stmt->bind_param("sss", $id, $startdate, $id2);

// Set variables
$startdate = $_GET["startdate"];
$id = $_GET["id"];
$id2 = $_GET["id"];
// Run query
$stmt->execute();

$result = ["weekstartdate" => $startdate, "days" => []];

foreach (mysqli_stmt_get_result($stmt) as $key => $value) {
    $result["days"][$key] = $value;
}

echo json_encode($result);
