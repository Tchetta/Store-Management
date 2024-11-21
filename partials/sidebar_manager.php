<div class="sidebar" id="dashboard_sidebar">
   <!--  <h3 class="dashboard_logo" id="dashboard_logo">CSMS</h3> -->
    <div class="dashboard_sidebar_user">
    <img id="camtelLogo" src="../images/camtel logo.png" alt="Camtel Logo">
    <p id="userName"><?php echo $user_name; ?></p>
    </div>
    <ul class="dashboard_menu_lists">
    
        <!-- Product Management -->
        <li class="menu-item <?php echo ($page === 'equipment_list' || $page === 'add_equipment') ? 'active' : ''; ?>">
            <a href="#" class="menu-link submenu-toggle" data-submenu="product_submenu">
                <i class="fas fa-box-open"></i>
                <span class="menuText">Product Management</span>
            </a>
            <ul id="product_submenu" class="submenu">
                <li><a href="dashboard.php?page=add_equipment" class="<?php echo ($page === 'add_equipment') ? 'active' : ''; ?>">Add Products</a></li>
                <li><a href="dashboard.php?page=equipment_list_with_search" class="<?php echo ($page === 'equipment_list') ? 'active' : ''; ?>">View Products</a></li>
                <li><a href="dashboard.php?page=remove" class="<?php echo ($page === 'remove') ? 'active' : ''; ?>">Remove</a></li>
            </ul>

        </li>
        <!-- Others -->
        <li class="menu-item <?php echo ($page === 'model_list' || $page === 'brand_list' || $page === 'category_list') ? 'active' : ''; ?>">
            <a href="#" class="menu-link submenu-toggle" data-submenu="others_submenu">
                <i class="fas fa-box-open"></i>
                <span class="menuText">Others</span>
            </a>
            <ul id="others_submenu" class="submenu">
                <li><a href="dashboard.php?page=model_list" class="<?php echo ($page === 'model_list') ? 'active' : ''; ?>">View Models</a></li>
                <li><a href="dashboard.php?page=brand_list" class="<?php echo ($page === 'brand_list') ? 'active' : ''; ?>">View Brands</a></li>
                <li><a href="dashboard.php?page=category_list" class="<?php echo ($page === 'category_list') ? 'active' : ''; ?>">View Categories</a></li>
            </ul>

        </li>
        <!-- Others -->
        <li class="menu-item <?php echo ($page === 'edit_user' || $page === 'brand_list' || $page === 'category_list') ? 'active' : ''; ?>">
            <a href="dashboard.php?page=edit_user&actor=me&id=<?=$user_id?>" class="menu-link" >
                <i class="fas fa-user"></i>
                <span class="menuText">Account settings</span>
            </a>
        </li>

        <!-- Add more menu items here for other management sections as needed -->
    </ul>
</div>
