<?php
require_once '../includes/class_autoloader.inc.php';

// Pagination variables for users
$userLimit = 5; // Number of users to display per page
$userPage = isset($_GET['user_page']) && is_numeric($_GET['user_page']) ? (int)$_GET['user_page'] : 1;
$userStart = ($userPage - 1) * $userLimit;

// Initialize the UserCtrl and StoreCtrl classes
$userController = new UserCtrl();
$storeController = new StoreCtrl();

// Fetch total number of users to calculate the number of pages
$totalUsers = count($userController->getAllUsers());
$totalUserPages = ceil($totalUsers / $userLimit);

// Fetch users for the current page
$users = $userController->getUsersByPage($userStart, $userLimit);

// Fetch total number of stores for the store section (if needed)
$totalStores = count($storeController->getAllStores());
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/user_management.css"> <!-- Link to user_management.css -->
</head>
<body>

<!-- User Table -->
<h2>User List (Table View)</h2>
<?php if (empty($users)): ?>
    <p>No users found.</p>
<?php else: ?>
<table>
    <tr>
        <th>Profile Picture</th>
        <th>User ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($users as $user): ?>
        <?php 
            // Default profile picture if user has no profile picture
            $defaultProfilePic = 'https://www.w3schools.com/howto/img_avatar.png';
            $profilePic = !empty($user['image_path']) ? '../uploads/profile_pics/' . $user['image_path'] : $defaultProfilePic;
        ?>
        <tr>
            <td><img src="<?php echo htmlspecialchars($profilePic); ?>" alt="Profile Picture" width="50" height="50"></td>
            <td><?php echo htmlspecialchars($user['user_id']); ?></td>
            <td><?php echo htmlspecialchars($user['first_name']); ?></td>
            <td><?php echo htmlspecialchars($user['last_name']); ?></td>
            <td><?php echo htmlspecialchars($user['email']); ?></td>
            <td><?php echo htmlspecialchars($user['role']); ?></td>
            <td>
                <a href="dashboard.php?page=edit_user&id=<?php echo htmlspecialchars($user['user_id']); ?>" class="edit-action">Edit</a> |
                <a href="../includes/delete_user.inc.php?id=<?php echo htmlspecialchars($user['user_id']); ?>" class="delete-action" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php endif; ?>

<!-- Pagination for User Table -->
<div class="pagination-container">
    <?php if ($totalUserPages > 1): ?>
        <nav class="pagination">
            <ul>
                <?php for ($i = 1; $i <= $totalUserPages; $i++): ?>
                    <li>
                        <a href="?user_page=<?php echo $i; ?>" class="<?php echo $i == $userPage ? 'active' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>



</body>
</html>
