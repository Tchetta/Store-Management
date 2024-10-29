<?php
require_once '../includes/class_Autoloader.inc.php';
$userController = new UserCtrl();

$userController->setUserPassword('TestUser1','TestUser1');

?>