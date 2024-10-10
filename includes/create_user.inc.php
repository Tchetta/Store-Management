<?php
require_once 'class_autoloader.inc.php';

if (isset($_POST['submit'])) {
    $firstName = $_POST['firstname'];
    $lastName = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $role = $_POST['role'];
    $profilePic = $_FILES['profile_pic'];

    // Basic input validation
    if (empty($username) || empty($email) || empty($password) || empty($role) || empty($firstName) || empty($lastName)) {
        header("Location: ../dashboard.php?page=create_user&error=emptyfields");
        exit();
    }

    // Check if passwords match
    if ($password !== $confirmPassword) {
        header("Location: ../dashboard.php?page=create_user&error=passwordmismatch");
        exit();
    }

    // Handling profile picture upload
    if ($profilePic['error'] === 0) {
        $fileTmp = $profilePic['tmp_name'];
        $fileName = $profilePic['name'];
        $fileSize = $profilePic['size'];
        $fileError = $profilePic['error'];
        $fileType = $profilePic['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg', 'jpeg', 'png');

        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 5000000) { // 5MB limit
                    $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                    $fileDestination = '../uploads/profile_pics/' . $fileNameNew;

                    // Move uploaded file to the profile_pics directory
                    move_uploaded_file($fileTmp, $fileDestination);
                } else {
                    header("Location: ../pages/dashboard.php?page=create_user&error=filetoolarge");
                    exit();
                }
            } else {
                header("Location: ../pages/dashboard.php?page=create_user&error=uploaderror");
                exit();
            }
        } else {
            header("Location: ../pages/dashboard.php?page=create_user&error=invalidfiletype");
            exit();
        }
    } else {
        // If no file was uploaded, we use a default picture
        $fileNameNew = 'default.png';
    }

    // Initialize the controller and call the createUser method
    $userController = new UserCtrl();
    try {
        $userController->createUser($username, $email, $password, $role, $fileNameNew, $firstName, $lastName);
        header("Location: ../pages/dashboard.php?page=user_list&success=usercreated");
        exit();
    } catch (Exception $e) {
        header("Location: ../pages/dashboard.php?page=create_user&error=" . $e->getMessage());
        exit();
    }
} else {
    header("Location: ../pages/dashboard.php?page=create_user");
    exit();
}
