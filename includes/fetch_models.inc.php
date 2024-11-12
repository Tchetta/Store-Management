<?php 
require_once '../includes/class_Autoloader.inc.php';

$modelCtrl = new ModelCtrl();

$brand = $_POST['brand'] ?? null;
$category = $_POST['category'] ?? null;
$remove = $_POST['remove'] ?? null;
$modelId = $_POST['model_id'] ?? null;

if (isset($remove) && $remove !== '') {
    $page = 'remove';
} else {
    $page = 'add_equipment';
}
// Fetch models based on the selected brand or category
try {
    $models = $modelCtrl->getModelsByBrandOrCategory($brand, $category);
    $models = urlencode(serialize($models));
} catch (PDOException $th) {
    $error = "Select a valid brand";
    header("Location: ../pages/dashboard.php?page=$page&error=$error");
    exit();
}

// Serialize the models array to pass it via URL (Alternatively, use sessions or store data differently)

// Redirect back to the page with the models in the URL
header("Location: ../pages/dashboard.php?page=$page&models={$models}&brand={$brand}&category={$category}&model_id={$modelId}");
exit();
?>
