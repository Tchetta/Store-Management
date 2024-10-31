<?php
require_once 'class_autoloader.inc.php';

if (isset($_POST['submit'])) {
    $errors = [];

    // Validate store_id and model_id
    $storeId = $_POST['store_id'] ?? '';
    $modelId = $_POST['model_id'] ?? '';
    $serial_num = isset($_POST['serial_num']) ? htmlspecialchars(trim($_POST['serial_num'])) : '';
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;

    if (empty($storeId) || !preg_match("/^[a-zA-Z0-9_-]+$/", $storeId)) {
        $errors[] = "Invalid store selected.";
    }
    if (empty($modelId) || !filter_var($modelId, FILTER_VALIDATE_INT)) {
        $errors[] = "Invalid model selected.";
    }
    if (empty($serial_num) && $quantity <= 0) {
        $errors[] = "Provide either serial numbers or a quantity to remove.";
    }

    // Process serial numbers
    $serial_numbers = [];
    if (!empty($serial_num)) {
        $serial_numbers = array_filter(array_map('trim', explode(',', $serial_num)));
        if (count($serial_numbers) === 0) {
            $errors[] = "Invalid serial numbers format. Please separate serial numbers by commas.";
        }
    }

    if (empty($errors)) {
        try {
            $equipmentController = new EquipmentCtrl();
            $modelController = new ModelCtrl();

            if (!empty($serial_numbers)) {
                foreach ($serial_numbers as $sn) {
                    $equipmentController->removeEquipment($sn, $storeId, $modelId);
                    $eventCtrl = new Event();
                    $eventCtrl->removalEvent($modelId, 1, 'OUT', $sn);
                }
            } else {
                $modelController->decreaseQuantity($modelId, $quantity);
                $eventCtrl = new Event();
                $eventCtrl->removalEvent($modelId, $quantity, 'OUT', '');
            }

            $success = 'Equipment removed successfully';
            $success = urlencode($success);
            header("Location: ../pages/dashboard.php?page=remove_equipment&success=$success");
            exit();
        } catch (Exception $e) {
            header("Location: ../pages/dashboard.php?page=remove_equipment&error=" . urlencode($e->getMessage()));
            exit();
        }
    } else {
        $error = implode('<br>', $errors);
        header("Location: ../pages/dashboard.php?page=remove_equipment&error=" . urlencode($error));
        exit();
    }
} else {
    header("Location: ../pages/dashboard.php?page=remove_equipment&error=nothing+submitted");
    exit();
}
?>
