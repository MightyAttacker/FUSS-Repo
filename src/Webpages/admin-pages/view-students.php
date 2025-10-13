<?php
include ("../../inc/dbconn.inc.php");
session_start();
$id = $_SESSION["id"];

// Fetch the user's first name
$getfirstNamestmt = $conn->prepare('SELECT firstName FROM userdata WHERE id=?');
$getfirstNamestmt->bind_param('i', $id);
$getfirstNamestmt->execute();
$firstName = $getfirstNamestmt->get_result()->fetch_assoc()['firstName'];
$getfirstNamestmt->close();

// Fetch the user's profile image path
$getimagePathstmt = $conn->prepare('SELECT imagePath FROM userdata WHERE id=?');
$getimagePathstmt->bind_param('i', $id);
$getimagePathstmt->execute();
$imagePath = $getimagePathstmt->get_result()->fetch_assoc()['imagePath'];
$getimagePathstmt->close();


if (isset($_GET['search'])) {
    $search = '%' . $_GET['search'] . '%';
    $getStudentsStmt = $conn->prepare('
        SELECT id, firstName, lastName, credits, email, last_active, Suspended, SuspendedUntil, Deleted, admin,
        CASE WHEN admin = 1 THEN "Admin" ELSE "User" END AS adminType,
            CASE WHEN Deleted = 1 THEN "Deleted" 
                WHEN Suspended = 1 THEN "Suspended"        
                ELSE "Active"
                END AS accountStatus       
        FROM userdata
        WHERE id LIKE ? OR firstName LIKE ? OR lastName LIKE ? OR Suspended LIKE ? OR Deleted LIKE ? OR admin LIKE ?
        ORDER BY lastName ASC
    ');
    $getStudentsStmt->bind_param('ssssss', $search,$search,$search,$search, $search, $search);
    $getStudentsStmt->execute();
    $studentsResult = $getStudentsStmt->get_result();

    while ($student = $studentsResult->fetch_assoc()) {
        echo '<tr>'; 
        echo '<td>' . htmlspecialchars($student['firstName'] . ' ' . $student['lastName']) . '</td>';
        echo '<td>' . htmlspecialchars($student['id']) . '</td>';       
        echo '<td>' . htmlspecialchars($student['email']) . '</td>';
        echo '<td>' . htmlspecialchars($student['credits']) . '</td>';
        echo '<td>
            <form action="adjustCredits.php" method="post" style="display:inline;">
                <input type="number" id="newCredits" name="newCredits" value="' . htmlspecialchars($student['credits']) . '" min="0">
                <input type="hidden" name="studentId" value="' . htmlspecialchars($student['id']) . '">
                <button type="submit">Update</button>
            </form>
          </td>';
        echo '<td>' . htmlspecialchars($student['last_active']) . '</td>';
        echo '<td><a href="../studentProfile.php?id=' . $student['id'] . '">View Profile</a></td>';
        echo '<td>'. htmlspecialchars($student['adminType']) . '</td>';
        echo '<td>'. htmlspecialchars($student['accountStatus']) . " " . htmlspecialchars($student['SuspendedUntil']). '</td>';
        echo '<td> 
            <form action="suspendUser.php" method="post" style="display:inline;">
                <input type="date" id="suspendDate" name="suspendDate">
                <input type="hidden" name="studentId" value="' . htmlspecialchars($student['id']) . '">
                <button class="button" type="submit">Suspend</button>
            </form>
            </td>';
            echo '<td> 
            <form action="deleteUser.php" method="post" style="display:inline;">
                <input type="hidden" name="studentId" value="' . htmlspecialchars($student['id']) . '">
                <button class="button" type="submit">Delete</button>
            </form> 
            </td>';    
               
        echo '</tr>';
    }
    $getStudentsStmt->close();
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="Author" content="Liam Maney, Jayden Putland">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="viewStudents.js"></script>
</head>
<body>
    <div class="header">
        <img id="logo" src="../admin-pages/images/Logo_Flinders_white.png" alt="Flinders University Logo">
        <div class="userprofile">
            <img id="userIcon" src="../<?php echo $imagePath ?>" alt="User Icon">
            <p><?php echo 'Welcome ' . $firstName . '!' ?></p>
            <a href="../loginPages/logout.php"><button id="logOutButton">Log out</button></a>
        </div>
        
    </div>

    <div id="sideBar">
    <ul class="sidebar">
            <li><a href="admin-dashboard.html">Home</a></li>
            <li><a href="profile.html">Profile</a></li>
            <li><a class="active" href="view-students.php">View Students</a></li>
            <li><a href="manage-skill-list.html">Manage Skill List</a></li>
            <li><a href="view-reports.html">View Reports</a></li>
            <li><a href="../student-homepage.php">Student Homepage</a></li>
        </ul>
  </div>

    <div class="body">
        <div>
            <!-- look at assignment sheet and see what needs to be here-->
            <h1>View Students</h1>
            <input type="text" id="searchInput" placeholder="Search by name or ID">
            
        <Table id="studentsTable">
        <tr>
        <th>Name</th>
        <th>ID</th>
        <th>Email</th>
        <th>Credits</th>
        <th>Adjust Credits</th>
        <th>Last Active</th>
        <th>Profile Link</th>
        <th>Admin</th>
        <th>Account Status</th>
        <th>Suspend Until</th>
        <th>Delete</th>
        
        
        </tr>

            <tbody id="studentTableBody">
            <?php

            $rowsPerPage = 10; // Number of rows per page
            $page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
            $offset = ($page - 1) * $rowsPerPage;
            // Get total number of students for pagination
            $countStmt = $conn->prepare('
            SELECT COUNT(*) as total FROM userdata
            
            ');
            $countStmt->execute();
            $totalResult = $countStmt->get_result();
            $totalRows = $totalResult->fetch_assoc()['total'];
            $countStmt->close();

            $totalPages = ceil($totalRows / $rowsPerPage);
            // Fetch students with limit and offset for pagination
            $studentStmt = $conn->prepare('
            SELECT id, firstName, lastName, credits, email, last_active, Suspended, SuspendedUntil, Deleted, admin, 
            CASE WHEN admin = 1 THEN "Admin" ELSE "User" END AS adminType,
            CASE WHEN Deleted = 1 THEN "Deleted" 
                WHEN Suspended = 1 THEN "Suspended"        
                ELSE "Active"
                END AS accountStatus
            
            FROM userdata
            ORDER BY lastName ASC
            LIMIT ? OFFSET ?
            ');
            $studentStmt->bind_param('ii', $rowsPerPage, $offset);
            $studentStmt->execute();
            $studentResult = $studentStmt->get_result();
            if (!isset($_GET['search'])) {                
                while ($student = $studentResult->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($student['firstName'] . ' ' . $student['lastName']) . '</td>';
                    echo '<td>' . htmlspecialchars($student['id']) . '</td>';                   
                    echo '<td>' . htmlspecialchars($student['email']) . '</td>';
                    echo '<td>' . htmlspecialchars($student['credits']) . '</td>';
                    echo '<td>
            <form action="adjustCredits.php" method="post" style="display:inline;">
                <input type="number" id="newCredits" name="newCredits" value="' . htmlspecialchars($student['credits']) . '" min="0">
                <input type="hidden" name="studentId" value="' . htmlspecialchars($student['id']) . '">
                <button class="button" type="submit">Update</button>
            </form>
          </td>';
                    echo '<td>' . htmlspecialchars($student['last_active']) . '</td>';
                           
                    echo '<td><a href="../studentProfile.php?id=' . $student['id'] . '">View Profile</a></td>';
                    echo '<td>'. htmlspecialchars($student['adminType']) . '</td>';
                    echo '<td>'. htmlspecialchars($student['accountStatus']) . " " . htmlspecialchars($student['SuspendedUntil']). '</td>';
                    echo '<td> 
            <form action="suspendUser.php" method="post" style="display:inline;">
                <input type="date" id="suspendDate" name="suspendDate">
                <input type="hidden" name="studentId" value="' . htmlspecialchars($student['id']) . '">
                <button class="button" type="submit">Suspend</button>
            </form>
            </td>';
            echo '<td> 
            <form action="deleteUser.php" method="post" style="display:inline;" onsubmit="return confirm("Are you sure you want to delete this user?");">
                <input type="hidden" name="studentId" value="' . htmlspecialchars($student['id']) . '">
                <button class="button" type="submit">Delete</button>
            </form> 
            </td>';     
            echo '</tr>';
                }
             }
            $studentStmt->close();
            ?>
    </tbody>
    </Table>
        </div>
        <?php if ($totalPages > 1 && (empty($_GET['search']) || !isset($_GET['search']))): ?>
  <div class="pagination">
    <?php for ($p = 1; $p <= $totalPages; $p++): ?>
      <a href="?page=<?php echo $p; ?>"<?php if ($p == $page) echo ' class="active"'; ?>><?php echo $p; ?></a>
    <?php endfor; ?>
  </div>
<?php endif; ?>
    </div>
</body>
</html>