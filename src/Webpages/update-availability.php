<?php
require_once "../inc/dbconn.inc.php";

$data = json_decode(file_get_contents('php://input'), true);

/*

// Prepare statement
$stmt = $conn->prepare("UPDATE users 
                        SET about = ?, course = ? 
                        WHERE id = \"testuser1\"");
// Choose variable names and types for prepared statement
$stmt->bind_param("ss", $about, $course);
// Set variables
$course = $data["course"];
$about = $data["about"];
// Run query
$stmt->execute();

// Execute query without variables
$conn->query("DELETE FROM userskills WHERE userid = \"testuser1\"");
*/
//$conn->query("DELETE FROM recurringAvailability WHERE userid = \"testuser1\"");
