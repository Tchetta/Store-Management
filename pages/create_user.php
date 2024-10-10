<h2>Create New User</h2>

<form action="../includes/create_user.inc.php" method="POST" enctype="multipart/form-data">
    <label for="firstname">First Name:</label><br>
    <input type="text" id="firstname" name="firstname" required><br>

    <label for="lastname">Last Name:</label><br>
    <input type="text" id="lastname" name="lastname" required><br>

    <label for="username">Username (User ID):</label><br>
    <input type="text" id="username" name="username" required><br>

    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br>

    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" required><br>

    <label for="confirm_password">Confirm Password:</label><br>
    <input type="password" id="confirm_password" name="confirm_password" required><br>

    <label for="role">Role:</label><br>
    <select id="role" name="role" required>
        <option value="admin">Admin</option>
        <option value="user">User</option>
    </select><br>

    <label for="profile_pic">Profile Picture:</label><br>
    <input type="file" id="profile_pic" name="profile_pic" accept="image/*"><br><br>

    <button type="submit" name="submit">Create User</button>
</form>

<p><a href="dashboard.php?page=user_list">View Users</a></p>