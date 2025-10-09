<?php
require_once "../inc/dbconn.inc.php";
header('Content-type: application/json');
// Usage http://localhost:8010/Webpages/get-availability.php?startdate=2025-09-15&userid=testuser1
// Usage http://localhost:8010/Webpages/get-availability.php?startdate={YYYY-MM-DD}&userid={id}

$stmt = $conn->prepare("SELECT userid, dayindex, starttime, endtime
                        FROM recurringAvailability
                        WHERE userid = ? AND weekstartdate = (SELECT MAX(weekstartdate) 
                                                                      FROM recurringAvailability
                                                                      WHERE weekstartdate <= ? AND userid = ?)");
// Selects latest date which is on or before the supplied date


$stmt->bind_param("sss", $id, $weekstartdate, $id);


$weekstartdate = $_GET["weekstartdate"];
$id = $_GET["userid"];

$stmt->execute();

$result = ["weekstartdate" => $weekstartdate, "days" => []];

foreach (mysqli_stmt_get_result($stmt) as $key => $value) {
    $result["days"][$key] = $value;
}

echo json_encode($result);
