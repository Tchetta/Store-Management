<?php
require_once '../includes/class_autoloader.inc.php';

// Fetch all stores
$storeController = new StoreCtrl();
$stores = $storeController->getAllStores();

// Handle errors or success messages
if (isset($_GET['error'])) {
    echo '<p style="color:red;">Error: ' . htmlspecialchars($_GET['error']) . '</p>';
} elseif (isset($_GET['success'])) {
    echo '<p style="color:green;">' . htmlspecialchars($_GET['success']) . '</p>';
}
?>

<h2>Store List</h2>
<table>
    <tr>
        <th>Store ID</th>
        <th>Store Name</th>
        <th>Store Location</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($stores as $store): ?>
        <tr>
            <td><?php echo htmlspecialchars($store['store_id']); ?></td>
            <td><?php echo htmlspecialchars($store['store_name']); ?></td>
            <td><?php echo htmlspecialchars($store['store_location']); ?></td>
            <td>
                <a href="dashboard.php?page=edit_store&id=<?php echo $store['store_id']; ?>">Edit</a> |
                <a href="../includes/delete_store.inc.php?id=<?php echo $store['store_id']; ?>" onclick="return confirm('Are you sure you want to delete this store?');">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<p><a href="dashboard.php?page=create_store">Create New Store</a></p>
