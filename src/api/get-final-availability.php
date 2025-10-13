<?php
require_once "../inc/dbconn.inc.php";
header("Content-type: application/json");

$data = json_decode(file_get_contents('php://input'), true);

function validateDate($date, $format = 'Y-m-d') // https://www.php.net/manual/en/function.checkdate.php#113205
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

$userid = $data["userid"]; // TODO: validate userid

$startdate = $data["startdate"];

if (!validateDate($startdate)) {
    http_response_code(400);
    die("Invalid startdate value");
}

$enddate = $data["enddate"];

if (!validateDate($enddate)) {
    http_response_code(400);
    die("Invalid enddate value");
}


$stmt = $conn->prepare("SELECT d as date, starttime, endtime, reason
                        FROM availability
                        WHERE userid = ? AND d BETWEEN ? AND ?
                        ORDER BY date");

$stmt->bind_param("sss", $userid, $startdate, $enddate);

$stmt->execute();

$dailyresult = ["startdate" => $startdate, "enddate" => $enddate, "userid" => $userid, "days" => []];

foreach (mysqli_stmt_get_result($stmt) as $key => $value) { // Keys are indices, values are records
    $dailyresult["days"][$key] = $value;
}

$stmt = $conn->prepare("SELECT userid, dayindex, starttime, endtime
                        FROM recurringAvailability
                        WHERE userid = ? AND weekstartdate = (SELECT MAX(weekstartdate) 
                                                                      FROM recurringAvailability
                                                                      WHERE weekstartdate <= ? AND userid = ?)");
// Selects latest date which is on or before the supplied date


$stmt->bind_param("sss", $userid, $startdate, $userid);

$stmt->execute();

$recurringresult = ["weekstartdate" => $startdate, "days" => []];

foreach (mysqli_stmt_get_result($stmt) as $key => $value) {
    $recurringresult["days"][$key] = $value;
}

$dates = [];


$b = new DateTime($startdate);
$e = new DateTime($enddate);


$interval = DateInterval::createFromDateString("1 day");
$period = new DatePeriod($b, $interval, $e, DatePeriod::INCLUDE_END_DATE);

foreach ($period as $dt) {
    $dates[$dt->format("Y-m-d")] = [];
} // TODO: Finish this
