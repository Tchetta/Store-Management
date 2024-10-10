<div class="sidebar" id="dashboard_sidebar">
    <!-- Dashboard Logo -->
    <h3 class="dashboard_logo" id="dashboard_logo">CSMS</h3> <!-- Added CSMS logo -->

    <!-- User profile section -->
    <div class="dashboard_sidebar_user">
        <img id="userImage" src="<?php echo $user_image; ?>" alt="User Image">
        <p id="userName"><?php echo $user_name; ?></p>
    </div>

    <!-- Menu section -->
    <ul class="dashboard_menu_lists">
        <?php foreach ($pages as $key => $value): ?>
            <li>
                <a href="dashboard.php?page=<?php echo $key; ?>">
                    <i class="fas fa-cogs"></i> <!-- Replace with appropriate Font Awesome icons -->
                    <span class="menuText"><?php echo $value; ?></span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
