<?php
// Include necessary files and initialize ModelCtrl
require_once '../includes/class_autoloader.inc.php';
require_once './imageUpload.inc.php';

if (isset($_POST['submit'])) {
    // Get the form data
    $modelId = $_POST['model_id'];
    $modelName = $_POST['model_name'];
    $brand = $_POST['brand_id'];
    $category = $_POST['category_id'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    $specification = $_POST['specification'];
    $portTypes = $_POST['portTypes'];
    $imagePath = 'default.png'; // Default image path

    // Handle image upload
    $imageDir = '../uploads/model_image/';
    $imagePath = handleImageUpload($_FILES['model_image'], $imageDir);

    // Initialize ModelCtrl and update the model
    $modelCtrl = new ModelCtrl();

    // Set the updated model data
    $modelCtrl->setModelName($modelId, $modelName);
    $modelCtrl->setBrand($modelId, $brand);
    $modelCtrl->setCategory($modelId, $category);
    $modelCtrl->setQuantity($modelId, $quantity);
    $modelCtrl->setDescription($modelId, $description);
    $modelCtrl->setSpecification($modelId, $specification);
    $modelCtrl->setPortTypes($modelId, $portTypes); // Port types stored as formatted text
    $modelCtrl->updateImagePath($modelId, $imagePath);

    // Redirect to the models list page after editing
    header('Location: ../pages/dashboard.php?page=model_list&success=edit');
    exit();
} else {
    // If form not submitted, redirect to the models list page
    header('Location: ../pages/dashboard.php?page=model_list');
    exit();
}
