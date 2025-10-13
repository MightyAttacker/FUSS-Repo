<?php
require_once "../inc/dbconn.inc.php";
header('Content-type: application/json');

$stmt = $conn->prepare("SELECT d as date, starttime, endtime, reason
                        FROM availability
                        WHERE userid = ? AND d BETWEEN ? AND ?
                        ORDER BY date");

$startdate = $_GET["startdate"];
$enddate = $_GET["enddate"];
$userid = $_GET["userid"];


$stmt->bind_param("sss", $userid, $startdate, $enddate);

$stmt->execute();

$result = ["startdate" => $startdate, "enddate" => $enddate, "userid" => $userid, "days" => []];

foreach (mysqli_stmt_get_result($stmt) as $key => $value) { // Keys are indices, values are records
    $result["days"][$key] = $value;
}

echo json_encode($result);
