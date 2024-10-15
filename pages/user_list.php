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
    <style>
        .user-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-around;
        }

        .user-card {
            width: 200px;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }

        .user-card img {
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .user-card h3 {
            margin: 10px 0;
        }

        .user-card p {
            margin: 5px 0;
            color: #555;
        }

        .user-card a {
            display: block;
            margin: 10px 0;
            text-decoration: none;
            color: #007bff;
        }

        .user-card a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<!-- User Table -->
<h2>User List (Table View)</h2>
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
                <a href="dashboard.php?page=edit_user&id=<?php echo htmlspecialchars($user['user_id']); ?>">Edit</a> |
                <a href="../includes/delete_user.inc.php?id=<?php echo htmlspecialchars($user['user_id']); ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<!-- Pagination for User Table -->
<div>
    <?php if ($totalUserPages > 1): ?>
        <nav>
            <ul style="list-style: none; display: flex; gap: 10px;">
                <?php for ($i = 1; $i <= $totalUserPages; $i++): ?>
                    <li style="display: inline;">
                        <a href="?user_page=<?php echo $i; ?>" style="<?php echo $i == $userPage ? 'font-weight:bold;' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>

<!-- Display users in divs (User Overview) -->
<h2>User Overview (Card View)</h2>
<div class="user-container">
    <?php foreach ($users as $user): ?>
        <?php 
            // Default profile picture if user has no profile picture
            $profilePic = !empty($user['image_path']) ? '../uploads/profile_pics/' . $user['image_path'] : $defaultProfilePic;
        ?>
        <div class="user-card">
            <img src="<?php echo htmlspecialchars($profilePic); ?>" alt="Profile Picture" width="100" height="100">
            <h3><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h3>
            <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
            <p>Role: <?php echo htmlspecialchars($user['role']); ?></p>
            <a href="dashboard.php?page=edit_user&id=<?php echo htmlspecialchars($user['user_id']); ?>">Edit</a>
            <a href="../includes/delete_user.inc.php?id=<?php echo htmlspecialchars($user['user_id']); ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
        </div>
    <?php endforeach; ?>
</div>

<!-- Pagination for User Cards (if needed) -->
<div>
    <?php if ($totalUserPages > 1): ?>
        <nav>
            <ul style="list-style: none; display: flex; gap: 10px;">
                <?php for ($i = 1; $i <= $totalUserPages; $i++): ?>
                    <li style="display: inline;">
                        <a href="?user_page=<?php echo $i; ?>" style="<?php echo $i == $userPage ? 'font-weight:bold;' : ''; ?>">
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
