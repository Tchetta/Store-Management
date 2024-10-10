<form action="../includes/create_brand.inc.php" method="POST">
    <label for="brand_name">Brand Name:</label>
    <input type="text" name="brand_name" required><br>

    <label for="description">Description:</label>
    <textarea name="description"></textarea><br>

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
    </select><br>

    <label for="quantity">Quantity:</label>
    <input type="number" name="quantity" min="0"><br><br>

    <button type="submit" name="submit">Create Brand</button>
</form>

<!-- Links to other operations -->
<a href="dashboard.php?page=brand_list">View All Brands</a>
<a href="dashboard.php?page=create_category">Create New Category</a>

