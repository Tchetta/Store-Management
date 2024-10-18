<?php
require_once '../includes/class_autoloader.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    $equipmentCtrl = new EquipmentCtrl();
    $modelId = $equipmentCtrl->getModelId($id);
    $equipmentCtrl->deleteEquipment($id);

    $modelController = new ModelCtrl();
    $modelController->updateModelQuantity($modelId);

    // Log the event (assuming `Event` class has proper protection)
    $eventCtrl = new Event();
    $eventCtrl->deletionEvent($modelId, 1, 'OUT');

    header("Location: ../pages/dashboard.php?page=equipment_list&success=deleted");
    exit();
} else {
    header("Location: ../pages/dashboard.php?page=equipment_list&error=invalid_request");
    exit();
}
