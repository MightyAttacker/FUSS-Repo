<?php
session_start();

if (!isset($_SESSION['id'])) {

  session_unset();
  session_destroy();

  header('location: ./loginPages/studentLoginPage.php');

} else {
  // session logged
}
//getting a user profile based on id passed in URL, if no id passed then show logged in user profile

$id = $_SESSION['id'];
$uid = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : $_SESSION['id'];

include '../inc/dbconn.inc.php';

// Fetch the logged user's first name
$getloggedFirstNamestmt = $conn->prepare('SELECT firstName FROM userdata WHERE id=?');
$getloggedFirstNamestmt->bind_param('i', $id);
$getloggedFirstNamestmt->execute();
$loggedFirstName = $getloggedFirstNamestmt->get_result()->fetch_assoc()['firstName'];
$getloggedFirstNamestmt->close();

// Fetch the logged in user's FussCredits
$getUserCreditStmt = $conn->prepare('SELECT credits FROM userdata WHERE id=?');
$getUserCreditStmt->bind_param('i', $id);
$getUserCreditStmt->execute();
$loggedUserCredits = $getUserCreditStmt->get_result()->fetch_assoc()['credits'];
$getUserCreditStmt->close();
 

// Handle search functionality for table
if (isset($_GET['search'])) {
    $search = '%' . $_GET['search'] . '%';
    $getSkillsStmt = $conn->prepare('
        SELECT 
        userdata.academicYear, 
        userdata.firstName, 
        userdata.availability, 
        userdata.lastName, 
        skills.skillName, 
        userdata.id,
        CASE WHEN skills.academic = 1 THEN "Academic" ELSE "Non-Academic" END AS academicType
        FROM skills
        JOIN userskills ON skills.skillName = userskills.skillName
        JOIN userdata ON userskills.id = userdata.id
        WHERE userdata.id != ? AND (
            skills.skillName LIKE ? OR
            userdata.firstName LIKE ? OR
            userdata.lastName LIKE ? OR
            CASE WHEN skills.academic = 1 THEN "Academic" ELSE "Non-Academic" END LIKE ? OR
            userdata.availability LIKE ?
        )
        ORDER BY skills.skillName ASC
    ');
    $getSkillsStmt->bind_param('isssss', $id, $search, $search, $search, $search, $search);
    $getSkillsStmt->execute();
    $skillsResult = $getSkillsStmt->get_result();

    while ($skill = $skillsResult->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($skill['skillName']) . '</td>';
        echo '<td>' . htmlspecialchars($skill['firstName'] . ' ' . $skill['lastName']) . ' Year ' . $skill['academicYear'] . ' student' . '</td>';
        echo '<td>' . htmlspecialchars($skill['academicType']) . '</td>';
        echo '<td>' . $skill['availability'] . '</td>';
        echo '<td><a href="./studentProfile.php?id=' . $skill['id'] . '">View Profile</a></td>';
        echo '</tr>';
    }
    $getSkillsStmt->close();
    exit;
  }
?>

<!DOCTYPE html>
<html lang="en-AU">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="browsePage.css">
  <script src="browsePage.js"></script>
  <meta name="author" content="Jayden">

  <title>FUSS Browse Offered Skills</title>
</head>

<body>
  <div id="topBanner">
    <div id="flindersLogo">
      <img id="imgLogo" src="./images/Logo_Flinders_white.png" alt="Logo for Flinders University" id="flindersLogo">
    </div>
    <div id="title">
      <header>
        <h1>Flinders University Skill Share</h1>
      </header>
    </div>
    <div id="UserDetails">
      <h4> <a id="profileLink" href="./studentProfile.php">
          <?php echo "Hello, " . $loggedFirstName . "<br>" . "You have " . $loggedUserCredits . " Credits!" ?> </a></h4>

    </div>
    <div id="logoutButton">
      <input id="logButton" class="button" type="button" onclick="location.href='./loginPages/logout.php';"
        value="Logout" />
    </div>
  </div>

  <div id="sideBar">
    <ul class="sidebar">
      <li> <a href="./student-homepage.html">Home</a> </li>
      <li> <a href="./inbox.php"> Inbox</a> </li>
      <li> <a class="active" href="./browsePage"> Browse Offered Skills</a> </li>
      <li> <a href="#Requests"> Make A Request</a> </li>
      <li> <a href="#ViewRequests">View My Requests</a> </li>
      <li> <a href="#BrowseRequests">Browse Requests</a> </li>
      <li> <a href="./studentProfile.php">My Profile</a> </li>
      <li> <a href="#History">Credit History</a> </li>
    </ul>
  </div>

  <main>
    <h2>Browse Skills Offered by Other Students</h2>
    <input type="text" id="searchInput" placeholder="Search..">
    <table id="skillsTable">
      <tr>
        <th>Skill Name</th>
        <th>Offered By</th>
        <th>Skill Type</th>
        <th>Offerer's Availability </th>
        <th>Contact</th>
      </tr>
      <tbody id="skillsTableBody">
        //outputting the table
      <?php
        $rowsPerPage = 10; // Number of rows per page
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
        $offset = ($page - 1) * $rowsPerPage;

      // Get total number of skills for pagination
      $countStmt = $conn->prepare('
            SELECT COUNT(*) as total FROM skills
            JOIN userskills ON skills.skillName = userskills.skillName
            JOIN userdata ON userskills.id = userdata.id WHERE userdata.id != ?
    ');
      $countStmt->bind_param('i', $id);
      $countStmt->execute();
      $totalResult = $countStmt->get_result();
      $totalRows = $totalResult->fetch_assoc()['total'];
      $countStmt->close();

      $totalPages = ceil($totalRows / $rowsPerPage);

      // Fetch skills for current page
      $getSkillsStmt = $conn->prepare('
    SELECT userdata.academicYear, userdata.firstName, userdata.availability, userdata.lastName, skills.skillName, skills.academic, userdata.id
    FROM skills
    JOIN userskills ON skills.skillName = userskills.skillName
    JOIN userdata ON userskills.id = userdata.id
    WHERE userdata.id != ?
    ORDER BY skills.skillName ASC
    LIMIT ? OFFSET ?
    ');
      $getSkillsStmt->bind_param('iii', $id, $rowsPerPage, $offset);
      $getSkillsStmt->execute();
      $skillsResult = $getSkillsStmt->get_result();
          if (!isset($_GET['search'])) {
      while ($skill = $skillsResult->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($skill['skillName']) . '</td>';
        echo '<td>' . htmlspecialchars($skill['firstName'] . ' ' . $skill['lastName']) . ' Year ' . $skill['academicYear'] . ' student' . '</td>';
        if ($skill['academic'] == '1') {
          echo '<td>' . 'Academic' . '</td>';
        } else {
          echo '<td>' . 'Non-Academic' . '</td>';
        }
        echo '<td>' . $skill['availability'] . '</td>';
        echo '<td><a href="./studentProfile.php?id=' . $skill['id'] . '">View Profile</a></td>';
        echo '</tr>';
      }
      }
      $getSkillsStmt->close();
      
   
      ?>    
    </tbody>
    </table>
<?php if ($totalPages > 1 && (empty($_GET['search']) || !isset($_GET['search']))): ?>
  <div class="pagination">
    <?php for ($p = 1; $p <= $totalPages; $p++): ?>
      <a href="?page=<?php echo $p; ?>"<?php if ($p == $page) echo ' class="active"'; ?>><?php echo $p; ?></a>
    <?php endfor; ?>
  </div>
<?php endif; ?>
  </main>