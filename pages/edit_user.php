<?php
require_once '../includes/class_autoloader.inc.php';

if (isset($_GET['id'])) {
    $userController = new UserCtrl();
    
    // Fetch user by ID
    $user = $userController->getUserById($_GET['id']);

    if ($user) {
        ?>
        <h2>Edit User: <?php echo htmlspecialchars($user['user_id']); ?></h2>
        <form action="../includes/edit_user.inc.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['user_id']); ?>">

            <label for="first_name">First Name:</label><br>
            <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required><br>

            <label for="last_name">Last Name:</label><br>
            <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required><br>

            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br>

            <label for="role">Role:</label><br>
            <select id="role" name="role" required>
                <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                <option value="user" <?php if ($user['role'] == 'user') echo 'selected'; ?>>User</option>
            </select><br>

            <label for="profile_pic">Profile Picture:</label><br>
            <input type="file" id="profile_pic" name="profile_pic" accept="image/*"><br><br>
            <p>Current Profile Picture:</p>
            <img src="../uploads/profile_pics/<?php echo htmlspecialchars($user['image_path']); ?>" alt="Profile Picture" width="50" height="50"><br><br>

            <button type="submit" name="submit">Update User</button>
        </form>
        <?php
    } else {
        echo '<p>User not found.</p>';
        header("Location: dashboard.php?user_list");

    }
} else {
    echo '<p>Invalid user ID.</p>';
}
?>
