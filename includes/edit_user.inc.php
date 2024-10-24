<?php
require_once 'class_autoloader.inc.php';

if (isset($_POST['submit'])) {
    $user_id = $_POST['user_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $role = $_POST['role'] ?? 'store manager';
    $profile_pic = $_FILES['profile_pic'];

    // Basic input validation
    if (empty($first_name) || empty($last_name) || empty($email)) {
        header("Location: ../dashboard.php?page=edit_user&id=$user_id&error=empty+fields");
        exit();
    }

    // Check if passwords match
    if (isset($_POST['password']) && isset($_POST['confirm_password'])) {
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];
        if ($password !== $confirmPassword) {
            header("Location: ../dashboard.php?page=edit_user&error=passwordmismatch&id=$user_id");
            exit();
        }
    }
    

    // Initialize the user controller
    $userController = new UserCtrl();

    // Check if passwords match
    if (isset($_POST['password']) && isset($_POST['confirm_password'])) {
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];
        if ($password !== $confirmPassword) {
            header("Location: ../dashboard.php?page=edit_user&error=passwordmismatch&id=$user_id");
            exit();
        }

        $userController->setUserPassword($user_id, $password);
    }

    // Retrieve current profile picture
    $current_user = $userController->getUserById($user_id);
    $current_profile_pic = $current_user['image_path'];

    // Handle profile picture update
    if ($profile_pic['error'] === 0) {
        $fileTmp = $profile_pic['tmp_name'];
        $fileName = $profile_pic['name'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowed = array('jpg', 'jpeg', 'png');

        if (in_array($fileExt, $allowed)) {
            $fileNameNew = uniqid('', true) . "." . $fileExt;
            $fileDestination = '../uploads/profile_pics/' . $fileNameNew;

            // Move uploaded file to the profile_pics directory
            if (move_uploaded_file($fileTmp, $fileDestination)) {
                // Successfully moved the file
            } else {
                header("Location: ../dashboard.php?page=edit_user&id=$user_id&error=file+upload+failed");
                exit();
            }
        } else {
            header("Location: ../dashboard.php?page=edit_user&id=$user_id&error=invalid+file+type");
            exit();
        }
    } else {
        // No new image uploaded, keep the current profile pic
        $fileNameNew = $current_profile_pic; // Set to existing profile pic path
    }


    try {
        // Prepare the data to update
        $data = [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'role' => $role,
            'image_path' => $fileNameNew // Update the path to the profile picture
        ];

        // Update user in the database
        $userController->updateUser($user_id, $data);

        // Redirect back to the user list
        header("Location: ../pages/dashboard.php?page=user_list&success=user+updated");
        exit();
    } catch (Exception $e) {
        header("Location: ../pages/dashboard.php?page=edit_user&id=$user_id&error=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    header("Location: ../pages/dashboard.php?page=edit_user&id=$user_id");
    exit();
}
?>
