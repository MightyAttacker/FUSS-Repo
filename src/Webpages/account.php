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
        <script src="../Scripts/script.js" defer>
            // TODO: Use beforeunload
            // from https://developer.mozilla.org/en-US/docs/Web/API/Window/beforeunload_event
        </script>
        <link rel="stylesheet" href="../Styles/styles.css">
        <?php
        require_once "../inc/dbconn.inc.php"

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
                $skills = array("Select skills", "Writing", "Reading", "a", "b", "c", "v", "z", "x", "n", "m", "s", "d", "f", "g");
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
            <input type="submit" , value="Confirm Changes">
        </form>
        <br>

        <button
            name="availability"
            id="availability"
            class="button">Change availability</button>
    </div>
</body>

</html>