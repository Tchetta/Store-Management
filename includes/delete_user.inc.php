<?php
require_once '../includes/class_autoloader.inc.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Initialize the UserCtrl class
    $userController = new UserCtrl();

    try {
        // Delete user using the controller method
        $userController->deleteUser($user_id);

        // Redirect back to the user list with a success message
        header("Location: ../pages/dashboard.php?page=user_list&success=user+deleted");
        exit();
    } catch (Exception $e) {
        // Redirect to the user list with an error message
        header("Location: ../pages/dashboard.php?page=user_list&error=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    // Redirect if no user ID was provided
    header("Location: ../pages/dashboard.php?page=user_list&error=no+user+id");
    exit();
}
