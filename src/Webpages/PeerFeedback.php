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
<style>
body { font-family: Helvetica, Arial, sans-serif; margin:0; padding:0; }
#topBanner { background-color:#002F60; color:#FFD300; padding:10px; display:flex; align-items:center; justify-content:space-between; }
#flindersLogo img { height:80px; }
#sideBar { list-style:none; background:#002F60; color:#FFD300; padding:0; width:200px; height:100vh; position:fixed; }
#sideBar li a { display:block; color:#FFD300; padding:10px; text-decoration:none; font-weight:bold; }
#sideBar li a.active, #sideBar li a:hover { background:#FFD300; color:#002F60; }
.review-container { margin-left:220px; padding:20px; max-width:600px; }
.star-rating { display:flex; flex-direction:row-reverse; font-size:2em; justify-content:flex-start; cursor:pointer; }
.star-rating input { display:none; }
.star-rating label { color:#ccc; transition:color 0.2s; }
.star-rating input:checked ~ label, .star-rating label:hover, .star-rating label:hover ~ label { color:#FFD300; }
textarea { width:100%; height:80px; margin-top:10px; padding:8px; border-radius:5px; border:1px solid #ccc; resize:none; }
button { margin-top:10px; padding:10px 15px; background:#002F60; color:#fff; border:none; border-radius:5px; cursor:pointer; }
button:hover { background:#0055A5; }
.message { color:green; }
</style>
</head>
<body>

<div id="topBanner">
    <div id="flindersLogo"><img src="./images/Logo_Flinders_white.png" alt="Flinders University"></div>
    <div>Hello, <?php echo htmlspecialchars($firstName); ?></div>
    <div><button onclick="location.href='./loginPages/logout.php';">Logout</button></div>
</div>

<ul id="sideBar">
    <li><a class="active" href="./student-homepage.php">Home</a></li>
    <li><a href="./inbox.php">Inbox</a></li>
    <li><a href="./browsePage.php">Browse Skills</a></li>
    <li><a href="./studentProfile.php">My Profile</a></li>
</ul>

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
