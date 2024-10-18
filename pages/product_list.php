<?php require_once "../includes/search.inc.php" ?>

<div class="view-store-container">
    <!-- Links to other operations -->
<div class="create_container">
    <a href="dashboard.php?page=add_product" class="create-link">Add Product</a>
</div>

<h2 class="h2">Product List</h2>
    <form action="" method="POST">
        <input type="text" name="search_term" placeholder="Search products..." required>
        <label for="sort_by">Sort By:</label>
        <select name="sort_by">
            <option value="model_name">Model</option>
            <option value="store_name">Store</option>
            <option value="product_name">Product Category</option>
            <option value="state_name">State</option>
        </select>

        <div>
            <label>
                <input type="radio" name="search_criteria" value="description" checked>
                Description
            </label>
            <label>
                <input type="radio" name="search_criteria" value="specification">
                Specification
            </label>
        </div>
        
        <button type="submit">Search</button>
    </form>
</div>

<table class="store-table">
    <thead>
        <tr>
            <th>Serial Number</th>
            <th>Store Name</th>
            <th>Product Category</th>
            <th>Brand Name</th>
            <th>Model Name</th>
            <th>State Name</th>
            <th>Description</th>
            <th>Specification</th>
            <th>In Date</th>
            <th>Out Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($products) > 0): ?>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo $product['serial_num']; ?></td>
                    <td><?php echo $product['store_name']; ?></td>
                    <td><?php echo $product['product_name']; ?></td>
                    <td><?php echo $product['brand_name']; ?></td>
                    <td><?php echo $product['model_name']; ?></td>
                    <td><?php echo $product['state_name']; ?></td>
                    <td><?php echo htmlspecialchars($product['description']); ?></td>
                    <td><?php echo htmlspecialchars($product['specification']); ?></td>
                    <td><?php echo $product['indate']; ?></td>
                    <td><?php echo $product['outdate']; ?></td>
                    <td>
                        <a class="action-link" href="edit_product.php?serial_num=<?php echo $product['serial_num']; ?>">Edit</a>
                        <a class="action-link delete" href="../includes/delete_product.inc.php?serial_num=<?php echo $product['serial_num']; ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="11">No products found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

