<?php 
require_once '../includes/class_Autoloader.inc.php';

$storeCtrl = new StoreCtrl(); // Assuming StoreCtrl exists
$modelCtrl = new ModelCtrl();
$brandCtrl = new BrandCtrl();
$categoryCtrl = new ProductCategoryCtrl();

$brands = $brandCtrl->getAllBrands(); // Fetch all brands
$categories = $categoryCtrl->getAllCategories(); // Fetch all categories
$models = [];

// Check if the form has been submitted
/* if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $storeName = $_POST['store_name'];
    $modelId = $_POST['model'];
    $serialNumber = $_POST['serial_number'];

    // Handle the form submission here (insert into database, etc.)
    // ...
} */

// Filter models based on selected brand and category
$brandId = $_GET['brand'] ?? null;
$categoryId = $_GET['category'] ?? null;

if ($brandId || $categoryId) {
    $models = $modelCtrl->getModelsByBrandOrCategory($brandId, $categoryId); // Use the new method
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="path/to/your/styles.css">
</head>
<body>

<h1>Add Product</h1>
<form action="dashboard.php?page=add_product" method="GET">
    <div>
        <label for="store_name">Store Name:</label>
        <input type="text" id="store_name" name="store_name" required>
    </div>

    <div>
        <label for="brand">Brand:</label>
        <select id="brand" name="brand" onchange="this.form.submit()">
            <option value="">Select Brand</option>
            <?php foreach ($brands as $brand): ?>
                <option value="<?= $brand['brand_id'] ?>" <?= ($brandId == $brand['brand_id']) ? 'selected' : '' ?>>
                    <?= $brand['brand_name'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label for="category">Category:</label>
        <select id="category" name="category" onchange="this.form.submit()">
            <option value="">Select Category</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['category_id'] ?>" <?= ($categoryId == $category['category_id']) ? 'selected' : '' ?>>
                    <?= $category['category_name'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
</form>

<form action="../includes/add_product.inc.php" method='post'>
    <div>
        <label for="model">Model:</label>
        <select id="model" name="model" required>
            <option value="">Select Model</option>
            <?php foreach ($models as $model): ?>
                <option value="<?= $model['model_id'] ?>"><?= $model['model_name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label for="serial_number">Serial Number:</label>
        <input type="text" id="serial_number" name="serial_number" placeholder="Optional">
    </div>

    <button type="submit">Add Product</button>
</form>

</body>
</html>
