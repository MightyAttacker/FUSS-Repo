<?php
include '../../inc/dbconn.inc.php';

$message = "";
$email = "";
$password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  $email = test_input($_POST["email"]);
  $password = test_input($_POST["password"]);


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
  
  // Check if email already exists
  $checkEmailStmt = $conn->prepare("SELECT email FROM userdata WHERE email = ?");
  $checkEmailStmt->bind_param("s", $email);
  $checkEmailStmt->execute();
  $checkEmailStmt->store_result();

  if ($checkEmailStmt->num_rows > 0) {
    $message = "Email ID already exists";
  } else {
    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO userdata (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $password);

    if ($stmt->execute()) {
      $message = "Account created successfully";
    } else {
      $message = "Error: " . $stmt->error;
    }

    $stmt->close();
  }

  $checkEmailStmt->close();
  $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en-AU">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="loginStyle.css">
    <meta name="author" content="Jayden">
    <script src="login.js"> </script>
  <title>FUSS Register Page</title>
</head>

<body>
  <div id="topBanner">
    <div id="flindersLogo">
      <img src="../images/flindersLogo.png" alt="Logo for Flinders University" id="flindersLogo">
    </div>
    <header>
      <h1>Flinders University Skill Share</h1>
      <header>
        <div id="switchButton">
          <input id="swapButton" class="button" type="button" onclick="location.href='studentLoginPage.php';" value="Student Login" />
        </div>
  </div>
  <main>
    <?php if ($message): ?> 
      <div id="message"> <?php echo $message; ?> </div>
      <?php endif; ?>
    <div id="loginCard">
      <form action="" method="post" id="loginForm">
        <div class="form-card">
          <h2>Create Your Account</h2>
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
          <button id="loginButton" type="submit" class="button">Create Account</button>
        </div>
        <div id="account" class="form-item">
          Already have an Account? <a href="studentLoginPage.php"> Login </a>
          </div>
      </form>
    </div>
  </main>
</body>

</html>