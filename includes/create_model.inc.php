<?php
require_once '../includes/class_autoloader.inc.php';

if (isset($_POST['submit'])) {
    $modelName = $_POST['model_name'];
    $totalPorts = $_POST['number_of_ports'];
    $powerRating = $_POST['power_rating'];
    $brandId = $_POST['brand_id'];
    $portTypes = $_POST['port_types']; // Array of selected port types
    $quantities = $_POST['quantities']; // Quantities corresponding to port types

    $modelController = new ModelCtrl();

    try {
        // Create the model first
        $modelId = $modelController->createModel(null, $modelName, $totalPorts, null, $powerRating, $brandId, null); // Null for port types

        // Now add port types and their quantities
        foreach ($portTypes as $portTypeId) {
            $quantity = isset($quantities[$portTypeId]) ? (int)$quantities[$portTypeId] : 0;
            if ($quantity > 0) {
                // Call a method to add to the model_port_types junction table
                $modelPortTypeCtrl = new ModelPortTypeCtrl();
                $modelPortTypeCtrl->addPortType($modelId, $portTypeId); // Assuming this method exists
            }
        }

        header("Location: ../pages/dashboard.php?page=model_list&success=modelcreated");
    } catch (Exception $e) {
        header("Location: ../pages/dashboard.php?page=create_model&error=" . urlencode($e->getMessage()));
    }
}
