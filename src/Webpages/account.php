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
        <script type="module" src="../Scripts/account-page-script.js" defer> </script>
        <script type="module" src="../Scripts/account-page-availability.js" defer> </script>
        <script type="module" src="../Scripts/account-page-submit.js" defer> </script>
        <link rel="stylesheet" href="../Styles/account-page-styles.css">
        <?php
        require_once "../inc/dbconn.inc.php";
        ?>
    </head>

<body>
    <div id="sidebar">
        <a href="../index.php">Test</a>
    </div>

    <div class="spacing"></div>

    <div id="main">
        <p>My Course:</p>
        <input
            type="text"
            required
            name="course"
            class="text-input input"
            id="course"
            value=<?php
                    $sql = "SELECT course FROM users WHERE id = \"testuser1\"";
                    if ($result = mysqli_query($conn, $sql)) {
                        foreach ($result as $k => $v) {
                            echo $v["course"];
                        }
                        mysqli_free_result($result);
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
                    $sql = "SELECT about FROM users WHERE id = \"testuser1\"";
                    if ($result = mysqli_query($conn, $sql)) {
                        foreach ($result as $k => $v) {
                            echo $v["about"];
                        }
                        mysqli_free_result($result);
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

            $sql = "SELECT skill FROM skills WHERE academic = 1";
            if ($result = mysqli_query($conn, $sql)) {
                foreach ($result as $k => $v) {
                    $a = $v["skill"];
                    echo "<option value=\"$a\">$a</option>";
                }
                mysqli_free_result($result);
            }
            ?>
        </select>
        <br>
        <br>
        <div id="academic-skills">
            <?php
            $sql = "SELECT skills.skill
                FROM skills JOIN userskills u on skills.skill = u.skill 
                WHERE academic = 1 AND userid = \"testuser1\"";
            if ($result = mysqli_query($conn, $sql)) {
                foreach ($result as $k => $v) {
                    $b = implode($v);
                    // Could combine all calls into one script. Only needs to be done if there is spare time
                    echo "<script type=\"module\"> 
                        import {createButton} from \"../Scripts/account-page-script.js\";
                        createButton(\"$b\", true); </script>";
                }
                mysqli_free_result($result);
            }
            ?>
        </div>

        <p>My Non-Academic Skills</p>
        <select name="naSkills"
            class="dropdown input"
            id="naskills">

            <?php
            echo "<option value=\"\">Select Skills</option>";
            $sql = "SELECT skill FROM skills WHERE academic = 0";
            if ($result = mysqli_query($conn, $sql)) {
                foreach ($result as $k => $v) {
                    $a = $v["skill"];
                    echo "<option value=\"$a\">$a</option>";
                }
                mysqli_free_result($result);
            }
            ?>
        </select>
        <br>
        <br>
        <div id="non-academic-skills">

            <?php
            $sql = "SELECT skills.skill
                FROM skills JOIN userskills u on skills.skill = u.skill 
                WHERE academic = 0 AND userid = \"testuser1\"";
            if ($result = mysqli_query($conn, $sql)) {
                foreach ($result as $k => $v) {
                    $b = implode($v);
                    // echo "$b";
                    echo "<script type=\"module\"> 
                        import {createButton} from \"../Scripts/account-page-script.js\";
                        createButton(\"$b\", false); </script>";
                }
                mysqli_free_result($result);
            }
            ?>
        </div>

        <br>
        <br>
        <input id="submit" type="submit" value="Confirm Changes">
        <br>
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