<?php
include '../../../inc/dbconn.inc.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute
    $stmt = $conn->prepare("SELECT password FROM userdata WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($db_password);
        $stmt->fetch();

        if ($password === $db_password) {
            $message = "Login successful";
            
            // Start the session and redirect to the dashboard or home page
            session_start();
            $_SESSION['email'] = $email;
            header("Location: dashboard.php"); /*Change to appropraite page */ 
            exit();
        } else {
            $message = "Incorrect password";
            
        }
    } else {
        $message = "Email not found";
        
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
    <link rel="stylesheet" href="login.css">
    <meta name="author" content="Jayden">
    <script src="./login.js"> </script>
    <title>FUSS Admin Login Page</title>
</head>

<body>
  <div id="topBanner">
    <div id="flindersLogo">
      <img src="./imgs/flindersLogo.png" alt="Logo for Flinders University" id="flindersLogo">
    </div>
      <header><h1>Flinders University Skill Share</h1> <header>
        <div id="switchButton">
         <input id="swapButton" class="button" type="button" onclick="location.href='../studentLoginPage/studentLoginPage.php';" value="Student Login" />
          </div>
  </div>
  <main>
  <div id="loginCard">
      <form action="/login" method="post" id="loginForm">
      <div class="form-card">
        <h2>Administrator Login</h2>
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
    </form>
    </div>
    </main>
</body>
</html>