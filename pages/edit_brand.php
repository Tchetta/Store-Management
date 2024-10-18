<?php
$brandController = new BrandCtrl();
$brand = $brandController->getBrandById($_GET['brand_id']);
?>

<form action="../includes/edit_brand.inc.php" method="POST">
    <input type="hidden" name="brand_id" value="<?php echo $brand['brand_id']; ?>">

    <label for="brand_name">Brand Name:</label>
    <input type="text" name="brand_name" value="<?php echo $brand['brand_name']; ?>" required><br>

    <label for="description">Description:</label>
    <textarea name="description"><?php echo $brand['description']; ?></textarea><br>

    <label for="quantity">Quantity:</label>
    <input type="number" name="quantity" value="<?php echo $brand['quantity']; ?>" min="0"><br><br>

    <button type="submit" name="submit">Update Brand</button>
</form>

<!-- Links to other operations -->
<a href="dashboard.php?page=create_brand">Create New Brand</a> | 
<a href="dashboard.php?page=brand_list">View All Brands</a>
