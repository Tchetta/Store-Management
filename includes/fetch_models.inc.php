<?php 
require_once '../includes/class_Autoloader.inc.php';

$modelCtrl = new ModelCtrl();

$brand = $_POST['brand'] ?? null;
$category = $_POST['category'] ?? null;
$remove = $_POST['remove'] ?? null;
$modelId = $_POST['model_id'] ?? null;

// Fetch models based on the selected brand or category
$models = $modelCtrl->getModelsByBrandOrCategory($brand, $category);

// Serialize the models array to pass it via URL (Alternatively, use sessions or store data differently)
$models = urlencode(serialize($models));

// Redirect back to the page with the models in the URL
if (isset($remove) && $remove) {
    header("Location: ../pages/dashboard.php?page=remove&models={$models}&brand={$brand}&category={$category}&model_id={$modelId}");
    exit();
} else {
    header("Location: ../pages/dashboard.php?page=add_equipment&models={$models}&brand={$brand}&category={$category}&model_id={$modelId}");
    exit();
}

?>
