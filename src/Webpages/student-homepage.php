<?php
session_start();
include '../inc/dbconn.inc.php';

if (!isset($_SESSION['id'])) {
    header("Location: loginPages/studentLoginPage.php");
    exit();
}

$id = $_SESSION['id'];

$getUserDataStmt = $conn->prepare('SELECT credits, firstName FROM userdata WHERE id = ?');
$getUserDataStmt->bind_param('i', $id);
$getUserDataStmt->execute();
$result = $getUserDataStmt->get_result();
$row = $result->fetch_assoc();

$getUserImageStmt = $conn->prepare('SELECT imagePath FROM userdata WHERE id=?');
$getUserImageStmt->bind_param('i', $id);
$getUserImageStmt->execute();
$imagePath = $getUserImageStmt->get_result()->fetch_assoc()['imagePath'];
$getUserImageStmt->close();

$userCredits = $row ? $row['credits'] : 0;
$firstName = $row ? $row['firstName'] : '';

$getUserDataStmt->close();


// Fetch User's Admin Status
$getUserAdmin = 0;
$getUserAdminStmt = $conn->prepare('SELECT admin FROM userdata WHERE id=?');
$getUserAdminStmt->bind_param('i', $id);
$getUserAdminStmt->execute();
$getUserAdmin = $getUserAdminStmt->get_result();
  if ($row = $getUserAdmin->fetch_assoc()) {
    $getUserAdmin = $row['admin'];
  }
$getUserAdminStmt->close();

$conn->close();

?>

<!DOCTYPE html>
<html>
<head>
    <meta name="author" content="Lachlan">
    <meta charset="UTF-8" />
    <title>Student Homepage</title>
    <link rel="stylesheet" type="text/css" href="student-style.css">
</head>
<body>
    <div class="header">
        <img id="logo" src="../Webpages/images/Logo_Flinders_white.png" alt="Flinders University Logo">
        <div class="userprofile">
            <img id="userIcon" src="<?php echo $imagePath ?>" alt="Profile Picture"> <br>
            <p><?php echo htmlspecialchars($firstName); ?></p>
            <button onclick="location.href='./loginPages/logout.php'">Log out</button>
        </div>
    </div>

    <div class="navbarContainer">
         <ul class="navbar">
            <li><a class="active"href="student-homepage.php">Home</a></li>
            <li> <a  href="./inbox.php"> Inbox</a> </li>
            <li> <a href="./browsePage.php"> Browse Offered Skills</a> </li>
            <li> <a href="#Requests"> Make A Request</a> </li>
            <li> <a href="#ViewRequests">View My Requests</a> </li>
            <li> <a href="#BrowseRequests">Browse Requests</a> </li>
            <li> <a href="./studentProfile.php">My Profile</a> </li>
            <li> <a href="#History">Credit History</a> </li>
            <?php if ($getUserAdmin == 1) echo '<li> <a href="./admin-pages/admin-dashbaord.html">Admin Dashboard</a> </li>' ?>
        </ul>
    </div>
    
   <div id="content">
    <div class="creditsContainer">
         <ul class="credit">
             <li><h3>Current Credit Balance:</h3></li>
        </ul>
    </div>

    <div class="creditsContainer">
         <ul class="credits">
            <li>
                <h1>
                    <h1><?php echo htmlspecialchars($userCredits) . ' Credits'; ?></h1>
                </h1>
            </li>
        </ul>
    </div>
</div>


    <h1 style="margin-left: 220px; padding-left: 20px;">Urgent Actions</h1>

    <div class="container">
        <div class="inlinebox">
            <h2> Complete Request </h2>
            <h3> Body Text </h3>
            <div class="button">
            <button>Complete</button>
            </div>
        </div>
    </div>

    <ul class="pagination">
  <li><a href="#">&laquo;</a></li>
  <li><a class="active" href="#">1</a></li>
  <li><a href="#">2</a></li>
  <li><a href="#">3</a></li>
  <li><a href="#">4</a></li>
  <li><a href="#">5</a></li>
  <li><a href="#">&raquo;</a></li>
    </ul>

    <h1 style="margin-left: 220px; padding-left: 20px;">Notifications</h1>

    <div class="container">
        <div class="inlinebox">
            <h2> Subject </h2>
            <h3> Body Text </h3>
            <div class="button">
            <button>Dismiss</button>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="inlinebox">
            <h2> Subject </h2>
            <h3> Body Text </h3>
            <div class="button">
            <button>Dismiss</button>
            </div>
        </div>

    </div>

<ul class="pagination">
  <li><a href="#">&laquo;</a></li>
  <li><a class="active" href="#">1</a></li>
  <li><a href="#">2</a></li>
  <li><a href="#">3</a></li>
  <li><a href="#">4</a></li>
  <li><a href="#">5</a></li>
  <li><a href="#">&raquo;</a></li>
</ul>

</div>
</body>
</html>