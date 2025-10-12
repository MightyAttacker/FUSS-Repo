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
$skillsResult = $conn->query('SELECT DISTINCT skillName FROM requestbox ORDER BY skillName ASC');
$skills = [];
while ($row = $skillsResult->fetch_assoc()) {
    $skills[] = $row['skillName'];
}

// --- Handle form submission ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $skillName = $_POST['skill'] ?? '';
    $rating    = $_POST['rating'] ?? '';
    $review    = $_POST['review'] ?? '';

    if ($skillName && $rating && $review) {
        $stmt = $conn->prepare('
            INSERT INTO product_reviews (product_id, user_id, rating, review)
            VALUES ((SELECT id FROM requestbox WHERE skillName=? LIMIT 1), ?, ?, ?)
        ');
        $stmt->bind_param('siis', $skillName, $id, $rating, $review);
        if ($stmt->execute()) {
            $message = "Review submitted successfully!";
        } else {
            $message = "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "All fields are required!";
    }
}

// --- Calculate average rating and total reviews per skill ---
$ratingsData = [];
foreach ($skills as $skill) {
    $skillEscaped = $conn->real_escape_string($skill);
    $res = $conn->query("
        SELECT AVG(rating) AS avg_rating, COUNT(*) AS total_reviews
        FROM product_reviews pr
        INNER JOIN requestbox rb ON pr.product_id = rb.id
        WHERE rb.skillName = '$skillEscaped'
    ");
    $row = $res->fetch_assoc();
    $ratingsData[$skill] = [
        'avg' => round($row['avg_rating'] ?? 0, 1),
        'total' => $row['total_reviews'] ?? 0
    ];
}
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
            <?php if ($getUserAdmin == 1) echo '<li> <a href="./admin-pages/admin-dashbaord.html">Admin Dashboard</a> </li>' ?>
    </ul>
  </div>

  <div class="review-container">
    <h2>Leave a Review</h2>
    <?php if ($message) echo "<p class='message'>$message</p>"; ?>

    <form method="post">
        <label for="skill">Select Skill Request:</label>
        <select name="skill" id="skill" required>
            <option value="">--Choose a skill--</option>
            <?php foreach ($skills as $skill): ?>
                <option value="<?php echo htmlspecialchars($skill); ?>"><?php echo htmlspecialchars($skill); ?></option>
            <?php endforeach; ?>
        </select>

        <div class="star-rating">
            <input type="radio" name="rating" id="star5" value="5"><label for="star5">&#9733;</label>
            <input type="radio" name="rating" id="star4" value="4"><label for="star4">&#9733;</label>
            <input type="radio" name="rating" id="star3" value="3"><label for="star3">&#9733;</label>
            <input type="radio" name="rating" id="star2" value="2"><label for="star2">&#9733;</label>
            <input type="radio" name="rating" id="star1" value="1"><label for="star1">&#9733;</label>
        </div>

        <textarea name="review" placeholder="Write your review..." required></textarea>
        <button type="submit">Submit Review</button>
    </form>

    <h3>Skill Ratings:</h3>
    <ul>
        <?php foreach ($ratingsData as $skill => $data): ?>
            <li><?php echo htmlspecialchars($skill); ?>: <?php echo $data['avg']; ?> / 5 (<?php echo $data['total']; ?> reviews)</li>
        <?php endforeach; ?>
    </ul>
  </div>

</body>
</html>
