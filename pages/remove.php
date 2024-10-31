<?php 
require_once '../includes/class_Autoloader.inc.php';

$storeCtrl = new StoreCtrl();
$modelCtrl = new ModelCtrl();
$brandCtrl = new BrandCtrl();
$categoryCtrl = new ProductCategoryCtrl();

$brands = $brandCtrl->getAllBrands();
$categories = $categoryCtrl->getAllCategories();
$stores = $storeCtrl->getAllStores();

if ($user_role === 'store manager') {
    $storeId = $storeCtrl->getStoreByManagerId($user_id);
    if (!isset($storeId) || $storeId == '') {
        $error = 'No store assigned to you';
        header("Location: dashboard.php?error=" . urlencode($error));
        exit();
    }
}

$models = $_GET['models'] ?? [];
?>

<div class="model_container model_mt-5">
    <h2 class="model_mb-4">Remove Product</h2>

    <!-- Form to select brand and category -->
    <form action="../includes/fetch_models.inc.php" method="post" id="filterForm">
        <!-- (Similar brand and category dropdowns as before) -->
    </form>

    <!-- Form for submitting product removal -->
    <form action="../includes/remove_equipment.inc.php" method="POST">
        <input type="hidden" name="category" value="<?= $selectedCategory ?>">
        <input type="hidden" name="brand" value="<?= $selectedBrand ?>">
        
        <div class="model_form-group">
            <label for="store_name">Store:</label>
            <select id="store_name" name="store_id" required hidden>
                <option value="<?= $storeId ?>"><?= $store['store_name'] ?></option>
            </select>
        </div>

        <div class="model_form-group">
            <label for="model">Model:</label>
            <select id="model" name="model_id" required>
                <option value="">Select Model</option>
                <?php if (!empty($models)): ?>
                    <?php foreach ($models as $model): ?>
                        <option value="<?= $model['model_id'] ?>"><?= $model['model_name'] ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <div class="model_form-group">
            <label for="serial_number">Serial Number(s):</label>
            <textarea id="serial_number" name="serial_num" placeholder="Enter serial numbers, separated by commas"></textarea>
        </div>

        <div class="model_form-group">
            <label for="quantity">Quantity to Remove:</label>
            <input type="number" id="quantity" name="quantity" min="1" placeholder="Enter quantity if no serial numbers are specified">
        </div>

        <button type="submit" name="submit">Remove Product</button>
        <a href="dashboard.php?page=equipment_list">View All Product</a>
    </form>
</div>
