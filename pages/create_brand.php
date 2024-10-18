<form action="../includes/create_brand.inc.php" method="POST">
    <label for="brand_name">Brand Name:</label>
    <input type="text" name="brand_name" required><br>

    <label for="description">Description:</label>
    <textarea name="description"></textarea><br>

    <button type="submit" name="submit">Create Brand</button>
</form>

<!-- Links to other operations -->
<a href="dashboard.php?page=brand_list">View All Brands</a>
<a href="dashboard.php?page=create_brand">Create New Brand</a>
