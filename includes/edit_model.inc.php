<?php
require_once '../includes/class_autoloader.inc.php';

if (isset($_POST['submit'])) {
    $modelId = $_POST['model_id'];
    $modelName = $_POST['model_name'];
    $numberOfPorts = $_POST['number_of_ports'];
    $portTypes = $_POST['port_types'];
    $powerRating = $_POST['power_rating'];
    $brandId = $_POST['brand_id'];
    $quantity = $_POST['quantity'];

    $modelController = new ModelCtrl();

    try {
        $modelController->updateModel($modelId, $modelName, $numberOfPorts, $portTypes, $powerRating, $brandId, $quantity);
        header("Location: ../pages/dashboard.php?page=model_list&success=modelupdated");
    } catch (Exception $e) {
        header("Location: ../pages/dashboard.php?page=edit_model&id=$modelId&error=" . urlencode($e->getMessage()));
    }
}
