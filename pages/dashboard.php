<?php
require_once('../includes/class_autoloader.inc.php');

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

// Check if there's a page to load
$page = isset($_GET['page']) ? $_GET['page'] : 'welcome';


$defaultProfilePic = 'https://www.w3schools.com/howto/img_avatar.png';
// Get user information from session
$user_id = $_SESSION['user_id'];
$user_name = isset($_SESSION['first_name']) && isset($_SESSION['last_name']) ? $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] : '';
$user_image = isset($_SESSION['image_path']) ? '../uploads/profile_pics/' . $_SESSION['image_path'] : $defaultProfilePic;

$modelController = new ModelCtrl();
$models = $modelController->getAllModels();

foreach ($models as $model) {
    $modelId = $model['model_id'];
    $modelController->updateModelQuantity($modelId);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/store_management.css"> <!-- Link to the CSS file -->
    <link rel="stylesheet" href="../css/dashboard.css"> <!-- Use your provided styles -->
    <link rel="stylesheet" href="../css/display_items.css"> <!-- Use your provided styles -->
    <link rel="stylesheet" href="../model.css"> <!-- Use your provided styles -->
    <!--  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"> -->
    <link rel="stylesheet" href="../css/user_management.css"> <!-- Link to user_management.css -->
    <link rel="stylesheet" href="../css/product_management.css"> <!-- Updated CSS file link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome -->
</head>
<body>
    <div id="dashboardMainContainer">
        <?php include('../partials/sidebar.php'); ?> <!-- Include sidebar -->
        
        <div class="dashboard_content_container" id="dashboard_content_container">
            <?php include('../partials/topnav.php'); ?> <!-- Include top navigation -->
            
            <div class="dashboard_content">
                <div class="dashboard_content_main">
                    <?php
                        // Load the content of the selected page
                        $pageFile = $page . '.php';
                        if (file_exists($pageFile)) {
                            include($pageFile);
                        } else {
                            include('equipment_list.php');
                                  
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../js/script.js"></script> <!-- Include your JS file -->
</body>
</html>
