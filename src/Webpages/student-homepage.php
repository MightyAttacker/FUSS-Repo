<?php
session_start(); // Start session to access logged-in user info
include '../inc/dbconn.inc.php';

// Ensure the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: loginPages/login.php");
    exit();
}

$id = $_SESSION['id'];

// Get credits for the user
$getUserCreditStmt = $conn->prepare('SELECT credits FROM userdata WHERE id = ?');
$getUserCreditStmt->bind_param('i', $id);
$getUserCreditStmt->execute();
$result = $getUserCreditStmt->get_result();
$row = $result->fetch_assoc();

$userCredits = $row ? $row['credits'] : 0; // Fallback to 0 if not found
$getUserCreditStmt->close();
$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Student Homepage</title>
    <link rel="stylesheet" type="text/css" href="student-style.css">
</head>
<body>
    <div class="header">
        <img id="logo" src="../Webpages/images/Logo_Flinders_white.png" alt="Flinders University Logo">
        <div class="userprofile">
            <img id="userIcon" src="../Webpages/images/usericon.png" alt="User Icon">
            <p>User name</p>
            <button onclick="location.href='./loginPages/logout.php'">Log out</button>
        </div>
    </div>

    <div class="navbarContainer">
         <ul class="navbar">
            <li><a class="active"href="student-homepage.html">Home</a></li>
            <li> <a href="./inbox.php"> Inbox</a> </li>
            <li> <a href="#Requests"> Make A Request</a> </li>
            <li> <a href="#ViewRequests">View My Requests</a> </li>
            <li> <a href="#BrowseRequests">Browse Requests</a> </li>
            <li> <a href="./studentProfile.php">My Profile</a> </li>
            <li> <a href="#History">Credit History</a> </li>
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
                    <?php echo $userCredits . ' Credits'; ?>
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

    <h1 style="margin-left: 220px; padding-left: 20px;">New Messages</h1>

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