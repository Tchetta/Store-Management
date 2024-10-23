<?php
require_once '../includes/class_autoloader.inc.php';

if (isset($_GET['id'])) {
    $modelId = $_GET['id'];

    $modelController = new ModelCtrl();

    try {
        $modelController->deleteModel($modelId);
        header("Location: ../pages/dashboard.php?page=model_list&success=model+deleted");
    } catch (Exception $e) {
        header("Location: ../pages/dashboard.php?page=model_list&error=" . urlencode($e->getMessage()));
    }
}
