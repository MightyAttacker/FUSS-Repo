<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    if (isset($_SESSION["id"])) {
        $id = $_SESSION["id"];
    }
    $id = "testuser1";
    require_once "../inc/dbconn.inc.php";
    ?>
    <meta charset="UTF-8">
    <meta name="author" content="Thomas Wachmer">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
    <script type="module" src="/Scripts/account-page-script.js" defer></script>
    <script type="module" src="/Scripts/account-page-availability.js" defer></script>
    <script type="module" src="/Scripts/account-page-submit.js" defer></script>
    <link rel="stylesheet" href="/Styles/account-page-styles.css">
    <link rel="icon" href="data:,">

</head>

<body>
<div id="banner">
    <div id="flindersLogo">
        <img src="images/Logo_Flinders_white.png" alt="Logo for Flinders University" id="flindersLogo">
    </div>
    <div id="header">

        <h1>Flinders University Skill Share</h1>

    </div>
    <div id="logoutButton">
        <input id="logButton" class="button" type="button"
               onclick="location.href='../studentLoginPage/studentLoginPage.html';" value="Logout"/>
    </div>
</div>
<div id="sidebar">
    <ul class="sidebar">
        <li><a href="#home">Home</a></li>
        <li><a class="active" href="#Requests"> Make A Request</a></li>
        <li><a href="#ViewRequests">View My Requests</a></li>
        <li><a href="#BrowseRequests">Browse Requests</a></li>
        <li><a href="account.php">Manage Profile</a></li>
        <li><a href="#History">History</a></li>
    </ul>
</div>
<h2 id="title">Change profile information and availability</h2>
<main>

    <div id="information">

        <p>My Course:</p>
        <input
                type="text"
                required
                name="course"
                class="text-input input"
                id="course"
                value=<?php
        $stmt = $conn->prepare("SELECT course FROM users WHERE id = ?");
        $stmt->bind_param("s", $id);

        $stmt->execute();

        foreach (mysqli_stmt_get_result($stmt) as $key => $value) {
            echo htmlspecialchars($value["course"]);
        }
        ?>>
        <br>
        <br>

        <p>About Me:</p>
        <textarea
                type="text"
                name="about"
                class="textarea input text-input"
                id="about"
                rows=10
                cols=30><?php
            $stmt = $conn->prepare("SELECT about FROM users WHERE id = ?");

            $stmt->bind_param("s", $id);
            $stmt->execute();

            foreach (mysqli_stmt_get_result($stmt) as $key => $value) {
                echo htmlspecialchars($value["about"]);
            }

            ?></textarea>
        <br>
        <br>

        <p>My Academic Skills</p>
        <select name="aSkills"
                class="dropdown input"
                id="askills">
            <?php
            echo "<option value=\"\">Select Skills</option>";
            $stmt = $conn->prepare("SELECT skill FROM skills WHERE academic = 1");

            $stmt->execute();

            foreach (mysqli_stmt_get_result($stmt) as $k => $v) {
                $a = htmlspecialchars($v["skill"]);
                echo "<option value=\"$a\">$a</option>";
            }
            ?>
        </select>
        <br>
        <br>
        <div id="academic-skills">
            <?php
            $stmt = $conn->prepare("SELECT skills.skill
                FROM skills JOIN userskills u on skills.skill = u.skill 
                WHERE academic = 1 AND userid = ?");

            $stmt->bind_param("s", $id);
            $stmt->execute();

            foreach (mysqli_stmt_get_result($stmt) as $k => $v) {
                $b = htmlspecialchars(implode($v));
                // Could combine all calls into one script. Only needs to be done if there is spare time
                echo "<script type=\"module\"> 
                        import {createButton} from \"/Scripts/account-page-script.js\";
                        createButton(\"$b\", true); </script>";
            }
            ?>
        </div>

        <p>My Non-Academic Skills</p>
        <select name="naSkills"
                class="dropdown input"
                id="naskills">

            <?php
            echo "<option value=\"\">Select Skills</option>";

            $stmt = $conn->prepare("SELECT skill FROM skills WHERE academic = 0");
            $stmt->execute();

            foreach (mysqli_stmt_get_result($stmt) as $k => $v) {
                $a = htmlspecialchars($v["skill"]);
                echo "<option value=\"$a\">$a</option>";
            }
            ?>
        </select>
        <br>
        <br>
        <div id="non-academic-skills">

            <?php
            $stmt = $conn->prepare("SELECT skills.skill
                FROM skills JOIN userskills u on skills.skill = u.skill 
                WHERE academic = 0 AND userid = ?");

            $stmt->bind_param("s", $id);
            $stmt->execute();

            foreach (mysqli_stmt_get_result($stmt) as $k => $v) {
                $b = htmlspecialchars(implode($v));
                // Could combine all calls into one script. Only needs to be done if there is spare time
                echo "<script type=\"module\"> 
                        import {createButton} from \"/Scripts/account-page-script.js\";
                        createButton(\"$b\", false); </script>";
            }
            ?>
        </div>

        <br>

        <input id="submit" type="submit" value="Confirm Changes">
        <br>

        <button
                name="availability"
                id="changeavailability"
                class="button">Change availability
        </button>

        <div id="availability-popup" class="popup hidden">
            <button name="by-day"
                    id="daily"
                    class="button popup">By Day
            </button>
            <br>
            <button name="by-week"
                    id="weekly"
                    class="button popup">By Week
            </button>
        </div>
    </div>


    <div id="availability">

    </div>
</main>
</body>

</html>