<?php
require_once('../includes/class_autoloader.inc.php');

class Login extends Dbh {
    private $conn;

    // Constants for error messages
    const ERROR_STMT_FAILED = 'stmtfailed';
    const ERROR_USER_NOT_FOUND = 'usernotfound';
    const ERROR_WRONG_PASSWORD = 'wrongpassword';

    protected function getUser($uid, $pwd) {
        $this->conn = $this->connect();

        // Prepare the statement to select the user
        $select = "SELECT * FROM users WHERE user_id = ? OR email = ?";
        $stmt = $this->conn->prepare($select);

        // Check if the statement was successfully executed
        if (!$stmt->execute([$uid, $uid])) {
            header("location: ../index.php?error=" . self::ERROR_STMT_FAILED);
            exit();
        }

        // Fetch the user record
        $user = $stmt->fetch();
        if ($user === false) {
            header("location: ../index.php?error=" . self::ERROR_USER_NOT_FOUND);
            exit();
        }

        // Verify the password
        if (!password_verify($pwd, $user['password'])) {
            header("location: ../index.php?error=" . self::ERROR_WRONG_PASSWORD);
            exit();
        }

        // Start session and store user data
        session_start();
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];
        $_SESSION['image_path'] = $user['image_path'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['image_path'] = $user['image_path'];

        if ($_SESSION['user_role'] === 'store manager') {
            $storeCtrl = new StoreCtrl();
            try {
                $storeId = $storeCtrl->getStoreByManagerId($user['user_id']);
                $_SESSION['store_id'] = $storeId;
            } catch (\Throwable $th) {
                throw $th;
            }
            
        }

        return true;
        $stmt = null; // Close the statement


    }
}


class LoginCtrl extends Login {
    private $uid;
    private $pwd;

    public function __construct($uid, $pwd) {
        $this->uid = trim($uid); // Trim user input for security
        $this->pwd = $pwd;
    }

    public function loginUser() {
        if ($this->emptyInput()) {
            header("location: ../index.php?error=emptyinput");
            exit();
        }
        
        // Attempt to retrieve user
        return $this->getUser($this->uid, $this->pwd);
    }

    private function emptyInput() {
        return empty($this->uid) || empty($this->pwd);
    }
}
?>
