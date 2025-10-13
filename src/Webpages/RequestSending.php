<!DOCTYPE html>
<html lang="en-AU">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Styles/request-sending-style.css">
    <title>FUSS Request Page</title>
    <script type="module" src="/Scripts/request-sending-submit.js" defer></script>
</head>

<body>
<div id="topBanner">
    <div id="flindersLogo">
        <img src="images/Logo_Flinders_white.png" alt="Logo for Flinders University" id="flindersLogo">
    </div>
    <div id="header">
        <header>
            <h1>Flinders University Skill Share</h1>
        </header>
    </div>
    <div id="logoutButton">
        <input id="logButton" class="button" type="button"
               onclick="location.href='../studentLoginPage/studentLoginPage.html';" value="Logout"/>
    </div>
</div>

<div id="sideBar">
    <ul class="sidebar">
        <li><a href="#home">Home</a></li>
        <li><a class="active" href="#Requests"> Make A Request</a></li>
        <li><a href="#ViewRequests">View My Requests</a></li>
        <li><a href="#BrowseRequests">Browse Requests</a></li>
        <li><a href="changeAvailability.php">Manage Profile</a></li>
        <li><a href="#History">History</a></li>
    </ul>
</div>

<main>
    <div id="Header">
        Create Service Request
    </div>
    <div id="requestForm">

        <div id="titleDiv">
            <label for="title">Title</label> <br>
            <input id="title" type="text" name="Title" placeholder="Title">
        </div>

        <div id="Providername">
            <p>Provider: <b> <?php
                    require_once "../inc/dbconn.inc.php";
                    $stmt = $conn->prepare("SELECT firstName FROM userdata WHERE id = 2");
                    $stmt->execute();
                    foreach (mysqli_stmt_get_result($stmt) as $key => $value) {
                        echo htmlspecialchars($value["firstName"]);
                    }
                    ?> </b></p>
        </div>

        <div id="dateAndTime">
            <label for="datetimelocal"> Date and Time </label> <br>
            <input class="dateAndTime" type="datetime-local" id="datetimelocal"> <br>
        </div>

        <div id="credits">

            <label for="offered_Credits">Credits Offered</label> <br>
            <input id="offered_Credits" type="number" name="offered_Credits" placeholder="1">
            <br>
            Current Credit Balance: <?php
            require_once "../inc/dbconn.inc.php";
            $stmt = $conn->prepare("SELECT credits FROM users WHERE id = 'testuser1'");
            $stmt->execute();
            foreach (mysqli_stmt_get_result($stmt) as $key => $value) {
                echo $value["credits"];
            }
            ?>

        </div>
        <div id="notesDiv">
            <label for="notes">Notes</label> <br>
            <input id="notes" type="text" name="Notes" placeholder="Notes...">
        </div>
        <div id="CourseSection">
            <div id="CourseRelated">
                <div>
                    <input type="radio" class="courseRadioButton" name="CourseChoice" value="Course Related" id="Radio">
                    <label for="Radio">Course Related </label> <br>
                </div>
                <div>
                    <input type="radio" class="courseRadioButton" name="CourseChoice" value="Not Course Related"
                           id="nonRadio">
                    <label for="nonRadio">Not Course Related </label><br>
                </div>
            </div>

            <div id="CourseSelection">

            </div>
        </div>
        <div id="submitButtons">
            <button id="submit" type="button" class="button"> Submit Request</button>
            <button id="clear" type="reset" class="button"> Clear</button>
        </div>
    </div>
    <div id="calanderWidget">
        Calander goes here
    </div>
</main>
</body>

</html>