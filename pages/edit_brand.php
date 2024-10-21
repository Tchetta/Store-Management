<?php
$brandController = new BrandCtrl();
$brand = $brandController->getBrandById($_GET['brand_id']);
?>
 <div class="model_container model_mt-5">
 <h2 class="model_mb-4">Edit Brand: <?php echo htmlspecialchars($model['model_name']); ?></h2>
<form action="../includes/edit_brand.inc.php" method="POST">
    <input type="hidden" name="brand_id" value="<?php echo $brand['brand_id']; ?>">
    <div class="model_form-group">
    <label for="brand_name">Brand Name:</label>
    <input type="text" name="brand_name" value="<?php echo $brand['brand_name']; ?>" required><br>
    </div>
    <div class="model_form-group">
    <label for="description">Description:</label>
    <textarea name="description"><?php echo $brand['description']; ?></textarea><br>
    </div>
    <div class="model_form-group">
    <label for="quantity">Quantity:</label>
    <input type="number" name="quantity" value="<?php echo $brand['quantity']; ?>" min="0"><br><br>
    </div>
    <button type="submit" name="submit">Update Brand</button>
</form>

<!-- Links to other operations -->
<div class="link-container">
<a href="dashboard.php?page=brand_list" class="link">View All Brands</a>
</div>
 </div>