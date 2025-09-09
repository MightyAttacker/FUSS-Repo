<!DOCTYPE html>

<head>
    <!--Files to include in project:
- Flinders logo
- Default account image

- Place to upload profile pictures-->
    <!DOCTYPE html>
    <!--<meta> -->
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My Account</title>
        <script src="../Scripts/account-page-script.js" defer>
            // TODO: Use beforeunload
            // from https://developer.mozilla.org/en-US/docs/Web/API/Window/beforeunload_event
        </script>
        <script src="../Scripts/account-page-availability.js" defer> </script>
        <link rel="stylesheet" href="../Styles/styles.css">
        <?php
        require_once "../inc/dbconn.inc.php";

        // $sql = "SELECT * FROM test;";
        // if ($result = mysqli_query($conn, $sql)) {
        //     if (mysqli_num_rows($result) > 0) {
        //         while ($row = mysqli_fetch_assoc($result)) {
        //             echo implode(", ", $row);
        //         }

        //     }
        //     mysqli_free_result($result);
        // }
        // $result = mysqli_fetch_assoc(mysqli_query($conn, $sql));
        // echo "<ul>";
        // if ($result) {
        //     foreach ($result as $k => $v) {
        //         echo "<li>$k: $v </li>";
        //     }
        // }
        // echo "</ul>";
        // echo $result["description"];


        ?>
    </head>

<body>
    <div id="sidebar">
        <a href="../index.php">Test</a>
    </div>

    <div class="spacing"></div>

    <div id="main">
        <form action="update-details.php"
            method="post"
            id="form"
            class="form">


            <p>My Course:</p>
            <input
                type="text"
                required
                name="course"
                class="text-input input"
                id="course"
                value=<?php echo "Test2"; ?>>
            <br>
            <br>

            <p>About Me:</p>
            <textarea
                type="text"
                name="about"
                class="textarea input text-input"
                id="about"
                rows=10
                cols=30><?php echo "Default Value"; ?></textarea>
            <br>
            <br>

            <p>My Academic Skills</p>
            <select name="aSkills"
                class="dropdown input"
                id="askills">
                <?php
                $skills = array(
                    "Select skills",
                    "skill0",
                    "skill1",
                    "skill2",
                    "skill3",
                    "skill4",
                    "skill5",
                    "skill6",
                    "skill7",
                    "skill8",
                    "skill9",
                );
                foreach ($skills as $s) {
                    if ($s == "Select skills") {
                        echo "<option value=\"\">Select Skills</option>";
                    } else {
                        echo "<option value=\"$s\">$s</option>";
                    }
                }
                ?>
            </select>
            <br>
            <br>
            <div id="academic-skills">

            </div>

            <p>My Non-Academic Skills</p>
            <select name="naSkills"
                class="dropdown input"
                id="naskills">

                <?php
                $skills = array("Select skills", "Cooking", "Tech Support");
                foreach ($skills as $s) {
                    if ($s == "Select skills") {
                        echo "<option value=\"\">Select Skills</option>";
                    } else {
                        echo "<option value=\"$s\">$s</option>";
                    }
                }
                ?>
            </select>
            <div id="non-academic-skills"></div>

            <br>
            <br>
            <input type="submit" value="Confirm Changes">
        </form>
        <br>
        <button
            name="availability"
            id="changeavailability"
            class="button">Change availability</button>

        <div id="availability-popup" class="popup hidden">
            <button name="by-day"
                id="daily"
                class="button popup">By Day</button>
            <br>
            <button name="by-week"
                id="weekly"
                class="button popup">By Week</button>
        </div>
    </div>
    <div class="spacing"></div>
    <div id="availability">

    </div>
    <div class="spacing">

    </div>
</body>

</html>