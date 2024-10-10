<?php
require_once('../includes/class_autoloader.inc.php');


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
