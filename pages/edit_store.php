<?php
require_once '../includes/class_autoloader.inc.php';

if (!isset($_GET['id'])) {
    header("Location: ../pages/dashboard.php?page=store_list&error=nostoreselected");
    exit();
}

// Fetch the store details
$storeController = new StoreCtrl();
$store = $storeController->getStoreById($_GET['id']);

if (!$store) {
    header("Location: ../pages/dashboard.php?page=store_list&error=storenotfound");
    exit();
}

// Handle errors or success messages
if (isset($_GET['error'])) {
    echo '<p style="color:red;">Error: ' . htmlspecialchars($_GET['error']) . '</p>';
} elseif (isset($_GET['success'])) {
    echo '<p style="color:green;">Store updated successfully!</p>';
}
?>

<h2>Edit Store</h2>
<form action="../includes/edit_store.inc.php" method="POST">
    <input type="hidden" name="store_id" value="<?php echo htmlspecialchars($store['store_id']); ?>">

    <label for="store_name">Store Name:</label>
    <input type="text" name="store_name" id="store_name" value="<?php echo htmlspecialchars($store['store_name']); ?>" required><br>

    <label for="store_location">Store Location:</label>
    <input type="text" name="store_location" id="store_location" value="<?php echo htmlspecialchars($store['store_location']); ?>" required><br>

    <button type="submit" name="submit">Update Store</button>
</form>

<p><a href="dashboard.php?page=create_user">Create New User</a></p>
<p><a href="dashboard.php?page=store_list">View Stores</a></p>
