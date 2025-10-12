<?php
session_start();
include "../inc/dbconn.inc.php";


if (isset($_POST['requestbox_id']) && isset($_POST['agreeType'])) {
    $requestbox_id = intval($_POST['requestbox_id']);
    $agreeType = $_POST['agreeType'];

    if ($agreeType === 'requestee') {
        $stmt = $conn->prepare("UPDATE requestbox SET requesteeConfirmed = 1 WHERE id = ?");
        $stmt->bind_param("i", $requestbox_id);
    } elseif ($agreeType === 'requester') {
        $stmt = $conn->prepare("UPDATE requestbox SET requesterConfirmed = 1 WHERE id = ?");
        $stmt->bind_param("i", $requestbox_id);
    }
    if (isset($stmt)) {
        $stmt->execute();
        $stmt->close();
    }
}
$creditSwapStmt = $conn->prepare("SELECT requesterConfirmed, requesteeConfirmed, creditsReleased FROM requestbox WHERE id = ?");
$creditSwapStmt->bind_param("i", $requestbox_id);
$creditSwapStmt->execute();
$creditSwap = $creditSwapStmt->get_result();
if ($row = $creditSwap->fetch_assoc()) {
    if ($row['requesterConfirmed'] == 1 && $row['requesteeConfirmed'] == 1 && $row['creditsReleased']==0) {
        // Both parties have confirmed and credits have not been released yet
        $updateCreditsStmt = $conn->prepare("UPDATE userdata as u
            JOIN requestbox AS r ON (u.id = r.requester OR u.id = r.requestee)
            SET u.credits = CASE 
                WHEN u.id = r.requester THEN u.credits - r.credits
                WHEN u.id = r.requestee THEN u.credits + r.credits
                ELSE u.credits
            END
            WHERE r.id = ?");
        $updateCreditsStmt->bind_param("i", $requestbox_id);
        $updateCreditsStmt->execute();
        $updateCreditsStmt->close();

        // Mark credits as released
        $markReleasedStmt = $conn->prepare("UPDATE requestbox SET creditsReleased = 1 WHERE id = ?");
        $markReleasedStmt->bind_param("i", $requestbox_id);
        $markReleasedStmt->execute();
        $markReleasedStmt->close();
    }
}


header("Location: myRequests.php");
exit();
?>