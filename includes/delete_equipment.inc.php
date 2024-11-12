<?php
require_once '../includes/class_autoloader.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'];

    $equipmentCtrl = new EquipmentCtrl();
    $modelId = $equipmentCtrl->getModelId($id);
    $equipmentCtrl->deleteEquipment($id);

    $modelController = new ModelCtrl();
    $modelController->updateModelQuantity($modelId);

    // Log the event (assuming `Event` class has proper protection)
    $eventCtrl = new Event();
    $eventCtrl->deletionEvent($modelId, 1, 'OUT', $id);

    $success = 'Equipment deleted successfully <br> SN: ' . $id;
    $success = urlencode($success);
    header("Location: ../pages/dashboard.php?page=equipment_list_with_search&success=$success");
    exit();
} else {
    header("Location: ../pages/dashboard.php?page=equipment_list_with_search&error=invalid_request");
    exit();
}
