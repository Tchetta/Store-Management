<?php 
require_once '../includes/class_Autoloader.inc.php';

$storeCtrl = new StoreCtrl(); // Assuming StoreCtrl exists
$modelCtrl = new ModelCtrl();
$brandCtrl = new BrandCtrl();
$categoryCtrl = new ProductCategoryCtrl();

$brands = $brandCtrl->getAllBrands(); // Fetch all brands
$categories = $categoryCtrl->getAllCategories(); // Fetch all categories
$stores = $storeCtrl->getAllStores(); // Fetch all categories

$models =  $_GET['models'] ?? [];

?>

<?php
// Retrieve filtered models from URL if available
$models = [];
if (isset($_GET['models'])) {
    $models = unserialize(urldecode($_GET['models']));
}

$selectedBrand = $_GET['brand'] ?? '';
$selectedCategory = $_GET['category'] ?? '';
?>

<h1>Add Product</h1>

<!-- Form to select brand and category -->
<form action="../includes/fetch_models.inc.php" method="post" id="filterForm">
    <div>
        <label for="brand">Brand:</label>
        <select id="brand" name="brand" onchange="document.getElementById('filterForm').submit()">
            <option value="">Select Brand</option>
            <?php foreach ($brands as $brand): ?>
                <option value="<?= $brand['brand_name'] ?>" <?= $selectedBrand == $brand['brand_name'] ? 'selected' : '' ?>><?= $brand['brand_name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label for="category">Category:</label>
        <select id="category" name="category" onchange="document.getElementById('filterForm').submit()">
            <option value="">Select Category</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['category_name'] ?>" <?= $selectedCategory == $category['category_name'] ? 'selected' : '' ?>><?= $category['category_name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</form>

<!-- Form for submitting product -->
<form action="../includes/add_equipment.inc.php" method="POST">
    <div>
        <input type="hidden" name="category" value="<?= $selectedCategory ?>">
        <input type="hidden" name="brand" value="<?= $selectedBrand ?>">
    </div>

    <div>
        <label for="store_name">Store:</label>
        <select id="store_name" name="store_id" required>
            <option value="">Select Store</option>
            <?php foreach ($stores as $store): ?>
                <option value="<?= $store['store_id'] ?>"><?= $store['store_name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
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

    <div>
        <label for="serial_number">Serial Number:</label>
        <input type="text" id="serial_number" name="serial_num" placeholder="Optional">
    </div>

    <button type="submit" name="submit">Add Product</button>
</form>

