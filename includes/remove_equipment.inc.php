<?php
require_once '../includes/class_Autoloader.inc.php';

if (isset($_POST['remove_submit'])) {
    $modelId = $_POST['model_id'];
    $removeSerialNums = $_POST['remove_serial_num'];
    $removeQuantity = $_POST['remove_quantity'];

    $equipmentCtrl = new EquipmentCtrl();

    // Check for serial numbers
    if (!empty($removeSerialNums)) {
        $serialNumbers = array_map('trim', explode(',', $removeSerialNums));
        
        $errors = [];  // Array to collect errors

        foreach ($serialNumbers as $serial) {
            try {
                $equipmentCtrl->removeEquipmentBySerial($modelId, $serial);
            } catch (Exception $e) {
                // Store the error message for this serial number
                $errors[] = "Error with serial number {$serial}: " . $e->getMessage();
            }
        }

        // Redirect with errors if any
        if (!empty($errors)) {
            // Convert errors to a query parameter
            $errorString = urlencode(implode(', ', $errors));
            header("Location: ../pages/dashboard.php?page=remove_equipment&error={$errorString}");
            exit();
        } else {
            // Redirect to success page if no errors
            header("Location: ../pages/dashboard.php?page=remove_equipment&success=Equipment removed successfully");
            exit();
        }

        
        $message = count($serialNumbers) . " equipment items removed based on serial numbers.";
    } 
    // Check for quantity if serial numbers are not provided
    elseif (!empty($removeQuantity)) {
        $equipmentCtrl->removeEquipmentByQuantity($modelId, $removeQuantity);
        $message = "$removeQuantity items removed from inventory.";
    } else {
        $error = "Please provide either serial numbers or a quantity to remove.";
        header("Location: ../pages/dashboard.php?page=remove_equipment&error=" . urlencode($error));
        exit();
    }

    header("Location: ../pages/dashboard.php?page=remove_equipment&success=" . urlencode($message));
    exit();
}
