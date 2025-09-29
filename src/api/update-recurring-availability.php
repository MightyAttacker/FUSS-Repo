<?php
require_once "../inc/dbconn.inc.php";

function toMonday($date) {
    $diff = 0;
    while (getdate(strtotime($date . " -" . $diff . "day"))["wday"] != 1) { // 1 represents Monday  https://www.php.net/manual/en/function.getdate.php
        $diff++;
    }
    return date("Y-m-d", strtotime($date . " -" . $diff . "day"));
}


$data = json_decode(file_get_contents('php://input'), true);

// https://www.php.net/manual/en/function.http-response-code.php
// https://www.php.net/manual/en/function.preg-match.php

$currentDate = $data['weekstartdate'];
if (!preg_match("/^\d{4}-\d{2}-\d{2}$/m", $currentDate)) { // currentDate must have format yyyy-mm-dd
    http_response_code(400);
    die("Invalid weekstartdate value");
}
$currentDate = toMonday($currentDate);


$days = $data['days'];
foreach ($days as $day) {
    $index = $day["dayindex"];
    if ($index < 0 || $index > 6) {
        http_response_code(400);
        die("Invalid day index value");
    }
    $starttime = $day["starttime"];
    // TODO: Make regex only match for valid times -> 0-59
    if (!preg_match("/^\d{1,2}(?::\d{2}){1,2}$/m", $starttime)) { // Match time formats H:MM, HH:MM, H:MM:SS, HH:MM:SS
        http_response_code(400);
        die("Invalid starttime value");
    }

    if (substr_count($starttime, ":") == 2) { // If time has seconds
        preg_replace("/:\d{2}$/m", "", $starttime);
    }

    $endtime = $day["endtime"];
    // TODO: Make regex only match for valid times -> 0-59
    if (!preg_match("/^\d{1,2}(?::\d{2}){1,2}$/m", $endtime)) { // Match time formats H:MM, HH:MM, H:MM:SS, HH:MM:SS
        http_response_code(400);
        die("Invalid starttime value");
    }
    if (substr_count($endtime, ":") == 2) { // If time has seconds
        preg_replace("/:\d{2}$/m", "", $endtime);
    }

    if (strtotime($starttime) >= strtotime($endtime)) {
        http_response_code(400);
        die("End time must be after start time");
    }
}

$users = array_unique(array_column($days, "userid")); // TODO: validate list of users using SELECT WHERE IN


$temp = [];

$stmt = $conn->prepare("DELETE FROM recurringAvailability WHERE weekstartdate = ? AND userid = ?");

$stmt->bind_param("ss", $currentDate, $user);
foreach ($users as $user) {
    $stmt->execute();
}

// Can assume the data is in the right format
$stmt = $conn->prepare("INSERT INTO recurringAvailability (userid, weekstartdate, dayindex, starttime, endtime) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $userid, $currentDate, $index, $starttime, $endtime);
foreach ($days as $day) {
    $userid = $day["userid"];
    $index = $day["dayindex"];
    $starttime = $day["starttime"];
    $endtime = $day["endtime"];
    $stmt->execute();
}
