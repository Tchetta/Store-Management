<?php
require_once 'class_autoloader.inc.php';

if (isset($_POST['submit'])) {
    // Initialize error array
    $errors = [];

    // Validate store_id and model_id - ensure they are valid integers
    if (empty($_POST['store_id']) || !preg_match("/^[a-zA-Z0-9_-]+$/", $_POST['store_id'])) {
        $errors[] = "Invalid store selected.";
    } else {
        $storeId = $_POST['store_id']; // Assumed to be a valid integer
    }

    if (empty($_POST['model_id']) || !filter_var($_POST['model_id'], FILTER_VALIDATE_INT)) {
        $errors[] = "Invalid model selected.";
    } else {
        $modelId = $_POST['model_id']; // Assumed to be a valid integer
    }

    // Sanitize the serial number (it's optional)
    $serial_num = isset($_POST['serial_num']) ? htmlspecialchars($_POST['serial_num']) : '';

    // If there are no errors, proceed with the operation
    if (empty($errors)) {
        try {
            // Using a controller to add equipment
            $equipmentController = new EquipmentCtrl();
            $equipmentController->addEquipment($serial_num, $storeId, $modelId, $category, $brand);

            // Update the model quantity
            $modelController = new ModelCtrl();
            $modelController->updateModelQuantity($modelId);

            $brand = $modelController->getBrandByModel($modelId);
            $category = $modelController->getCategoryByModel($modelId);

            // Log the event (assuming `Event` class has proper protection)
            $eventCtrl = new Event();
            $sn = $serial_num;
            $eventCtrl->additionEvent($modelId, 1, 'IN', $sn);

            // Redirect on success
            $success = 'Equipment added successfully<br>SN: ' . $serial_num . '<br>Store:' . $storeId;
            $success = urlencode($success);
            header("Location: ../pages/dashboard.php?page=add_equipment&success=$success");
            exit();

        } catch (Exception $e) {
            // Handle any exceptions or errors during the process
            header("Location: ../pages/dashboard.php?page=add_equipment&error=" . urlencode($e->getMessage()));
            exit();
        }
    } else {
        // If there are validation errors, redirect back with error messages
        $errorString = implode(", ", $errors);
        header("Location: ../pages/dashboard.php?page=add_equipment&error=" . urlencode($errorString));
        exit();
    }
} else {
    // Handle case where the form wasn't submitted properly
    header("Location: ../pages/dashboard.php?page=add_equipment&error=nothing+submitted");
    exit();
}
