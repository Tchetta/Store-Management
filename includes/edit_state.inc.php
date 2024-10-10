<?php
require_once '../includes/class_autoloader.inc.php';

if (isset($_POST['submit'])) {
    $stateId = $_POST['state_id'];
    $newStateName = $_POST['state_name'];

    $stateController = new StateCtrl();

    try {
        $stateController->updateState($stateId, $newStateName);
        header("Location: ../pages/dashboard.php?page=state_list&success=stateupdated");
    } catch (Exception $e) {
        header("Location: ../pages/dashboard.php?page=edit_state&id=$stateId&error=" . urlencode($e->getMessage()));
    }
}
?>
