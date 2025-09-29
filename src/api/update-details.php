<?php
require_once "../inc/dbconn.inc.php";

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);


$stmt = $conn->prepare("UPDATE users 
                        SET about = ?, course = ? 
                        WHERE id = \"testuser1\"");
$stmt->bind_param("ss", $about, $course);
$course = $data["course"];
$about = $data["about"];
$stmt->execute();

// Clear skills for user then add them
$conn->query("DELETE FROM userskills WHERE userid = \"testuser1\"");

$stmt = $conn->prepare("INSERT INTO userskills 
                        VALUES (\"testuser1\", ?) ON DUPLICATE KEY UPDATE userid=userid");
$stmt->bind_param("s", $value);

foreach ($data["askills"] as $key => $value) {
    $stmt->execute();
}

$stmt = $conn->prepare("INSERT IGNORE INTO userskills 
                        VALUES (\"testuser1\", ?) ON DUPLICATE KEY UPDATE userid=userid");
$stmt->bind_param("s", $value);

foreach ($data["naskills"] as $key => $value) {
    $stmt->execute();
}
