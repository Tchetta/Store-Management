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
        <!-- User Management -->
        <li class="menu-item <?php echo ($page === 'user_list' || $page === 'create_user') ? 'active' : ''; ?>">
            <a href="#" class="menu-link">
                <i class="fas fa-users"></i>
                <span class="menuText">User Management</span>
            </a>
            <ul class="submenu">
                <li><a href="dashboard.php?page=user_list" class="<?php echo ($page === 'user_list') ? 'active' : ''; ?>">View Users</a></li>
                <li><a href="dashboard.php?page=create_user" class="<?php echo ($page === 'create_user') ? 'active' : ''; ?>">Create User</a></li>
            </ul>
        </li>

        <!-- Store Management -->
        <li class="menu-item <?php echo ($page === 'store_list' || $page === 'create_store') ? 'active' : ''; ?>">
            <a href="#" class="menu-link">
                <i class="fas fa-store"></i>
                <span class="menuText">Store Management</span>
            </a>
            <ul class="submenu">
                <li><a href="dashboard.php?page=store_list" class="<?php echo ($page === 'store_list') ? 'active' : ''; ?>">View Stores</a></li>
                <li><a href="dashboard.php?page=create_store" class="<?php echo ($page === 'create_store') ? 'active' : ''; ?>">Create Store</a></li>
            </ul>
        </li>

        <!-- Store Management -->
        <li class="menu-item <?php echo ($page === 'product_list' || $page === 'model_list' || $page === 'brand_list' || $page === 'category_list' || $page === 'create_list' || $page === 'create_brand' || $page === 'create_category') ? 'active' : ''; ?>">
            <a href="#" class="menu-link">
                <i class="fas fa-box-open"></i>
                <span class="menuText">Product Management</span>
            </a>
            <ul class="submenu">
                <li><a href="dashboard.php?page=add_product" class="<?php echo ($page === 'add_product') ? 'active' : ''; ?>">Add Products</a></li>
                <li><a href="dashboard.php?page=product_list" class="<?php echo ($page === 'product_list') ? 'active' : ''; ?>">View Products</a></li>
                <li><a href="dashboard.php?page=create_model" class="<?php echo ($page === 'create_model') ? 'active' : ''; ?>">Create Model</a></li>
                <li><a href="dashboard.php?page=model_list" class="<?php echo ($page === 'model_list') ? 'active' : ''; ?>">View Models</a></li>
                <li><a href="dashboard.php?page=create_brand" class="<?php echo ($page === 'create_brand') ? 'active' : ''; ?>">Create Brand</a></li>
                <li><a href="dashboard.php?page=brand_list" class="<?php echo ($page === 'brand_list') ? 'active' : ''; ?>">View brands</a></li>
                <li><a href="dashboard.php?page=create_category" class="<?php echo ($page === 'create_category') ? 'active' : ''; ?>">Create Product Category</a></li>
                <li><a href="dashboard.php?page=category_list" class="<?php echo ($page === 'category_list') ? 'active' : ''; ?>">View Categories</a></li>
            </ul>
        </li>

        <!-- Add more menu items here for other management sections as needed -->
    </ul>
</div>
