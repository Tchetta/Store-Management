
<?php
require_once '../includes/class_autoloader.inc.php';

if (isset($_GET['id'])) {
    $userController = new UserCtrl();
    
    // Fetch user by ID
    $user = $userController->getUserById($_GET['id']);

    if ($user) {
        ?>
        <div class="edit-user-container">
            <h2>Edit User: <?php echo htmlspecialchars($user['user_id']); ?></h2>
            <form action="../includes/edit_user.inc.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['user_id']); ?>">

                <div class="form-group">
                    <label for="first_name">First Name:</label>
                    <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="last_name">Last Name:</label>
                    <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="role">Role:</label>
                    <select id="role" name="role" required>
                        <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                        <option value="store manager" <?php if ($user['role'] == 'store manager') echo 'selected'; ?>>Store manager</option>
                        <option value="SuperAdmin" <?php if ($user['role'] == 'SuperAdmin') echo 'selected'; ?>>SuperAdmin</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="profile_pic">Profile Picture:</label>
                    <input type="file" id="profile_pic" name="profile_pic" accept="image/*">
                </div>

                <div class="form-group">
                    <p>Current Profile Picture:</p>
                    <img src="../uploads/profile_pics/<?php echo htmlspecialchars($user['image_path']); ?>" alt="Profile Picture" class="current-profile-pic">
                </div>

                <button type="submit" name="submit" class="btn">Update User</button>
            </form>
        </div>
        <?php
    } else {
        echo '<p>User not found.</p>';
        header("Location: dashboard.php?user_list");
    }
} else {
    echo '<p>Invalid user ID.</p>';
}
?>
