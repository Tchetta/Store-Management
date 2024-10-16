<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
</head>
<body>
    <h1>Manage Products</h1>
    <form action="../includes/create_product.inc.php" method="post">
        <h2>Add Product</h2>
        <input type="text" name="model_name" placeholder="Model Name" required>
        <input type="number" name="quantity" placeholder="Quantity" required>
        <input type="text" name="number_of_ports" placeholder="Number of Ports" required>
        <input type="text" name="power_rating" placeholder="Power Rating" required>
        <input type="text" name="brand_id" placeholder="Brand ID" required>
        <button type="submit" name="add_product">Add Product</button>
    </form>

    <form method="post">
        <h2>Remove Quantity</h2>
        <input type="text" name="remove_model_name" placeholder="Model Name" required>
        <input type="number" name="remove_quantity" placeholder="Quantity to Remove" required>
        <button type="submit" name="remove_product">Remove Quantity</button>
    </form>

    <?php if (isset($message)) : ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
</body>
</html>