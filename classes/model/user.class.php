<?php

class User extends Dbh {
    private $conn;

    // Check if user ID or email already exists
    protected function checkUser($email) {
        $this->conn = $this->connect();
        $select = "SELECT user_id FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($select);
        
        if (!$stmt->execute([$email])) {
            $stmt = null;
            throw new Exception("Failed to check user");
        }

        return $stmt->rowCount() > 0;
    }

    // Get all users
    public function getAllUsers() {
        $sql = "SELECT * FROM users";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Get user by ID
    public function getUserById($userId) {
        $sql = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetch();
    }

    // Update user information
    public function updateUser($userId, $data) {
        $this->conn = $this->connect();
        $setPart = [];
        $params = [];

        foreach ($data as $key => $value) {
            if ($value !== null) {
                $setPart[] = "$key = ?";
                $params[] = $value;
            }
        }

        if (!empty($setPart)) {
            $setQuery = implode(", ", $setPart);
            $sql = "UPDATE users SET $setQuery WHERE user_id = ?";
            $params[] = $userId;

            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
        }
    }

    // Delete a user by ID
    public function deleteUser($userId) {
        $sql = "DELETE FROM users WHERE user_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$userId]);
    }

    // Check if user exists by email
    public function userExists($email) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->rowCount() > 0;
    }

    // Create a user without handling password (handled in the control class)
    public function createUserInModel($username, $email, $hashedPassword, $role, $profilePicPath = null, $firstName = null, $lastName = null) {
        try {
            $sql = "INSERT INTO users (user_id, email, password, role, profile_pic, first_name, last_name) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$username, $email, $hashedPassword, $role, $profilePicPath, $firstName, $lastName]);
        } catch (Exception $e) {
            throw new Exception("Error creating user: " . $e->getMessage());
        }
    }
    
}
