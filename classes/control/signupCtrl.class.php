<?php

class SignUpCtrl extends SignUp {

    // Check if the user ID or email already exists
    public function checkUserCtrl($userId, $email) {
        return $this->checkUser($userId, $email);
    }

    // Create a new user
    public function createUserCtrl($userId, $password, $email, $firstName, $lastName, $imagePath = null) {
        return $this->setUser($userId, $password, $email, $firstName, $lastName, $imagePath);
    }

    // Update user ID
    public function updateUserIdCtrl($currentUserId, $newUserId) {
        $this->updateUserId($currentUserId, $newUserId);
    }

    // Update email
    public function updateEmailCtrl($userId, $newEmail) {
        $this->updateEmail($userId, $newEmail);
    }

    // Update first name
    public function updateFirstNameCtrl($userId, $newFirstName) {
        $this->updateFirstName($userId, $newFirstName);
    }

    // Update last name
    public function updateLastNameCtrl($userId, $newLastName) {
        $this->updateLastName($userId, $newLastName);
    }

    // Update password
    public function updatePasswordCtrl($userId, $newPassword) {
        $this->updatePassword($userId, $newPassword);
    }

    // Optional: Update image path
    public function updateImagePathCtrl($userId, $imagePath) {
        $this->updateImagePath($userId, $imagePath);
    }
}
