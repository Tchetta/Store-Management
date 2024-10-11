<?php
require_once '../includes/class_autoloader.inc.php';

if (isset($_POST['submit'])) {
    $modelName = $_POST['model_name'];
    $brandId = (int)$_POST['brand_id'];
    $powerRating = $_POST['power_rating'];
    $model_quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 0;

    // Initialize arrays to hold port types and quantities
    $portTypes = isset($_POST['port_types']) ? $_POST['port_types'] : [];
    $quantities = isset($_POST['quantities']) ? $_POST['quantities'] : [];

    // Initialize PortTypeCtrl to fetch port names
    $portTypeController = new PortTypeCtrl();

    // Calculate total number of ports based on selected port types and their quantities
    $totalPorts = 0;
    $selectedPorts = [];

    foreach ($portTypes as $portTypeId) {
        $port_quantity = isset($quantities[$portTypeId]) ? (int)$quantities[$portTypeId] : 0;
        if ($port_quantity > 0) {
            $totalPorts += $port_quantity;

            // Fetch the port name using PortTypeCtrl::getPortName
            $portName = $portTypeController->getPortName($portTypeId);

            // Debugging: Ensure that portName is valid
            if (is_string($portName) && !empty($portName)) {
                // Store the port name and its quantity in the selectedPorts array
                $selectedPorts[$portName] = $port_quantity;
            } else {
                // Log or handle cases where getPortName doesn't return a valid string
                error_log("Invalid port name for portTypeId: $portTypeId");
                // Optionally, skip invalid port names
                continue;
            }
        }
    }

    // Prepare the port types as a JSON object using the port names
    $portTypesJson = json_encode($selectedPorts);

    // Validate required fields
    if (empty($modelName) || empty($brandId) || $totalPorts <= 0) {
        header("Location: ../pages/dashboard.php?page=create_model&error=emptyfields");
        exit();
    }

    // Create Model instance and call the method to create the model
    $modelController = new ModelCtrl();

    try {
        $modelController->createModel($modelName, $brandId, $powerRating, $portTypesJson, $model_quantity);

        header("Location: ../pages/dashboard.php?page=model_list&success=modelcreated");
    } catch (Exception $e) {
        header("Location: ../pages/dashboard.php?page=create_model&error=" . urlencode($e->getMessage()));
    }

    exit();
} else {
    header("Location: ../pages/dashboard.php?page=create_model");
    exit();
}
