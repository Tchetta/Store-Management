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
    $eventCtrl->deletionEvent($modelId, 1, 'OUT');

    $success = 'Equipment deleted successfully\nSN: ' . $id;
    $success = urlencode($success);
    header("Location: ../pages/dashboard.php?page=equipment_list&success=$success");
    exit();
} else {
    header("Location: ../pages/dashboard.php?page=equipment_list&error=invalid_request");
    exit();
}
