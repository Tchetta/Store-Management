<?php
if (isset($_POST['submit'])) {
    $modelName = $_POST['model_name'];
    $powerRating = $_POST['power_rating'];
    $brandId = $_POST['brand_id'];
    $totalPorts = isset($_POST['number_of_ports']) ? $_POST['number_of_ports'] : 0;
    $portTypes = isset($_POST['port_types']) ? $_POST['port_types'] : [];
    $quantities = isset($_POST['quantities']) ? $_POST['quantities'] : [];

    // Add the model to the 'model' table
    $modelCtrl = new ModelPortTypeCtrl();
    $modelId = $modelCtrl->addModel($modelName, $totalPorts, $powerRating, $brandId);

    // If port types are selected, link them with the model
    if (!empty($portTypes)) {
        foreach ($portTypes as $portTypeId) {
            $quantity = isset($quantities[$portTypeId]) ? (int)$quantities[$portTypeId] : 0;
            $modelCtrl->linkModelToPortTypes($modelId, [$portTypeId]); // Update link table
        }
    }

    // Redirect to model list or display a success message
    header("Location: ../pages/model_list.php");
    exit();
}
