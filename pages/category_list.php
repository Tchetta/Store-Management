<?php
$categoryCtrl = new ProductCategoryCtrl();
$categories = $categoryCtrl->getAllCategories();
?>
<div class="view-store-container">
    <!-- Links to other operations -->
<div class="create_container">
    <a href="dashboard.php?page=create_category" class="create-link">Create New Product category</a>
</div>

<h2 class="h2"> Product Category</h2>
<table >
    <thead>
        <tr>
            <th>Category ID</th>
            <th>Category Name</th>
            <th>Quantity</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $category): ?>
        <tr>
            <td><?php echo $category['category_id']; ?></td>
            <td><?php echo $category['category_name']; ?></td>
            <td><?php echo $category['quantity']; ?></td>
            <td>
                <a  class="action-link" href="dashboard.php?page=edit_category&id=<?php echo $category['category_id']; ?>">Edit</a> | 
                <a  class="action-link delete" href="../includes/delete_category.inc.php?id=<?php echo $category['category_id']; ?>" 
                   onclick="return confirm('Are you sure you want to delete this category?');">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>
