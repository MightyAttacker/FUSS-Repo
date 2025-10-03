<?php
require_once "../inc/dbconn.inc.php";
header('Content-type: application/json');
// Usage http://localhost:8010/Webpages/get-availability.php?startdate=2025-09-15&userid=testuser1
// Usage http://localhost:8010/Webpages/get-availability.php?startdate={YYYY-MM-DD}&userid={id}
// Prepare statement
$stmt = $conn->prepare("SELECT userid, dayindex, starttime, endtime
                        FROM recurringAvailability
                        WHERE userid = ? AND weekstartdate = (SELECT MAX(weekstartdate) 
                                                                      FROM recurringAvailability
                                                                      WHERE weekstartdate <= ? AND userid = ?)");
// Selects latest date which is on or before the supplied date

// Choose variable names and types for prepared statement
$stmt->bind_param("sss", $id, $weekstartdate, $id2);

// Set variables
$weekstartdate = $_GET["weekstartdate"];
$id = $_GET["userid"];
$id2 = $_GET["userid"]; // TODO: use named sql arguments
// Run query
$stmt->execute();

$result = ["weekstartdate" => $weekstartdate, "days" => []];

foreach (mysqli_stmt_get_result($stmt) as $key => $value) {
    $result["days"][$key] = $value;
}

echo json_encode($result);
