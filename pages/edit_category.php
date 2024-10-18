<?php
require_once '../includes/class_autoloader.inc.php';

if (isset($_GET['id'])) {
    $categoryId = $_GET['id'];

    // Initialize the control class and get the category data
    $categoryController = new ProductCategoryCtrl();

    // Fetch category by ID
    $category = $categoryController->getCategoryById($categoryId);

    if (!$category) {
        header("Location: dashboard.php?page=category_list&error=categorynotfound");
        exit();
    }
} else {
    header("Location: dashboard.php?page=category_list&error=missingid");
    exit();
}
?>
<div class="container">
<h2>Edit Category</h2>
    

<!-- Edit Category Form -->
<form action="../includes/edit_category.inc.php" method="POST">
    <input type="hidden" name="category_id" value="<?php echo $category['category_id']; ?>">

    <div class="model_form-group">
    <label for="category_name">Category Name:</label><br>
    <input type="text" name="category_name" value="<?php echo $category['category_name']; ?>" required><br>
    </div>
    
    <div class="model_form-group">
    <label for="quantity">Quantity:</label><br>
    <input type="number" name="quantity" value="<?php echo $category['quantity']; ?>" min="0"><br><br>
    </div>
    <button type="submit" name="submit">Update Category</button>
</form>

<!-- Links to other operations -->
<div class="link-container">
    <a href="dashboard.php?page=category_list" class="link">View All Categories</a>
</div>

</div>
