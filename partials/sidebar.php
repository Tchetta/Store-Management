<div class="sidebar" id="dashboard_sidebar">
    <h3 class="dashboard_logo" id="dashboard_logo">CSMS</h3>
    <div class="dashboard_sidebar_user">
        <img id="userImage" src="<?php echo $user_image; ?>" alt="User Image">
        <p id="userName"><?php echo $user_name; ?></p>
    </div>
    <ul class="dashboard_menu_lists">
        <!-- User Management -->
        <li class="menu-item <?php echo ($page === 'user_list' || $page === 'create_user') ? 'active' : ''; ?>">
            <a href="#" class="menu-link submenu-toggle" data-submenu="user_submenu">
                <i class="fas fa-users"></i>
                <span class="menuText">User Management</span>
            </a>
            <ul id="user_submenu" class="submenu">
                <li><a href="dashboard.php?page=user_list" class="<?php echo ($page === 'user_list') ? 'active' : ''; ?>">View Users</a></li>
                <li><a href="dashboard.php?page=create_user" class="<?php echo ($page === 'create_user') ? 'active' : ''; ?>">Create User</a></li>
                <li><a href="dashboard.php?page=edit_user&id=<?=$user_id?>" class="<?php echo ($page === 'edit_user') ? 'active' : ''; ?>">Account Settings</a></li>
            </ul>
        </li>

        <!-- Store Management -->
        <li class="menu-item <?php echo ($page === 'store_list' || $page === 'create_store') ? 'active' : ''; ?>">
            <a href="#" class="menu-link submenu-toggle" data-submenu="store_submenu">
                <i class="fas fa-store"></i>
                <span class="menuText">Store Management</span>
            </a>
            <ul id="store_submenu" class="submenu">
                <li><a href="dashboard.php?page=store_list" class="<?php echo ($page === 'store_list') ? 'active' : ''; ?>">View Stores</a></li>
                <li><a href="dashboard.php?page=create_store" class="<?php echo ($page === 'create_store') ? 'active' : ''; ?>">Create Store</a></li>
            </ul>
        </li>

        <!-- Product Management -->
       <!--  <?php if ($user_role === 'admin') : ?>
            <li class="menu-item <?php 
                //$substrings = ["others", "model", "category", "brand"];
                //echo (array_filter($substrings, fn($substr) => str_contains($page, $substr))) ? 'active' : ''; ?>">
                <a href="dashboard.php?page=others" class="<?php //echo ($page === 'others') ? 'active' : ''; ?>"><i class="fas fa-ellipsis-h"></i>
                Others</a>
            </li>
        <?php //elseif ($user_role === 'store manager') : ?> -->
        <li class="menu-item <?php echo ($page === 'equipment_list' || $page === 'add_equipment') ? 'active' : ''; ?>">
            <a href="#" class="menu-link submenu-toggle" data-submenu="product_submenu">
            <!-- <a href="dashboard.php?page=others" > -->
                <i class="fas fa-box-open"></i>
                <span class="menuText">Product Management</span>
            </a>
            <ul id="product_submenu" class="submenu">
                <!-- <li><a href="dashboard.php?page=add_equipment" class="<?php //echo ($page === 'add_equipment') ? 'active' : ''; ?>">Add Products</a></li> -->
                <li><a href="dashboard.php?page=equipment_list_with_search" class="<?php echo ($page === 'equipment_list') ? 'active' : ''; ?>">View Products</a></li>
                <li><a href="dashboard.php?page=others" class="<?php echo ($page === 'others') ? 'active' : ''; ?>">Others</a></li>
            </ul>
        </li>
        <?php endif; ?>

        <!-- Others -->
        <li class="menu-item <?php echo ($page === "edit_user&actor=me&id={$user_id}" ) ? 'active' : ''; ?>">
            <a href="dashboard.php?page=edit_user&actor=me&id=<?=$user_id?>" class="menu-link" >
                <i class="fas fa-user"></i>
                <span class="menuText">Account settings</span>
            </a>
        </li>

        <!-- Add more menu items here for other management sections as needed -->
    </ul>
</div>
