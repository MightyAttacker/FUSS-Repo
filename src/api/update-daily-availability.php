<?php
require_once "../inc/dbconn.inc.php";


$data = json_decode(file_get_contents('php://input'), true);

$startdate = $data["startdate"]; // TODO: date validation
$enddate = $data["enddate"]; // TODO: date validation
$userid = $data["userid"]; // TODO: user validation

$data = $data["days"];


foreach ($data as $day) { // TODO: find out about transactions
    $date = $day["date"];
    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/m", $date)) { // currentDate must have format yyyy-mm-dd
        http_response_code(400);
        die("Invalid date value");
    }
    $starttime = $day["starttime"];

    if (!preg_match("/^\d{1,2}(?::\d{2}){1,2}$/m", $starttime)) { // Match time formats H:MM, HH:MM, H:MM:SS, HH:MM:SS
        http_response_code(400);
        die("Invalid starttime value");
    }
    $endtime = $day["endtime"];

    if (!preg_match("/^\d{1,2}(?::\d{2}){1,2}$/m", $endtime)) { // Match time formats H:MM, HH:MM, H:MM:SS, HH:MM:SS
        http_response_code(400);
        die("Invalid endtime value");
    }
}

$k = [];

$stmt = $conn->prepare("DELETE FROM availability WHERE userid = ? AND d BETWEEN ? AND ?");
$stmt->bind_param("sss", $userid, $startdate, $enddate);
$stmt->execute();

$reason = "manual";
$stmt = $conn->prepare("INSERT INTO availability (userid, d, starttime, endtime, reason) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $userid, $date, $starttime, $endtime, $reason);

foreach ($data as $day) {
    $date = $day["date"];
    $starttime = $day["starttime"];
    $endtime = $day["endtime"];

    $stmt->execute();
}