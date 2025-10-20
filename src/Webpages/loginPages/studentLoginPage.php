<?php
include '../../inc/dbconn.inc.php';

$message = "";
$email = "";
$password = "";
$id ="";

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = test_input($_POST["email"]);
    $password = test_input($_POST["password"]);
     
  
    // Prepare and execute
    $stmt = $conn->prepare("SELECT password, id, suspended, suspendedUntil, Deleted FROM userdata WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($db_password, $id, $suspended, $suspendDate, $Deleted);
        $stmt->fetch();

        if (password_verify($password, $db_password)) {
            if($suspended == 1 && $suspendDate >= date("Y-m-d")) {
                $message = "Account Suspended Until " . $suspendDate;
                            }
            elseif ($Deleted == 1) {
                $message = "Account Deleted. Please contact admin.";
                              
            }
           elseif ($Deleted == 0 && ($suspended == 0 || $suspendDate < date("Y-m-d"))) {
            $message = "Login successful";
            
            // Start the session and redirect to the dashboard or home page
            session_start();
            $_SESSION['id'] = $id;
            header( "Location: ../student-homepage.php");  
            exit();
            }
        } else {
            $message = "Incorrect Password";
            
        }
    } else {
        $message = "Email Not Found";
        
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en-AU"> 
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="loginStyle.css" type="text/css">
    <meta name="author" content="Jayden">
    <script src="login.js" type="text/javascript"> </script>
    <title>FUSS Login Page</title>
</head>

<body>
  <div id="topBanner">
    <div id="flindersLogo">
      <img src="../images/flindersLogo.png" alt="Logo for Flinders University" id="flindersLogo">
    </div>
      <header><h1>Flinders University Skill Share</h1> <header>
        <div id="switchButton">
          <input id="swapButton" class="button" type="button" onclick="location.href='adminLoginPage.php';" value="Admin Login" />
          </div>
  </div>
  <main>
    <?php if ($message): ?> 
      <div id="message"> <?php echo $message; ?> </div>
      <?php endif; ?>
  <div id="loginCard">
      <form action="" method="post" id="loginForm">
      <div class="form-card">
        <h2>Student Login</h2>
        <h4> Please use your '@flinders.edu.au' email </h4>
          <div>
            <label for="email">Email:</label>
            <input class="form-item" type="email" id="email" name="email" pattern="^.+@flinders\.edu\.au$" title="Please use an @flinders.edu.au email address" required>
        </div>
        <br>
        <div>
            <label for="password">Password:</label>
            <input class="form-item" type="password" id="password" name="password" required>
             
            <div id="showPassword">
                <input class="showPassword" id="showPassword" type="checkbox" onclick="myPassword()">
                <label id="passwordText" for="password">Show Password</label>
          </div>
        </div>
        <br>
        </div>
        <div id="submitButtons">
        <button id="loginButton" type="submit" class="button">Login</button>
        </div>
        <div>
          <p> <a href="register.php" style="text-decoration:none;" >Create an Account </a> or <a href="forgottenPassword.php" style="text-decoration:none;">Forgot Password?</a> </p>
        </div>
    </form>
    </div>
    </main>
</body>

</html>