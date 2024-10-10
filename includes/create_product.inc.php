<?php
require_once '../includes/class_autoloader.inc.php';

if (isset($_POST['submit'])) {
    $storeId = $_POST['store_id'];
    $productId = $_POST['product_id'];
    $stateId = $_POST['state_id'];
    $description = $_POST['description'];
    $specification = $_POST['specification'];
    
    // Handle multiple models and quantities
    $modelsSelected = $_POST['model_id']; // Array of selected models
    $modelQuantities = $_POST['model_quantity']; // Array of quantities keyed by model_id
    
    $productController = new ProductDetailsCtrl();
    $modelCtrl = new ModelCtrl();
    $brandCtrl = new BrandCtrl();
    $categoryCtrl = new ProductCategoryCtrl();

    try {
        // Iterate over each selected model and quantity
        foreach ($modelsSelected as $modelId) {
            $quantity = $modelQuantities[$modelId];

            // Create the product entry for each model
            $productController->createProduct($storeId, $productId, $modelId, $stateId, $description, $specification, $quantity);

            // Update the quantity in the model table
            $modelCtrl->increaseQuantity($modelId, $quantity);

            // Get the brand associated with the model and update brand quantity
            $brandId = $modelCtrl->getBrandIdByModel($modelId);
            $brandCtrl->updateBrandQuantity($brandId);

            // Finally, update the product category quantity based on the brand's models
            $categoryCtrl->updateCategoryQuantity($productId);
        }

        header("Location: ../pages/dashboard.php?page=product_list&success=productcreated");
    } catch (Exception $e) {
        header("Location: ../pages/dashboard.php?page=create_product&error=" . urlencode($e->getMessage()));
    }
}
?>
