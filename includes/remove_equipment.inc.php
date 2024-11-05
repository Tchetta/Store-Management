<?php
require_once 'class_autoloader.inc.php';

if (isset($_POST['submit'])) {
    $errors = [];
    $modelController = new ModelCtrl();
    $equipmentController = new EquipmentCtrl();
    $eventCtrl = new Event();
    
    // Get store_id and model_id
    $storeId = $_POST['store_id'] ?? null;
    $modelId = $_POST['model_id'] ?? null;
    $quantity = $_POST['quantity'] ?? 0;
    $serialNumbers = $_POST['serial_num'] ?? [];
    
    // Validate input
    if (empty($storeId) || !preg_match("/^[a-zA-Z0-9_-]+$/", $storeId)) {
        $errors[] = "Invalid store selected.";
    }

    if (empty($modelId) || !filter_var($modelId, FILTER_VALIDATE_INT)) {
        $errors[] = "Invalid model selected.";
    }
    
    if (empty($serialNumbers) && $quantity <= 0) {
        $errors[] = "You must provide either serial numbers or a quantity to remove.";
    }

    // Process removal if no errors
    if (empty($errors)) {
        try {
            $totalRemoved = 0;
            
            // Remove equipment by serial numbers if provided
            if (!empty($serialNumbers)) {
                foreach ($serialNumbers as $sn) {
                    $quantity_available = $equipmentController->removeEquipmentBySerialNumber($sn, $storeId);
                    $eventCtrl->deletionEvent($modelId, 1, 'OUT', $sn);
                    $totalRemoved++;
                }
            } 
            // Remove equipment by quantity if no serial numbers
            else {
                $equipmentRemoved = $equipmentController->removeEquipmentByQuantity($storeId, $modelId, $quantity);
                $eventCtrl->deletionEvent($modelId, $equipmentRemoved, 'OUT', '');
                $modelController->decreaseQuantity($modelId, $equipmentRemoved);
                $totalRemoved = $equipmentRemoved;
            }

            // Update model quantity
            $modelController->updateModelQuantity($modelId);

            // Success message
            $success = "Equipment removed successfully.<br>Total removed: $totalRemoved";
            header("Location: ../pages/dashboard.php?page=remove&success=" . urlencode($success));
            exit();
            
        } catch (Exception $e) {
            // Handle exceptions and redirect with error
            $error = "Error: " . $e->getMessage();
            header("Location: ../pages/dashboard.php?page=remove&error=" . urlencode($error));
            exit();
        }
    } else {
        // Redirect with error message(s)
        $error = implode('<br>', $errors);
        header("Location: ../pages/dashboard.php?page=remove&error=" . urlencode($error));
        exit();
    }
} else {
    header("Location: ../pages/dashboard.php?page=remove&error=No+data+submitted");
    exit();
}
?>
