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
            foreach ($pages as $key => $value):
                // Check if it's "User Management" to create the main menu with submenus
                if ($value === 'User Management'): ?>
                    <li class="menu-item">
                        <a href="javascript:void(0)" class="menu-toggle" onclick="toggleSubMenu('userManagementSubMenu')">
                            <i class="fas fa-users"></i>
                            <span class="menuText">User Management</span>
                        </a>
                        <ul id="userManagementSubMenu" class="submenu" style="display: none;">
                            <li class="<?php echo (isset($_GET['page']) && $_GET['page'] === 'user_list') ? 'active' : ''; ?>">
                                <a href="dashboard.php?page=user_list">View Users</a>
                            </li>
                            <li class="<?php echo (isset($_GET['page']) && $_GET['page'] === 'create_user') ? 'active' : ''; ?>">
                                <a href="dashboard.php?page=create_user">Create Users</a>
                            </li>
                        </ul>
                    </li>
                <?php
                // Render other pages normally
                else: ?>
                    <li class="<?php echo (isset($_GET['page']) && $_GET['page'] === $key) ? 'active' : ''; ?>">
                        <a href="dashboard.php?page=<?php echo $key; ?>">
                            <i class="fas fa-cogs"></i>
                            <span class="menuText"><?php echo $value; ?></span>
                        </a>
                    </li>
                <?php
                endif;
            endforeach;
        } else {
            echo '<li>No pages available</li>'; // Error handling if $pages isn't set
        }
        ?>
    </ul>
</div>
