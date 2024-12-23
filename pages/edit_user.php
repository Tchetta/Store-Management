
<?php
require_once '../includes/class_autoloader.inc.php';

if (isset($_GET['id'])) {
    $userController = new UserCtrl();
    
    // Fetch user by ID
    $user = $userController->getUserById($_GET['id']);
    $personal = $_GET['actor'] ?? '';

    if ($user) {
        ?>
        <div class="model_container model_mt-5">
            <h2>Edit User: <?php echo htmlspecialchars($user['user_id']); ?></h2>
            <form action="../includes/edit_user.inc.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['user_id']); ?>">

                <div  class="model_form-group">
                    <label for="first_name">First Name:</label>
                    <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
                </div>

                <div  class="model_form-group">
                    <label for="last_name">Last Name:</label>
                    <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
                </div>

                <div  class="model_form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>


                <?php if (isset($personal) && $personal == 'me') : ?>
                    <a href="dashboard.php?page=change_password&id=<?php echo htmlspecialchars($user['user_id']); ?>">Change password</a>
                <?php endif; ?>

                
                <div  class="model_form-group">
                    <label for="role">Role:</label>
                    <select id="role" name="role" required <?php
                        if($user_role == 'store manager') {
                            echo 'hidden';
                        } ?>>
                        <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                        <option value="store manager" <?php if ($user['role'] == 'store manager') echo 'selected'; ?>>Store manager</option>
                        <option value="SuperAdmin" <?php if ($user['role'] == 'SuperAdmin') echo 'selected'; ?>>SuperAdmin</option>
                    </select>
                </div>

               

               
                <button type="submit" name="submit" >Update User</button>
            </form>
            <div class="back-arrow-container">
    <a href="javascript:history.back()" class="back-arrow">
        &#8592; Back
    </a>
</div>
            <div class="link-container">
<a href="dashboard.php?page=user_list" class="link">View Users</a>
</div>
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
<script>
function togglePassword() {
    var passwordField = document.getElementById("password");
    var eyeIcon = document.getElementById("eyeIcon");
    
    if (passwordField.type === "password") {
        passwordField.type = "text";
        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash");
    } else {
        passwordField.type = "password";
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye");
    }
}
</script>
