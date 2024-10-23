<?php
session_start();
require_once 'class_Autoloader.inc.php'; // Assuming this includes UserCtrl and other necessary classes

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get user input
    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $userId = $_POST['user_id'] ?? '';

    // Initialize error and success messages
    $error = '';
    $success = '';

    // Assuming you have a logged-in user, retrieve user ID from session
    if (!isset($userId)) {
        $error = "No user selected.";
        header("Location: ../pages/dashboard.php?page=change_password&&error=" . urlencode($error));
        exit();
    }
    
    // Initialize UserCtrl class
    $userCtrl = new UserCtrl();

    // Check if the new password and confirmation password match
    if ($newPassword !== $confirmPassword) {
        $error = "New password and confirmation do not match.";
        header("Location: ../pages/dashboard.php?page=change_password&&error=" . urlencode($error));
        exit();
    }

    // Verify the old password
    if (!$userCtrl->verifyOldPassword($userId, $oldPassword)) { 
        $error = "Old password is incorrect.";
        header("Location: ../pages/dashboard.php?page=change_password&&error=" . urlencode($error));
        exit();
    }

    // If no errors, proceed to change the password
    if ($userCtrl->setUserPassword($userId, $newPassword)) {
        $success = "Password successfully changed.";
        header("Location: ../pages/dashboard.php?page=change_password&&success=" . urlencode($success));
    } else {
        $error = "An error occurred while changing the password.";
        header("Location: ../pages/dashboard.php?page=change_password&&error=" . urlencode($error));
    }
    exit();
} else {
    // Redirect back if not accessed through form submission
    header("Location: ../change_password.php");
    exit();
}
?>
