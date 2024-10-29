<div class="container">
    <h2>OTHER SETTINGS</h2>

    <!-- Models Button -->
    <div class="manage-section">
        <button class="manage-btn" onclick="toggleDropdown('models')">Models</button>
        <div id="models-dropdown" class="dropdown-menu" style="display: none;">
            <a href="dashboard.php?page=create_model">Create Model</a>
            <a href="dashboard.php?page=model_list">View Models</a>
        </div>
    </div>
    <?php if ($user_role === 'admin') : ?>
    <!-- Brands Button -->
    <div class="manage-section">
        <button class="manage-btn" onclick="toggleDropdown('brands')">Brands</button>
        <div id="brands-dropdown" class="dropdown-menu" style="display: none;">
            <a href="dashboard.php?page=create_brand">Create Brand</a>
            <a href="dashboard.php?page=brand_list">View Brands</a>
        </div>
    </div>
    <?php endif; ?>
    <?php if ($user_role === 'admin') : ?>
    <!-- Categories Button -->
    <div class="manage-section">
        <button class="manage-btn" onclick="toggleDropdown('categories')">Categories</button>
        <div id="categories-dropdown" class="dropdown-menu" style="display: none;">
            <a href="dashboard.php?page=create_category">Create Category</a>
            <a href="dashboard.php?page=category_list">View Categories</a>
        </div>
    </div>
    <?php endif; ?>
    </div>
</div>

<script>
    function toggleDropdown(section) {
        const dropdownId = section + '-dropdown';
        const dropdown = document.getElementById(dropdownId);

        // Toggle the dropdown visibility
        dropdown.style.display = dropdown.style.display === 'none' || dropdown.style.display === '' ? 'block' : 'none';
    }
</script>
