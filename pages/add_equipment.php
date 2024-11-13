<?php 
require_once '../includes/class_Autoloader.inc.php';

$storeCtrl = new StoreCtrl(); // Assuming StoreCtrl exists
$modelCtrl = new ModelCtrl();
$brandCtrl = new BrandCtrl();
$categoryCtrl = new ProductCategoryCtrl();

$brands = $brandCtrl->getAllBrands(); // Fetch all brands
$categories = $categoryCtrl->getAllCategories(); // Fetch all categories
$stores = $storeCtrl->getAllStores(); // Fetch all categories

if($user_role === 'store manager') {
    $storeId = $storeCtrl->getStoreByManagerId($user_id);
    if (!isset($storeId) || $storeId == '') {
        $error = 'No store assigned to you (' . $user_name;
        $error = urlencode($error);
        header("Location: dashboard.php?error=$error");
    }
}

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

<div class="model_container model_mt-5">
<h2 class="model_mb-4">Add Product</h2>

<!-- Form to select brand and category -->
<form action="../includes/fetch_models.inc.php" method="post" id="filterForm">
    <div class="model_form-group">
        <label for="brand">Brand:</label>
        <select id="brand" name="brand" onchange="document.getElementById('filterForm').submit()">
            <option value="">Select Brand</option>
            <?php foreach ($brands as $brand): ?>
                <option value="<?= $brand['brand_name'] ?>" <?= $selectedBrand == $brand['brand_name'] ? 'selected' : '' ?>><?= $brand['brand_name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="model_form-group">
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
    <div class="model_form-group">
        <input type="hidden" name="category" value="<?= $selectedCategory ?>">
        <input type="hidden" name="brand" value="<?= $selectedBrand ?>">
    </div>

    <div class="model_form-group">
        <label for="store_name">Store:</label>
        <select id="store_name" name="store_id" required hidden>
            <option value="<?= $storeId ?>"><?= $store['store_name'] ?></option>
        </select>
    </div>

    <div class="model_form-group">
        <label for="model">Model:</label>
        <select id="model" name="model_id">
            <option value="">Select Model</option>
            <?php if (!empty($models)): ?>
                <?php foreach ($models as $model): ?>
                    <option value="<?= $model['model_id'] ?>"><?= $model['model_name'] ?></option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
        <!-- Add this button instead -->
        <a href='dashboard.php?page=create_model' class="btn btn-primary">
            Create New Model
        </a>
    </div>


    <div class="model_form-group">
        <label for="serial_number">Serial Number(s):</label>
        <textarea id="serial_number" name="serial_num" placeholder="Enter serial numbers, separated by commas"></textarea>
    </div>

    <div class="model_form-group">
        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" min="1" placeholder="Enter quantity if no serial numbers are specified">
    </div>
    <!-- State selection box -->
     <?php
        $stateController = new StateCtrl();
        $states = $stateController->getAllStates();
     ?>
    <div class="model_form-group">
        <label for="state">State:</label>
        <select name="state" id="state">
            <?php  foreach ($states as $state): ?>
                <option value="<?= $state['state_name'] ?>"><?= $state['state_name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" name="submit">Add Product</button>
    <div class="back-arrow-container">
    <a href="javascript:history.back()" class="back-arrow">
        &#8592; Back
    </a>
</div>

<div class="link-container">
    <a href="dashboard.php?page=equipment_list_with_search" class="link">View All Product</a>
</div>
</form>

