<?php
require_once 'class_autoloader.inc.php';

if (isset($_POST['submit'])) {
    // Initialize error array
    $errors = [];   
    $modelController = new ModelCtrl();
    $quantity = $_POST['quantity'] ?? 0;
    $state = $_POST['state'] ?? 'New';

    // Validate store_id and model_id - ensure they are valid identifiers
    if (empty($_POST['store_id']) || !preg_match("/^[a-zA-Z0-9_-]+$/", $_POST['store_id'])) {
        $errors[] = "Invalid store selected.";
    } else {
        $storeId = $_POST['store_id'];
    }

    // Validate and retrieve model ID
    if (empty($_POST['model_id']) || !filter_var($_POST['model_id'], FILTER_VALIDATE_INT)) {
        $errors[] = "Invalid model selected.";
    } else {
        $modelId = $_POST['model_id'];
    }

    // Sanitize the serial number (it's optional)
    $serial_num = isset($_POST['serial_num']) ? htmlspecialchars(trim($_POST['serial_num'])) : '';

    // Validation: Ensure either serial numbers or quantity is provided
    if (empty($serial_num) && $quantity <= 0) {
        $errors[] = "You must provide either serial numbers or a quantity.";
    }

    // Process serial numbers if provided
    $serial_numbers = [];
    if (!empty($serial_num)) {
        // Split serial numbers by commas, trim whitespace, and remove any empty values
        $serial_numbers = array_filter(array_map('trim', explode(',', $serial_num)));

        if (count($serial_numbers) === 0) {
            $errors[] = "Invalid serial numbers format. Please separate serial numbers by commas.";
        }
    }

    $equipmentController = new EquipmentCtrl();
    $eventCtrl = new Event();

    // Check for errors before proceeding
    if (empty($errors)) {
        try {
            // Fetch brand and category based on the selected model
            $brand = $modelController->getBrandByModel($modelId);
            $category = $modelController->getCategoryByModel($modelId);

            // Add each serial number individually if provided
            if (!empty($serial_numbers)) {
                foreach ($serial_numbers as $sn) {
                    $equipmentController->addEquipment($sn, $storeId, $modelId, $category, $brand, $state);
                    // Log event
                    $eventCtrl->additionEvent($modelId, 1, 'IN', $sn);
                }
            } else {
                // Increase model quantity directly if no serial numbers were specified
                for ($i = 0; $i < $quantity; $i++) { 
                    $equipmentController->addEquipment('', $storeId, $modelId, $category, $brand, $state);
                }
                $modelController->increaseQuantity($modelId, $quantity);
                $eventCtrl->additionEvent($modelId, $quantity, 'IN', '');
            }

            // Update model quantity after addition
            $modelController->updateModelQuantity($modelId);

            // Redirect on success
            $success = 'Equipment added successfully';
            if (!empty($serial_numbers)) {
                $success .= "<br>SN: " . implode(', ', $serial_numbers);
            } else {
                $success .= "<br>Quantity: $quantity";
            }
            $success .= "<br>Store: $storeId";
            $success = urlencode($success);
            header("Location: ../pages/dashboard.php?page=add_equipment&success=$success");
            exit();
        } catch (Exception $e) {
            // Redirect with error if any exceptions occur
            header("Location: ../pages/dashboard.php?page=add_equipment&error=" . urlencode($e->getMessage()));
            exit();
        }
    } else {
        // Redirect with errors if validation fails
        $error = implode('<br>', $errors);
        header("Location: ../pages/dashboard.php?page=add_equipment&error=" . urlencode($error));
        exit();
    }
} else {
    // Handle case where the form wasn't submitted properly
    header("Location: ../pages/dashboard.php?page=add_equipment&error=nothing+submitted");
    exit();
}
