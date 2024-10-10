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
</head>
<body>
    <h2>Login</h2>

    <form action="includes/login.inc.php" method="POST">
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <button type="submit" name="login">Login</button>
    </form>

    <?php
    // Show any error messages if login fails
    if (isset($_GET['error'])) {
        if ($_GET['error'] == 'emptyinput') {
            echo "<p>Please fill in all fields!</p>";
        } elseif ($_GET['error'] == 'invalidlogin') {
            echo "<p>Invalid login credentials!</p>";
        }
    }
    ?>
</body>
</html>
