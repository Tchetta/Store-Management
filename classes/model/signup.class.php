<?php

class SignUp extends Dbh {
    private $conn;

    // Check if user ID or email already exists
    protected function checkUser($userId, $email) {
        $this->conn = $this->connect();
        $select = "SELECT user_id FROM users WHERE user_id = ? OR email = ?";
        $stmt = $this->conn->prepare($select);

        if (!$stmt->execute([$userId, $email])) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        return $stmt->rowCount() > 0;
    }

    // Set user information in the database
    protected function setUser($userId, $password, $email, $firstName, $lastName, $imagePath = null) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $this->conn = $this->connect();

        $insert = 'INSERT INTO users (user_id, firstName, lastName, email, password, image_path) VALUES (?, ?, ?, ?, ?, ?)';
        $stmt = $this->conn->prepare($insert);

        try {
            $stmt->execute([$userId, $firstName, $lastName, $email, $hashedPassword, $imagePath]);
        } catch (PDOException $e) {
            return $e->getMessage();
        }

        return [$hashedPassword, $password];
    }

    // Update user methods
    
    protected function updateUserId($currentUserId, $newUserId) {
        $this->conn = $this->connect();
        $update = "UPDATE users SET user_id = ? WHERE user_id = ?";
        $stmt = $this->conn->prepare($update);

        if (!$stmt->execute([$newUserId, $currentUserId])) {
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        $stmt = null;
    }

    protected function updateEmail($userId, $newEmail) {
        $this->conn = $this->connect();
        $update = "UPDATE users SET email = ? WHERE user_id = ?";
        $stmt = $this->conn->prepare($update);

        if (!$stmt->execute([$newEmail, $userId])) {
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        $stmt = null;
    }

    protected function updateFirstName($userId, $newFirstName) {
        $this->conn = $this->connect();
        $update = "UPDATE users SET firstName = ? WHERE user_id = ?";
        $stmt = $this->conn->prepare($update);

        if (!$stmt->execute([$newFirstName, $userId])) {
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        $stmt = null;
    }

    protected function updateLastName($userId, $newLastName) {
        $this->conn = $this->connect();
        $update = "UPDATE users SET lastName = ? WHERE user_id = ?";
        $stmt = $this->conn->prepare($update);

        if (!$stmt->execute([$newLastName, $userId])) {
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        $stmt = null;
    }

    protected function updatePassword($userId, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $this->conn = $this->connect();
        $update = "UPDATE users SET password = ? WHERE user_id = ?";
        $stmt = $this->conn->prepare($update);

        if (!$stmt->execute([$hashedPassword, $userId])) {
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        $stmt = null;
    }

    // Optional: Update image path (if you decide to allow changing the image)
    protected function updateImagePath($userId, $imagePath) {
        $this->conn = $this->connect();
        $update = "UPDATE users SET image_path = ? WHERE user_id = ?";
        $stmt = $this->conn->prepare($update);

        if (!$stmt->execute([$imagePath, $userId])) {
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        $stmt = null;
    }
}
