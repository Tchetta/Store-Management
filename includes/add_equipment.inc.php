<?php
require_once 'class_autoloader.inc.php';

if (isset($_POST['submit'])) {
    // Initialize error array
    $errors = [];

    
    $category = filter_var($_POST['category'], FILTER_SANITIZE_STRING);
    $brand = filter_var($_POST['brand'], FILTER_SANITIZE_STRING);

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

    /* // CSRF Protection: Check if the token is valid (assumes CSRF token is being stored in session)
    session_start();
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $errors[] = "Invalid request.";
    } */

    // If there are no errors, proceed with the operation
    if (empty($errors)) {
        try {
            // Using a controller to add equipment
            $equipmentController = new EquipmentCtrl();
            $equipmentController->addEquipment($serial_num, $storeId, $modelId, $category, $brand);

            // Update the model quantity
            $modelController = new ModelCtrl();
            $modelController->updateModelQuantity($modelId);

            // Log the event (assuming `Event` class has proper protection)
            $eventCtrl = new Event();
            $eventCtrl->additionEvent($modelId, 1, 'IN');

            // Redirect on success
            header("Location: ../pages/dashboard.php?page=add_equipment&success=true");
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
