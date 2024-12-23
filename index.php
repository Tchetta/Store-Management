<?php 
session_start();
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
    <link rel="shortcut icon" href="https://camtel.cm/wp-content/uploads/2024/01/Logos-Camtel-02-blue.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/error_success.css">
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<?php require_once 'pages/display_result.php'; ?>
<div class="logo-container">
    <img src="./images/camtel logo.png" alt="Camtel Logo">
</div>

<div class="loginBody">
    <form action="includes/login.inc.php" method="POST">
        <div class="loginInputContainer">
            <h1>CSMS</h1>
            <p> CAMTEL STORE MANAGEMENT SYSTEM</p>
            <input type="text" name="username" placeholder="Username">
        </div>
        <div class="loginInputContainer password-container">
            <input type="password" name="password" id="password" placeholder="Password">
            <span class="eye-icon" onclick="togglePassword()">
                <i class="fas fa-eye" id="eyeIcon"></i>
            </span>
        </div>
        <div class="loginButtonContainer">
            <button type="submit" name="login">Login</button>
        </div>
    </form>

    <?php
    if (isset($_GET['error'])) {
        if ($_GET['error'] == 'emptyinput') {
            echo "<div class='errorMessage'><p>Please fill in all fields!</p></div>";
        } elseif ($_GET['error'] == 'invalidlogin') {
            echo "<div class='errorMessage'><p>Invalid login credentials!</p></div>";
        }
    }
    ?>
</div>

<script>
function togglePassword() {
    var passwordField = document.getElementById("password");
    var eyeIcon = document.getElementById("eyeIcon");
    
    if (passwordField.type === "password") {
        passwordField.type = "text";
        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash");
    } else {
        passwordField.type = "password";
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye");
    }
}
</script>
</body>
</html>
