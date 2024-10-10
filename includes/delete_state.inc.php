<?php
require_once '../includes/class_autoloader.inc.php';

if (isset($_GET['id'])) {
    $stateId = $_GET['id'];

    $stateController = new StateCtrl();

    try {
        $stateController->deleteState($stateId);
        header("Location: ../pages/dashboard.php?page=state_list&success=statedeleted");
    } catch (Exception $e) {
        header("Location: ../pages/dashboard.php?page=state_list&error=" . urlencode($e->getMessage()));
    }
}
?>
