

<?php
require_once '../includes/class_autoloader.inc.php';
// #################

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

// Check if port types are set
if (isset($_POST['port_types'])) {
    $portTypes = $_POST['port_types']; // Get the selected port types
    $quantities = $_POST['quantities']; // Get the quantities for each port type

    foreach ($portTypes as $portTypeId => $value) {
        $port_quantity = isset($quantities[$portTypeId]) ? (int)$quantities[$portTypeId] : 0;
        if ($port_quantity > 0) {
            $totalPorts += $port_quantity;

            // Fetch the port name using PortTypeCtrl::getPortName
            $portName = $portTypeController->getPortName($portTypeId);
            if (is_string($portName) && !empty($portName)) {
                // Store the port name and its quantity in the selectedPorts array
                $selectedPorts[] = [
                    'port_name' => $portName,
                    'quantity' => $port_quantity
                ];
            } else {
                error_log("Invalid port name for portTypeId: $portTypeId");
                continue; // Skip invalid port names
            }
        }
    }
}

// Prepare the port types as a JSON object
$portTypesJson = json_encode($selectedPorts);

    // Validate required fields
    if (empty($modelName) || empty($brandId) || $totalPorts <= 0) {
        header("Location: ../pages/dashboard.php?page=create_model&error=emptyfields");
        exit();
    }

    // Handle image upload
    $imagePath = 'uploads/model_img/default.png'; // Default image path
    if (isset($_FILES['model_image']) && $_FILES['model_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/model_img/';
        $uploadFile = $uploadDir . basename($_FILES['model_image']['name']);
        $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

        // Check if the file is an image
        $check = getimagesize($_FILES['model_image']['tmp_name']);
        if ($check !== false) {
            // Move the uploaded file to the designated folder
            if (move_uploaded_file($_FILES['model_image']['tmp_name'], $uploadFile)) {
                $imagePath = $uploadFile; // Set the image path to the uploaded file
            } else {
                // Log or handle the error
                error_log("Error uploading the file.");
            }
        } else {
            error_log("File is not an image.");
        }
    }

    // Create Model instance and call the method to create the model
    $modelController = new ModelCtrl();

    try {
        $modelController->createModel($modelName, $brandId, $powerRating, $portTypesJson, $model_quantity, $imagePath);
        header("Location: ../pages/dashboard.php?page=model_list&success=modelcreated");
    } catch (Exception $e) {
        header("Location: ../pages/dashboard.php?page=create_model&error=" . urlencode($e->getMessage()));
    }

    exit();
} else {
    header("Location: ../pages/dashboard.php?page=create_model");
    exit();
}
