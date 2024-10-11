<?php
require_once '../includes/class_autoloader.inc.php';

// Initialize the user controller
$userController = new UserCtrl();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>view users</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../css/user_management.css"> <!-- Link to user_management.css -->
</head>
<body>

<?php
try {
    // Fetch all users
    $users = $userController->getAllUsers();

    // Check if there are users to display
    if (count($users) > 0) {
        echo '<h2>User List</h2>';
        echo '<table>';
        echo '<tr>
                <th>Profile Picture</th>
                <th>User ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
              </tr>';

        // Loop through users and display their details
        foreach ($users as $user) {
            // Default profile picture (online image) if user has no profile picture
            $defaultProfilePic = 'https://www.w3schools.com/howto/img_avatar.png';
            $profilePic = !empty($user['image_path']) ? '../uploads/profile_pics/' . $user['image_path'] : $defaultProfilePic;

            echo '<tr>
                    <td><img src="' . $profilePic . '" alt="Profile Picture" width="50" height="50"></td>
                    <td>' . htmlspecialchars($user['user_id']) . '</td>
                    <td>' . htmlspecialchars($user['first_name']) . '</td>
                    <td>' . htmlspecialchars($user['last_name']) . '</td>
                    <td>' . htmlspecialchars($user['email']) . '</td>
                    <td>' . htmlspecialchars($user['role']) . '</td>
                    <td>
                        <a href="dashboard.php?page=edit_user&id=' . $user['user_id'] . '">Edit</a> |
                        <a href="../includes/delete_user.inc.php?id=' . $user['user_id'] . '">Delete</a>
                    </td>
                  </tr>';
        }
        echo '</table>';

        echo '<p><a href="dashboard.php?page=create_user">Create New User</a></p>';
    } else {
        echo '<p>No users found.</p>';
    }
} catch (Exception $e) {
    echo '<p>Error fetching users: ' . $e->getMessage() . '</p>';
}
?>

</body>
</html>
