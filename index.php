<?php 
  // Start session to handle login state
  session_start();
  // Check if user is already logged in and redirect to dashboard
  if (isset($_SESSION['user_id'])) {
      header("Location: pages/dashboard.php");
      exit();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/login.css"> <!-- Link to login.css -->
</head>
<body>
<div class="logo-container">
    <img src="images/camtel.png" alt="Camtel Logo">
</div>

    <div class="loginBody">
        <div class="loginHeader">
            
           
        </div>
        <form action="includes/login.inc.php" method="POST">
            <div class="loginInputContainer">
            <h1>CSMS</h1>
            <p> CAMTEL STORE MANAGEMENT SYSTEM</p>
                <input type="text" name="username" placeholder="Username">
            </div>
            <div class="loginInputContainer">
                <input type="password" name="password" placeholder="Password">
            </div>
            <div class="loginButtonContainer">
                <button type="submit" name="login">Login</button>
            </div>
        </form>

        <?php
        // Show any error messages if login fails
        if (isset($_GET['error'])) {
            if ($_GET['error'] == 'emptyinput') {
                echo "<div class='errorMessage'><p>Please fill in all fields!</p></div>";
            } elseif ($_GET['error'] == 'invalidlogin') {
                echo "<div class='errorMessage'><p>Invalid login credentials!</p></div>";
            }
        }
        ?>
    </div>
</body>
</html>
