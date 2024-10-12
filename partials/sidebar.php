<!-- sidebar.php -->
<div class="sidebar" id="dashboard_sidebar">
    <!-- Dashboard Logo -->
    <h3 class="dashboard_logo" id="dashboard_logo">CSMS</h3>

    <!-- User profile section -->
    <div class="dashboard_sidebar_user">
        <img id="userImage" src="<?php echo $user_image; ?>" alt="User Image">
        <p id="userName"><?php echo $user_name; ?></p>
    </div>

    <!-- Menu section -->
    <ul class="dashboard_menu_lists">
        <?php
        // Ensure $pages array exists
        if (isset($pages)) {
            foreach ($pages as $key => $value): ?>
                <li class="<?php echo (isset($_GET['page']) && $_GET['page'] === $key) ? 'active' : ''; ?>">
                    <a href="dashboard.php?page=<?php echo $key; ?>">
                        <i class="fas fa-cogs"></i>
                        <span class="menuText"><?php echo $value; ?></span>
                    </a>
                </li>
            <?php endforeach;
        } else {
            echo '<li>No pages available</li>'; // Error handling if $pages isn't set
        }
        ?>
    </ul>
</div>
