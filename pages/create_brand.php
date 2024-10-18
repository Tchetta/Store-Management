   
    <div class="model_container model_mt-5">
        <h2 class="model_mb-4">Create New Brand</h2>
<form action="../includes/create_brand.inc.php" method="POST">
<div class="model_form-group">
<label for="brand_name">Brand Name:</label>
    <input type="text" name="brand_name" required><br>
</div>
<div class="model_form-group">
    <label for="description">Description:</label>
    <textarea name="description"></textarea><br>
</div>
<div class="model_form-group">
    <label for="category_id">Category:</label>
    <select name="category_id">
        <?php
        // Fetch categories to populate the dropdown
        $categoryController = new ProductCategoryCtrl();
        $categories = $categoryController->getAllCategories();
        foreach ($categories as $category) {
            echo "<option value='{$category['category_id']}'>{$category['category_name']}</option>";
        }
        ?>
    </select><?php echo $category['category_id'] . ' | ' . $category['category_name']; ?><br><br>
</div>

    <button type="submit" name="submit">Create Brand</button>
</form>

<!-- Links to other operations -->

    <a href="dashboard.php?page=brand_list" class="link">View All Brands</a>
    

