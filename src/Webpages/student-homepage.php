<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get credits for the user 
$sql = "SELECT credits FROM users WHERE id = 'testuser1'";
$result = $conn->query($sql);

// Fetch credit value
$credits = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $credits = $row['credits'];
}

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
            <button>Log out</button>
        </div>
        
    </div>

    <div class="navbarContainer">
         <ul class="navbar">
            <li><a class="active"href="student-homepage.html">Home</a></li>
            <li><a href="#">Make Request</a></li>
            <li><a href="#">View My Requests</a></li>
            <li><a href="#">Browse Requests</a></li>
            <li><a href="#">Manage Profile</a></li>
            <li><a href="#">History</a></li>
        </ul>
    </div>
    
    <div id="content">
    <div class="creditContainer">
         <ul class="credit">
             <li><h3>Current Credit Balance: <?php echo $credits; ?></h3></li>
        </ul>
    </div>
    <div id="content">

    <div class="creditsContainer">
         <ul class="credits">
            <li><h1><a class="activeCredit"href=""> Credits</a></h1></li>
        </ul>
    </div>
    <div id="content">

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