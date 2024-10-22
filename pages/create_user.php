

<div class="model_container">
    <h2>Create New User</h2>

    <form action="../includes/create_user.inc.php" method="POST" enctype="multipart/form-data">
        <div class="model_form-group">
            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" required>
        </div>

        <div class="model_form-group">
            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" required>
        </div>

        <div class="model_form-group">
            <label for="username">Username (User ID):</label>
            <input type="text" id="username" name="username" required>
        </div>

        <div class="model_form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="model_form-group">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="model_form-group">
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>

        <div class="form-field">
            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="admin">Admin</option>
                <option value="superadmin">SuperAdmin</option>
                <option value="storemanager">StoreManager</option>
            </select>
        </div>

        <div class="form-field">
            <label for="profile_pic">Profile Picture:</label>
            <input type="file" id="profile_pic" name="profile_pic" accept="image/*">
        </div>

        <button type="submit" name="submit">Create User</button>
    </form>
    <div class="back-arrow-container">
    <a href="javascript:history.back()" class="back-arrow">
        &#8592; Back
    </a>
    </div>
    <div class="link-container">
    <a href="dashboard.php?page=user_list" class="link">View All users</a>
</div>
</div>


   
