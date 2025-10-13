<?php
session_start();
include '../inc/dbconn.inc.php';

if (!isset($_SESSION['id'])) {
    header("Location: loginPages/studentLoginPage.php");
    exit();
}

$id = $_SESSION['id'];
$message = '';

// --- Fetch user data ---
$getUserDataStmt = $conn->prepare('SELECT credits, firstName, email, imagePath FROM userdata WHERE id = ?');
$getUserDataStmt->bind_param('i', $id);
$getUserDataStmt->execute();
$userData = $getUserDataStmt->get_result()->fetch_assoc();
$getUserDataStmt->close();

$userCredits = $userData['credits'] ?? 0;
$firstName   = $userData['firstName'] ?? '';
$email       = $userData['email'] ?? '';
$imagePath   = $userData['imagePath'] ?? '';

$getUserAdminStmt = $conn->prepare('SELECT admin FROM userdata WHERE id=?');
$getUserAdminStmt->bind_param('i', $id);
$getUserAdminStmt->execute();
$getUserAdmin = $getUserAdminStmt->get_result()->fetch_assoc()['admin'];
$getUserAdminStmt->close();

// --- Fetch unique skills from requestbox ---
$skillsResultstmt = $conn->prepare('SELECT 
requestbox.skillName, 
requestbox.requestee, 
requestbox.requester, 
ue.firstName AS requesteeName,
ue.lastName AS requesteeLastName, 
ur.firstName AS requesterName,
ur.lastName AS requesterLastName
FROM requestbox
LEFT JOIN userdata ue ON requestbox.requestee = ue.id 
LEFT JOIN userdata ur ON requestbox.requester = ur.id 
WHERE requestee OR requester = ? 
ORDER BY skillName ASC');
$skillsResultstmt->bind_param('i', $id);
$skillsResultstmt->execute();
$skillsResult = $skillsResultstmt->get_result();
$skills = [];
while ($row = $skillsResult->fetch_assoc()) {
    $skills[] = $row['skillName'] . " (Offered by: " . ($row['requestee'] == $id ? 'You' : $row['requesteeName'] . " ". $row['requesteeLastName']) . 
    ", Requested By: " . ($row['requester'] == $id ? 'You' : $row['requesterName']) . " " . $row['requesterLastName'] . ")";
}

// --- Handle form submission ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $skillData = json_decode($_POST['skill'], true);
    $skillName = $skillData['skillName'] ?? '';
    $rating    = $_POST['rating'] ?? '';
    $review    = $_POST['review'] ?? '';
    $requestee = $_POST['requestee'] ?? '';
    $requester = $_POST['requester'] ?? '';

    if ($skillName && $rating && $review) {
        // Get the correct requestbox.id for this skill, requestee, and requester
        $stmt = $conn->prepare('SELECT id FROM requestbox WHERE skillName=? AND requestee=? AND requester=?');
        $stmt->bind_param('sii', $skillName, $requestee, $requester);
        $stmt->execute();
        $result = $stmt->get_result();
        $requestboxRow = $result->fetch_assoc();
        $requestboxId = $requestboxRow['id'] ?? null;
        $stmt->close();

        if ($requestboxId) {
            $stmt = $conn->prepare('
                INSERT INTO reviews (id, user, product, rating, review)
                VALUES (?, ?, ?, ?, ?)
            ');
            $stmt->bind_param('iisis', $requestboxId, $id, $skillName, $rating, $review);
            if ($stmt->execute()) {
                $message = "Review submitted successfully!";
            } else {
                $message = "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $message = "Could not find the skill request in the database.";
        }
    } else {
        $message = "All fields are required!";
    }
}

$skills = [];
foreach ($skillsResult as $row) {
    $skills[] = [
        'skillName' => $row['skillName'],
        'display' => $row['skillName'] . " (Offered by: " . ($row['requestee'] == $id ? 'You' : $row['requesteeName'] . " " . $row['requesteeLastName']) . ", Requested By: " . ($row['requester'] == $id ? 'You' : $row['requesterName'] . " " . $row['requesterLastName']) . ")"
    ];
  }
// --- Calculate average rating and total reviews per skill per Requestee ---
$requesteeRatings = [];
$requesterRatings = [];
foreach ($skills as $skill) {
    $skillEscaped = $conn->real_escape_string($skill['skillName']);

    // Reviews where you are the requestee (you offered the skill)
    $resReqee = $conn->query("
        SELECT AVG(rating) AS avg_rating, COUNT(*) AS total_reviews
        FROM reviews
        INNER JOIN requestbox ON reviews.id = requestbox.id
        WHERE requestbox.skillName = '$skillEscaped'
          AND requestbox.requestee = $id
    ");
    $rowReqee = $resReqee->fetch_assoc();
    $requesteeRatings[$skill['display']] = [
        'avg' => round($rowReqee['avg_rating'] ?? 0, 1),
        'total' => $rowReqee['total_reviews'] ?? 0
    ];

    // Reviews where you are the requester (you requested the skill)
    $resReqer = $conn->query("
        SELECT AVG(rating) AS avg_rating, COUNT(*) AS total_reviews
        FROM reviews
        INNER JOIN requestbox ON reviews.id = requestbox.id
        WHERE requestbox.skillName = '$skillEscaped'
          AND requestbox.requester = $id
    ");
    $rowReqer = $resReqer->fetch_assoc();
    $requesterRatings[$skill['display']] = [
        'avg' => round($rowReqer['avg_rating'] ?? 0, 1),
        'total' => $rowReqer['total_reviews'] ?? 0
    ];
}
// --- Fetch reviews about you as requestee ---
$reviewsAboutYouAsRequestee = [];
$res = $conn->query("
    SELECT reviews.rating, reviews.review, reviews.user, userdata.firstName, userdata.lastName, requestbox.skillName
    FROM reviews
    INNER JOIN requestbox ON reviews.id = requestbox.id
    INNER JOIN userdata ON reviews.user = userdata.id
    WHERE requestbox.requestee = $id
      AND reviews.user != $id
");
while ($row = $res->fetch_assoc()) {
    $reviewsAboutYouAsRequestee[] = $row;
}

// --- Fetch reviews about you as requester ---
$reviewsAboutYouAsRequester = [];
$res = $conn->query("
    SELECT reviews.rating, reviews.review, reviews.user, userdata.firstName, userdata.lastName, requestbox.skillName
    FROM reviews
    INNER JOIN requestbox ON reviews.id = requestbox.id
    INNER JOIN userdata ON reviews.user = userdata.id
    WHERE requestbox.requester = $id
      AND reviews.user != $id
");
while ($row = $res->fetch_assoc()) {
    $reviewsAboutYouAsRequester[] = $row;
}
// Sort and slice top/bottom 5 for requestee reviews
usort($reviewsAboutYouAsRequestee, function($a, $b) {
    return $b['rating'] <=> $a['rating']; // Descending
});
$top5Requestee = array_slice($reviewsAboutYouAsRequestee, 0, 5);

usort($reviewsAboutYouAsRequestee, function($a, $b) {
    return $a['rating'] <=> $b['rating']; // Ascending
});
$bottom5Requestee = array_slice($reviewsAboutYouAsRequestee, 0, 5);

// Sort and slice top/bottom 5 for requester reviews
usort($reviewsAboutYouAsRequester, function($a, $b) {
    return $b['rating'] <=> $a['rating']; // Descending
});
$top5Requester = array_slice($reviewsAboutYouAsRequester, 0, 5);

usort($reviewsAboutYouAsRequester, function($a, $b) {
    return $a['rating'] <=> $b['rating']; // Ascending
});
$bottom5Requester = array_slice($reviewsAboutYouAsRequester, 0, 5);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="author" content="Lachlan">
<title>Peer Feedback</title>
<link rel="stylesheet" href="PeerFeedback.css">
</head>
<body>

  <div id="topBanner">
    <div id="flindersLogo">
      <img id="imgLogo" src="./images/Logo_Flinders_white.png" alt="Logo for Flinders University">
    </div>
    <div id="title">
      <header>
        <h1>Flinders University Skill Share</h1>
      </header>
    </div>
    <div id="UserDetails">
      <h4>Hello, <?php echo htmlspecialchars($firstName); ?></h4>
    </div>
    <div id="logoutButton">
      <input id="logButton" type="button" onclick="location.href='./loginPages/logout.php';" value="Logout"/>
    </div>
  </div>

<div id="sideBar">
    <ul class="sidebar">
            <li> <a href="./student-homepage.php">Home</a> </li>
            <li> <a href="./inbox.php"> Inbox</a> </li>
            <li> <a href="./browsePage.php"> Browse Offered Skills</a> </li>
            <li> <a href="./requests.php"> Make A Request</a> </li>
            <li> <a href="./myRequests.php">View My Requests</a> </li>
            <li> <a class="active" href="./PeerFeedback.php">Peer Reviews</a> </li>
            <li> <a href="./studentProfile.php">My Profile</a> </li>
            <li> <a href="#History">Credit History</a> </li>
            <?php if ($getUserAdmin == 1) echo '<li> <a href="./admin-pages/admin-dashboard.html">Admin Dashboard</a> </li>' ?>
    </ul>
  </div>

  <div class="review-container">
    <h2>Leave a Review</h2>
    <?php if ($message) echo "<p class='message'>$message</p>"; ?>

    <form method="post">
        <label for="skill">Select Skill Request:</label>
        <select name="skill" id="skill" required>
            <option value="">--Choose a skill--</option>
            <?php foreach ($skillsResult as $row): 
      $optionData = [
        'skillName' => $row['skillName'],
        'requestee' => $row['requestee'],
        'requester' => $row['requester'],
        'display'   => $row['skillName'] . " (Offered by: " . ($row['requestee'] == $id ? 'You' : $row['requesteeName'] . " " . $row['requesteeLastName']) . ", Requested By: " . ($row['requester'] == $id ? 'You' : $row['requesterName'] . " " . $row['requesterLastName']) . ")"
    ];
?>
    <option value='<?php echo htmlspecialchars(json_encode($optionData)); ?>'>
        <?php echo htmlspecialchars($optionData['display']); ?>
    </option> <?php endforeach; ?>
        </select>

        <div class="star-rating">
            <input type="radio" name="rating" id="star5" value="5"><label for="star5">&#9733;</label>
            <input type="radio" name="rating" id="star4" value="4"><label for="star4">&#9733;</label>
            <input type="radio" name="rating" id="star3" value="3"><label for="star3">&#9733;</label>
            <input type="radio" name="rating" id="star2" value="2"><label for="star2">&#9733;</label>
            <input type="radio" name="rating" id="star1" value="1"><label for="star1">&#9733;</label>
        </div>

        <textarea name="review" placeholder="Write your review..." required></textarea>
        <input type="hidden" name="requestee" id="requestee">
        <input type="hidden" name="requester" id="requester">
        <button type="submit">Submit Review</button>
    </form>

    <h2>Your Reviews Summary</h2>
<h3>Top 5 Reviews About You (as Requestee):</h3>
<ul>
<?php foreach ($top5Requestee as $review): ?>
    <li>
        <strong><?php echo htmlspecialchars($review['skillName']); ?></strong> -
        <?php echo htmlspecialchars($review['rating']); ?>/5<br>
        "<?php echo htmlspecialchars($review['review']); ?>"<br>
        <em>by <?php echo htmlspecialchars($review['firstName'] . ' ' . $review['lastName']); ?></em>
    </li>
<?php endforeach; ?>
</ul>

<h3>Worst 5 Reviews About You (as Requestee):</h3>
<ul>
<?php foreach ($bottom5Requestee as $review): ?>
    <li>
        <strong><?php echo htmlspecialchars($review['skillName']); ?></strong> -
        <?php echo htmlspecialchars($review['rating']); ?>/5<br>
        "<?php echo htmlspecialchars($review['review']); ?>"<br>
        <em>by <?php echo htmlspecialchars($review['firstName'] . ' ' . $review['lastName']); ?></em>
    </li>
<?php endforeach; ?>
</ul>

<h3>Top 5 Reviews About You (as Requester):</h3>
<ul>
<?php foreach ($top5Requester as $review): ?>
    <li>
        <strong><?php echo htmlspecialchars($review['skillName']); ?></strong> -
        <?php echo htmlspecialchars($review['rating']); ?>/5<br>
        "<?php echo htmlspecialchars($review['review']); ?>"<br>
        <em>by <?php echo htmlspecialchars($review['firstName'] . ' ' . $review['lastName']); ?></em>
    </li>
<?php endforeach; ?>
</ul>

<h3>Worst 5 Reviews About You (as Requester):</h3>
<ul>
<?php foreach ($bottom5Requester as $review): ?>
    <li>
        <strong><?php echo htmlspecialchars($review['skillName']); ?></strong> -
        <?php echo htmlspecialchars($review['rating']); ?>/5<br>
        "<?php echo htmlspecialchars($review['review']); ?>"<br>
        <em>by <?php echo htmlspecialchars($review['firstName'] . ' ' . $review['lastName']); ?></em>
    </li>
<?php endforeach; ?>
</ul>
  </div>

</body>
</html>
<script>
document.getElementById('skill').addEventListener('change', function() {
    var selected = this.value;
    if (selected) {
        var data = JSON.parse(selected);
        document.getElementById('requestee').value = data.requestee;
        document.getElementById('requester').value = data.requester;
    } else {
        document.getElementById('requestee').value = '';
        document.getElementById('requester').value = '';
    }
});
</script>
