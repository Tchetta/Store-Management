<?php 
require_once '../includes/class_Autoloader.inc.php';

$modelCtrl = new ModelCtrl();

$brand = $_POST['brand'] ?? null;
$category = $_POST['category'] ?? null;

// Fetch models based on the selected brand or category
$models = $modelCtrl->getModelsByBrandOrCategory($brand, $category);

// Serialize the models array to pass it via URL (Alternatively, use sessions or store data differently)
$models = urlencode(serialize($models));

// Redirect back to the page with the models in the URL
header("Location: ../pages/dashboard.php?page=add_equipment&models={$models}&brand={$brand}&category={$category}");
exit();
?>
