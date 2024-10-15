<?php
require_once '../includes/class_autoloader.inc.php';

// Pagination variables
$limit = 5; // Number of stores to display per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Fetch total number of stores to calculate the number of pages
$storeController = new StoreCtrl();
$totalStores = count($storeController->getAllStores());
$totalPages = ceil($totalStores / $limit);

// Fetch stores for the current page
$stores = $storeController->getStoresByPage($start, $limit);

$userController = new UserCtrl();  // Assuming this class is responsible for fetching user data

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
        <th>Store Name</th>
        <th>Store Location</th>
        <th>Store Manager</th>
        <th>Actions</th>
    </tr>
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
            <td>
                <a href="dashboard.php?page=edit_store&id=<?php echo $store['store_id']; ?>">Edit</a> |
                <a href="../includes/delete_store.inc.php?id=<?php echo $store['store_id']; ?>" onclick="return confirm('Are you sure you want to delete this store?');">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<p><a href="dashboard.php?page=create_store">Create New Store</a></p>

<!-- Pagination links -->
<div>
    <?php if ($totalPages > 1): ?>
        <nav>
            <ul style="list-style: none; display: flex; gap: 10px;">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li style="display: inline;">
                        <a href="?page=<?php echo $i; ?>" style="<?php echo $i == $page ? 'font-weight:bold;' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>

<!-- Display stores in divs with manager details -->
<h2>Store Overview</h2>
<div style="display: flex; flex-wrap: wrap;">
    <?php foreach ($stores as $store): ?>
        <?php 
            // Get the store manager details again for the div section
            $managerId = $storeController->getManagerId($store['store_id']);
            $manager = $userController->getUserById($managerId);
        ?>
        <div style="border: 1px solid #ccc; padding: 10px; margin: 10px; width: 200px; text-align: center;">
            <h3><?php echo htmlspecialchars($store['store_name']); ?></h3>
            <p><?php echo htmlspecialchars($store['store_location']); ?></p>
            <p>Managed by: <?php echo htmlspecialchars($manager['first_name']); ?></p>
            <img src="../uploads/profile_pics/<?php echo htmlspecialchars($manager['image_path']); ?>" alt="Profile Picture" style="width:100px; height:100px; border-radius:50%;">
        </div>
    <?php endforeach; ?>
</div>
