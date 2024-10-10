<?php

class UserCtrl extends User {

    // Create user with validation and password hashing
    public function createUser($username, $email, $password, $role, $profilePicPath = null, $firstName = null, $lastName = null) {
        // Validate required inputs
        if (empty($username) || empty($email) || empty($password)) {
            throw new Exception("Username, email, and password are required.");
        }
    
        // Check if the user already exists
        if ($this->userExists($email)) {
            throw new Exception("Email already exists.");
        }
    
        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        // Call the parent method to create the user in the database
        parent::createUserInModel($username, $email, $hashedPassword, $role, $profilePicPath, $firstName, $lastName);
    }

    // Update user information
    public function updateUser($userId, $newData) {
        if (empty($userId)) {
            throw new Exception("User ID is required for updating.");
        }
        parent::updateUser($userId, $newData);
    }

    // Delete user by ID
    public function deleteUser($userId) {
        if (empty($userId)) {
            throw new Exception("User ID is required.");
        }
        parent::deleteUser($userId);
    }
}
