<?php
session_start();
include "../inc/dbconn.inc.php";

if (isset($_POST['requestbox_id']) && isset($_POST['agreeType'])) {
    $requestbox_id = intval($_POST['requestbox_id']);
    $agreeType = $_POST['agreeType'];

    if ($agreeType === 'requestee') {
        $stmt = $conn->prepare("UPDATE requestbox SET requesteeAgreed = 1 WHERE id = ?");
        $stmt->bind_param("i", $requestbox_id);
    } elseif ($agreeType === 'requester') {
        $stmt = $conn->prepare("UPDATE requestbox SET requesterAgreed = 1 WHERE id = ?");
        $stmt->bind_param("i", $requestbox_id);
    }
    if (isset($stmt)) {
        $stmt->execute();
        $stmt->close();
    }
}
header("Location: requests.php");
exit();
?>