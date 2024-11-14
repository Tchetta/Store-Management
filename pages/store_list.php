
<?php
require_once '../includes/class_autoloader.inc.php';

// Pagination variables
$limit = 5; // Number of stores to display per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

$storeController = new StoreCtrl();

// Fetch total number of stores to calculate the number of pages
$totalStores = count($storeController->getAllStores());
$totalPages = ceil($totalStores / $limit);

// Fetch stores for the current page
$stores = $storeController->getStoresByPage($start, $limit);

// Check if $stores is an array and not null
if (!$stores || !is_array($stores)) {
    $stores = []; // Ensure $stores is an empty array if no stores are found
}

$userController = new UserCtrl();  // Assuming this class is responsible for fetching user data

// Handle errors or success messages
if (isset($_GET['error'])) {
    echo '<p class="error-message">Error: ' . htmlspecialchars($_GET['error']) . '</p>';
} elseif (isset($_GET['success'])) {
    echo '<p class="success-message">' . htmlspecialchars($_GET['success']) . '</p>';
}
?>
<!--  <div class="view-store-container"> -->
    <div class="create_container">
    <a href="dashboard.php?page=create_store" class="create-link">Create Store</a>
</div>
<h2>Store List</h2>
<table>
    <thead>
        <tr>
            <th>Store Name</th>
            <th>Store Location</th>
            <th>Store Manager</th>
            <?php if($user_role === 'admin') :?>
        <th>Actions</th>
        <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php if (count($stores) > 0): ?>
            <?php foreach ($stores as $store): ?>
                <?php 
                    // Get the store manager details
                    $managerId = $storeController->getManagerId($store['store_id']);
                    $manager = $userController->getUserById($managerId);
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($store['store_name']); ?></td>
                    <td><?php echo htmlspecialchars($store['store_location']); ?></td>
                    <td>
                        <?php echo htmlspecialchars($manager['first_name']); ?>
                        <?php echo htmlspecialchars($manager['last_name']); ?>
                    </td>
                    <?php if($user_role === 'admin') :?>
                    <td>
                        <a class="action-link" href="dashboard.php?page=edit_store&id=<?php echo $store['store_id']; ?>">Edit</a> |
                        <a class="action-link delete" href="../includes/delete_store.inc.php?id=<?php echo $store['store_id']; ?>" onclick="return confirm('Are you sure you want to delete this store?');">Delete</a> |
                        <a class="action-link More" href="dashboard.php?page=equipment_list_with_search&query=<?php echo $store['store_id']; ?>">More...</a>
                    </td>
        <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">No stores available</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- Pagination links -->
<div class="pagination-container">
    <?php if (isset($totalPages) && $totalPages > 1): ?>
        <nav class="pagination">
            <ul>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li>
                        <a href="?page=<?php echo $i; ?>" class="<?php echo $i == $page ? 'active' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>

<!-- <p><a class="create-store-link" href="dashboard.php?page=create_store">Create New Store</a></p> -->


