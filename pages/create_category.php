<form action="../includes/create_category.inc.php" method="POST">

    <label for="category_name">Category Name:</label><br>
    <input type="text" name="category_name" id="category_name" required><br>

    <button type="submit" name="submit">Create Category</button>
</form>

<!-- Links to other operations -->
<div>
    <a href="dashboard.php?page=category_list">View All Categories</a> | 
    <a href="dashboard.php?page=edit_category">Edit a Category</a>
</div>
