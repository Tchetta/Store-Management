<?php
require_once '../includes/class_autoloader.inc.php';

if (!isset($_GET['id'])) {
    header("Location: ../pages/dashboard.php?page=store_list&error=no+store+selected");
    exit();
}

// Fetch the store details
$storeController = new StoreCtrl();
$store = $storeController->getStoreById($_GET['id']);

if (!$store) {
    header("Location: ../pages/dashboard.php?page=store_list&error=store+not+found");
    exit();
}

// Handle errors or success messages
$message = '';
if (isset($_GET['error'])) {
    $message = '<p style="color:red;">Error: ' . htmlspecialchars($_GET['error']) . '</p>';
} elseif (isset($_GET['success'])) {
    $message = '<p style="color:green;">Store updated successfully!</p>';
}
?>



<div class="model_container model_mt-5">
    <h2>Edit Store</h2>
    
    <?php echo $message; ?>

    <form action="../includes/edit_store.inc.php" method="POST">
        <input type="hidden" name="store_id" value="<?php echo htmlspecialchars($store['store_id']); ?>">

        <div class="model_form-group">
            <label for="store_name">Store Name:</label>
            <input type="text" name="store_name" id="store_name" value="<?php echo htmlspecialchars($store['store_name']); ?>" required>
        </div>

        <div class="model_form-group">
            <label for="store_location">Store Location:</label>
            <input type="text" name="store_location" id="store_location" value="<?php echo htmlspecialchars($store['store_location']); ?>" required>
        </div>

        <button type="submit" name="submit">Update Store</button>
    </form>

    <div class="link-container">
    <a href="dashboard.php?page=store_list" class="link">View Stores</a></p>
</div>
</div>

