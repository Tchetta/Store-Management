<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New User</title>

    <!-- Link to the external CSS file -->
    <link rel="stylesheet" href="../css/user_management.css">
</head>
<body>

<div class="form-container">
    <h2>Create New User</h2>

    <form action="../includes/create_user.inc.php" method="POST" enctype="multipart/form-data">
        <div class="form-field">
            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" required>
        </div>

        <div class="form-field">
            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" required>
        </div>

        <div class="form-field">
            <label for="username">Username (User ID):</label>
            <input type="text" id="username" name="username" required>
        </div>

        <div class="form-field">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-field">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-field">
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

    <p><a href="dashboard.php?page=user_list">View Users</a></p>
</div>
