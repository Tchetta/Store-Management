<?php
if (isset($_POST['login'])) {
    require_once '../classes/control/loginCtrl.class.php'; // Include login control

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Simple error handling
    if (empty($username) || empty($password)) {
        header("Location: ../index.php?error=emptyinput");
        exit();
    }

    // Create instance of the Login Controller and log in
    $loginCtrl = new LoginCtrl($username, $password);
    $loginResult = $loginCtrl->loginUser();

    // Handle the response from the login method
    if ($loginResult === true) {
        header("Location: ../pages/dashboard.php"); // Redirect to dashboard on success
        exit();
    } else {
        header("Location: ../index.php?error=invalidlogin"); // Return error on failure
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}
