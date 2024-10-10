<?php
require_once '../includes/class_autoloader.inc.php';

if (isset($_POST['submit'])) {
    $stateName = $_POST['state_name'];

    $stateController = new StateCtrl();

    try {
        $stateController->createState($stateName);
        header("Location: ../pages/dashboard.php?page=state_list&success=statecreated");
    } catch (Exception $e) {
        header("Location: ../pages/dashboard.php?page=create_state&error=" . urlencode($e->getMessage()));
    }
}
?>
