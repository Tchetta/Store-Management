<?php
require_once('../includes/class_autoloader.inc.php');

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

// Check if there's a page to load
$page = isset($_GET['page']) ? $_GET['page'] : 'welcome';

// Define the available sections for management
$pages = [
    'user_list' => 'User Management',
    'store_list' => 'Store Management',
    'category_list' => 'Product Category Management',
    'model_list' => 'Model Management',
    'brand_list' => 'Brand Management',
    'product_list' => 'Equipment State Management',
    'model_port_types_list' => 'Port Type Management',
    'state_list' => 'State Management',
    'product_list' => 'Equipment Management',
];
$defaultProfilePic = 'https://www.w3schools.com/howto/img_avatar.png';
            $profilePic = !empty($user['image_path']) ? '../uploads/profile_pics/' . $user['image_path'] : $defaultProfilePic;
// Get user information from session
$user_id = $_SESSION['user_id'];
$user_name = (isset($_SESSION['first_name']) && isset($_SESSION['last_name'])) ? isset($_SESSION['first_name']) . ' ' . $_SESSION['last_name'] : ''; // Assuming first and last names are stored in the session
$user_image = isset($_SESSION['image_path']) ? $_SESSION['image_path'] : $defaultProfilePic; // Default profile image if none set
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css"> <!-- Add your stylesheet -->
</head>
<body>
    <header>
        <h1>Welcome to the Dashboard</h1>
        <div class="user-info">
            <img src="<?php echo $user_image; ?>" alt="Profile Picture" class="profile-pic">
            <span class="user-name"><?php echo htmlspecialchars($user_name); ?></span>
        </div>
        <a href="../includes/logout.inc.php" class="logout-button">Logout</a>
    </header>

    <div class="dashboard-container">
        <aside>
            <ul>
                <?php foreach ($pages as $key => $value): ?>
                    <li><a href="dashboard.php?page=<?php echo $key; ?>"><?php echo $value; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </aside>

        <section class="content">
            <?php
                // Load the content of the selected page
                $pageFile = $page . '.php';
                if (file_exists($pageFile)) {
                    include($pageFile);
                } else {
                    echo "<p>Welcome to the dashboard. Please select a management section.</p>";
                }
            ?>
        </section>
    </div>
</body>
</html>
