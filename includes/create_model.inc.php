
<?php
require_once '../includes/class_autoloader.inc.php';

if (isset($_POST['submit'])) {
    $modelName = $_POST['model_name'];
    $brandId = (int)$_POST['brand_id'];
    $powerRating = $_POST['power_rating'];
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 0 ; 

    
    // Initialize arrays to hold port types and quantities
    $portTypes = isset($_POST['port_types']) ? $_POST['port_types'] : [];
    $quantities = isset($_POST['quantities']) ? $_POST['quantities'] : [];

    // Calculate total number of ports based on selected port types and their quantities
    $totalPorts = 0;
    $selectedPorts = [];

    foreach ($portTypes as $portTypeId) {
        $quantity = isset($quantities[$portTypeId]) ? (int)$quantities[$portTypeId] : 0;
        if ($quantity > 0) {
            $totalPorts += $quantity;
            $selectedPorts[$portTypeId] = $quantity; // Store the quantity for each selected port type
        }
    }

    // Prepare the port types as a JSON object
    $portTypesJson = json_encode($selectedPorts);

    // Validate required fields
    if (empty($modelName) || empty($brandId) || $totalPorts <= 0) {
        header("Location: ../pages/dashboard.php?page=create_model&error=emptyfields");
        exit();
    }

    // Create Model instance and call the method to create the model
    $modelController = new ModelCtrl();

    try {
        $modelController->createModel($modelName, $brandId, $powerRating, $portTypesJson, $quantity);

        header("Location: ../pages/dashboard.php?page=model_list&success=modelcreated");
    } catch (Exception $e) {
        header("Location: ../pages/dashboard.php?page=create_model&error=" . urlencode($e->getMessage()));
    }

    exit();
} else {
    header("Location: ../pages/dashboard.php?page=create_model");
    exit();
}
