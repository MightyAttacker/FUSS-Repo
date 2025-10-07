<?php
require_once "../inc/dbconn.inc.php";

$data = json_decode(file_get_contents('php://input'), true);

function validateDate($date, $format = 'Y-m-d') // https://www.php.net/manual/en/function.checkdate.php#113205
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

$date = $data["date"];
if (!validateDate($date)) {
    http_response_code(400);
    die("Invalid date");
}

$time = $data["time"];
if (!preg_match("/^[01]\d|2[0-3]:[0-5]\d]$/m", $time)) {
    http_response_code(400);
    die("Invalid time");
}


$notes = $data["notes"]; // TODO: Input sanitization
$requester = $data["requester"]; // This is the person making the request // TODO: - make this work from session token
$requestee = $data["requestee"]; // This is the person receiving the request // TODO: Input sanitization - validate user ID

$cost = $data["cost"]; // TODO: Input validation - validate user has enough credits

$userCredits = 0;
$stmt = $conn->prepare("SELECT credits FROM users WHERE id = ?");
$stmt->bind_param("s", $requester);
$stmt->bind_result($userCredits);

$stmt->execute();

if (!preg_match("/^\d+$/m", $cost)) { // Cost must be an int
    http_response_code(400);
    die("Invalid cost");
} elseif ($cost == 0) {
    http_response_code(400);
    die("Cost must be greater than 0");
} elseif ($userCredits < $cost) {
    http_response_code(400);
    die("Too expensive");
}
$stmt = 0;

$stmt = $conn->prepare("INSERT INTO request (d,
                     starttime,
                     cost,
                     notes,
                     requesterid,
                     requesteeid,
                     status) VALUES (?, ?, ?, ?, ?, ?, 'Pending')");

$stmt->bind_param("ssisss", $date, $time, $cost, $notes, $requester, $requestee);

$stmt->execute();