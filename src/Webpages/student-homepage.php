<?php
session_start();
include '../inc/dbconn.inc.php';

if (!isset($_SESSION['id'])) {
    header("Location: loginPages/studentLoginPage.php");
    exit();
}

$id = $_SESSION['id'];

// 1. Fetch user data
$getUserDataStmt = $conn->prepare(
    'SELECT credits, firstName, email, imagePath FROM userdata WHERE id = ?'
);
$getUserDataStmt->bind_param('i', $id);
$getUserDataStmt->execute();
$result = $getUserDataStmt->get_result();
$userData = $result->fetch_assoc();

$userCredits = $userData['credits'] ?? 0;
$firstName   = $userData['firstName'] ?? '';
$email       = $userData['email'] ?? '';
$imagePath   = $userData['imagePath'] ?? '';

$getUserDataStmt->close();

// 2. Fetch notifications using email
$getNotificationsStmt = $conn->prepare(
    'SELECT subject, message FROM mailbox WHERE sentto = ? ORDER BY created DESC'
);
$getNotificationsStmt->bind_param('s', $email);
$getNotificationsStmt->execute();
$notificationsResult = $getNotificationsStmt->get_result();
$notifications = $notificationsResult->fetch_all(MYSQLI_ASSOC);
$getNotificationsStmt->close();

// Function to truncate messages
function truncateText($text, $limit = 100) {
    return strlen($text) > $limit ? substr($text, 0, $limit) . '...' : $text;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="author" content="Lachlan">
    <meta charset="UTF-8" />
    <title>Student Homepage</title>
    <link rel="stylesheet" type="text/css" href="student-style.css">
    <style>
      .inlinebox {
          background-color: #f0f0f0;
          border-radius: 10px;
          padding: 15px 20px;
          box-shadow: 0 4px 8px rgba(0,0,0,0.1);
          transition: transform 0.2s, box-shadow 0.2s;
          margin-bottom: 10px;
      }
      .inlinebox h2 { margin: 0 0 5px 0; color: #002F60; }
      .inlinebox h3 { margin: 0; color: #333; }
      .inlinebox .button { margin-top: 10px; }
      .inlinebox button {
          background-color: #002F60;
          color: #fff;
          border: none;
          border-radius: 5px;
          padding: 6px 12px;
          cursor: pointer;
          transition: background-color 0.2s, transform 0.2s;
      }
      .inlinebox button:hover { background-color: #0055A5; transform: translateY(-2px); }

      .pagination {
        display: flex;
        justify-content: center;
        list-style: none;
        padding: 0;
        margin-top: 10px;
      }
      .pagination li a {
        display: block;
        padding: 6px 10px;
        margin: 0 4px;
        border: 1px solid gray;
        color: black;
        border-radius: 5px;
        text-decoration: none;
        cursor: pointer;
      }
      .pagination li a.active {
        background-color: #002F60;
        color: white;
      }
    </style>
</head>
<body>
<div class="header">
    <img id="logo" src="../Webpages/images/Logo_Flinders_white.png" alt="Flinders University Logo">
    <div class="userprofile">
        <img id="userIcon" src="<?php echo $imagePath ?>" alt="Profile Picture">
        <p><?php echo htmlspecialchars($firstName); ?></p>
        <button onclick="location.href='./loginPages/logout.php'">Log out</button>
    </div>
</div>

<div class="navbarContainer">
    <ul class="navbar">
        <li><a class="active" href="student-homepage.php">Home</a></li>
        <li><a href="./inbox.php">Inbox</a></li>
        <li><a href="./browsePage.php">Browse Offered Skills</a></li>
        <li><a href="#Requests">Make A Request</a></li>
        <li><a href="#ViewRequests">View My Requests</a></li>
        <li><a href="#BrowseRequests">Browse Requests</a></li>
        <li><a href="./studentProfile.php">My Profile</a></li>
        <li><a href="#History">Credit History</a></li>
    </ul>
</div>

<h1 class="section-title">Urgent Actions</h1>
<div id="urgentContainer" class="container">
    <div class="inlinebox">
        <h2>Complete Request</h2>
        <h3><?php echo truncateText("This is the body of the urgent action message which may be very long and needs truncation.", 100); ?></h3>
        <div class="button"><button class="completeBtn">Complete</button></div>
    </div>
    <div class="inlinebox">
        <h2>Another Action</h2>
        <h3><?php echo truncateText("Another example of an urgent action that is long and will be truncated for display.", 100); ?></h3>
        <div class="button"><button class="completeBtn">Complete</button></div>
    </div>
</div>
<ul id="urgentPagination" class="pagination"></ul>

<h1 class="section-title">Notifications</h1>
<div id="notificationContainer" class="container">
<?php foreach ($notifications as $notification): ?>
    <div class="inlinebox">
        <h2><?php echo htmlspecialchars($notification['subject']); ?></h2>
        <h3><?php echo truncateText($notification['message'], 100); ?></h3>
    </div>
<?php endforeach; ?>
</div>
<ul id="notificationPagination" class="pagination"></ul>

<script>
  // Complete button removes its box
  document.querySelectorAll('.completeBtn').forEach(btn => {
      btn.addEventListener('click', () => {
          const box = btn.closest('.inlinebox');
          if (box) box.remove();
          paginateContainer('urgentContainer', 'urgentPagination', 4);
      });
  });

  function paginateContainer(containerId, paginationId, itemsPerPage) {
      const container = document.getElementById(containerId);
      const boxes = Array.from(container.querySelectorAll('.inlinebox'));
      const pagination = document.getElementById(paginationId);
      const totalPages = Math.ceil(boxes.length / itemsPerPage);

      if (totalPages <= 1) {
          boxes.forEach(b => b.style.display = 'block');
          pagination.innerHTML = '';
          return;
      }

      let currentPage = 1;

      function showPage(page) {
          currentPage = page;
          boxes.forEach((box, index) => {
              box.style.display = (index >= (page-1)*itemsPerPage && index < page*itemsPerPage) ? 'block' : 'none';
          });

          pagination.innerHTML = '';
          for (let i=1; i<=totalPages; i++) {
              const li = document.createElement('li');
              const a = document.createElement('a');
              a.textContent = i;
              a.className = i === page ? 'active' : '';
              a.addEventListener('click', () => showPage(i));
              li.appendChild(a);
              pagination.appendChild(li);
          }
      }

      showPage(1);
  }

  paginateContainer('urgentContainer', 'urgentPagination', 4);
  paginateContainer('notificationContainer', 'notificationPagination', 4);
</script>

<?php $conn->close(); ?>
</body>
</html>
