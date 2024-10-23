<?php
require_once '../includes/class_autoloader.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $serial_num = $_POST['serial_num'];
    $store_id = $_POST['store_id'];
    $model_id = $_POST['model_id'];
    $category = $_POST['category'];
    $brand = $_POST['brand'];
    $equipment_state = $_POST['equipment_state'];

    $equipmentCtrl = new EquipmentCtrl();

    $equipmentCtrl->updateSerialNum($id, $serial_num);
    $equipmentCtrl->updateStoreId($id, $store_id);
    $equipmentCtrl->updateModelId($id, $model_id);
    $equipmentCtrl->updateCategory($id, $category);
    $equipmentCtrl->updateBrand($id, $brand);
    $equipmentCtrl->updateEquipmentState($id, $equipment_state);

    $success = 'Equipment updated successfully\nSN: ' . $serial_num . '\nStore:' . $store_id. '\nState:' . $equipment_state;
    $success = urlencode($success);
    header("Location: ../pages/dashboard.php?page=equipment_list&success=$success");
    exit();
} else {
    header("Location: ../pages/dashboard.php?page=equipment_list&error=invalid_request");
    exit();
}
