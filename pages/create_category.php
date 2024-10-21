<div class="model_container model_mt-5">
        <h2 class="model_mb-4">Add Category</h2>
<form action="../includes/create_category.inc.php" method="POST">
<div class="model_form-group">
    <label for="category_name">Category Name:</label><br>
    <input type="text" name="category_name" id="category_name" required><br>
</div>
    <button type="submit" name="submit">Create Category</button>
</form>

<!-- Links to other operations -->
<div class="link-container">
      <a href="dashboard.php?page=category_list" class="link">View All Categories</a> 
</div>
</div>
