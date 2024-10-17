<?php
// Include necessary files and initialize ModelCtrl
require_once '../includes/class_autoloader.inc.php';

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

    // Handle image upload if a file was uploaded
    if (isset($_FILES['model_image']) && $_FILES['model_image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['model_image']['tmp_name'];
        $fileName = $_FILES['model_image']['name'];
        $fileSize = $_FILES['model_image']['size'];
        $fileType = $_FILES['model_image']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedFileExtensions = array('jpg', 'gif', 'png', 'jpeg');
        if (in_array($fileExtension, $allowedFileExtensions)) {
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $uploadFileDir = '../uploads/';
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $imagePath = $newFileName; // Set image path to uploaded file
            } else {
                echo "Error moving the uploaded file.";
            }
        } else {
            echo "Unsupported file extension.";
        }
    }

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
