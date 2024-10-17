<!-- Display users in divs (User Overview) -->
<h2>User Overview (Card View)</h2>
<?php if (empty($users)): ?>
    <p>No users found.</p>
<?php else: ?>
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
<?php endif; ?>

<!-- Pagination for User Cards -->
<div class="pagination">
    <?php if ($totalUserPages > 1): ?>
        <nav>
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

<!-- Display stores in divs with manager details -->
<h2>Store Overview</h2>
<div class="store-overview">
    <?php if (count($stores) > 0): ?>
        <?php foreach ($stores as $store): ?>
            <?php 
                // Get the store manager details again for the div section
                $managerId = $storeController->getManagerId($store['store_id']);
                $manager = $userController->getUserById($managerId);
            ?>
            <div class="store-card">
                <h3><?php echo htmlspecialchars($store['store_name']); ?></h3>
                <p><?php echo htmlspecialchars($store['store_location']); ?></p>
                <p>Managed by: <?php echo htmlspecialchars($manager['first_name']); ?></p>
                <img src="../uploads/profile_pics/<?php echo htmlspecialchars($manager['image_path']); ?>" alt="Profile Picture" class="profile-pic">
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No stores available</p>
    <?php endif; ?>
</div>