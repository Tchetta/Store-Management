<?php
$brandController = new BrandCtrl();
$brands = $brandController->getAllBrands();
$categoryController = new ProductCategoryCtrl();
?>

<table>
    <tr>
        <th>Brand ID</th>
        <th>Brand Name</th>
        <th>Description</th>
        <th>Quantity</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($brands as $brand) : ?>
    <tr>
        <td><?php echo $brand['brand_id']; ?></td>
        <td><?php echo $brand['brand_name']; ?></td>
        <td><?php echo $brand['description']; ?></td>
        <td><?php echo $brand['quantity']; ?></td>
        <td>
            <a href="dashboard.php?page=edit_brand&brand_id=<?php echo $brand['brand_id']; ?>">Edit</a> | 
            <a href="../includes/delete_brand.inc.php?brand_id=<?php echo $brand['brand_id']; ?>">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<!-- Links to other operations -->
<a href="dashboard.php?page=create_brand">Create New Brand</a>
