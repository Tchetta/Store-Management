
<div class="others-section">
    <h2>Others</h2>
    <div class="others-dropdown-nav">
        <button class="others-dropdown-toggle">Manage</button>
        <div class="others-dropdown-menu">
            <button onclick="showSection('models')">Models</button>
            <button onclick="showSection('brands')">Brands</button>
            <button onclick="showSection('categories')">Categories</button>
        </div>
    </div>

    <div id="models" class="others-content-section" style="display:none;">
        <h3>Manage Models</h3>
        <ul>
            <li><a href="dashboard.php?page=create_model">Create Model</a></li>
            <li><a href="dashboard.php?page=model_list">View Models</a></li>
        </ul>
    </div>

    <div id="brands" class="others-content-section" style="display:none;">
        <h3>Manage Brands</h3>
        <ul>
            <li><a href="dashboard.php?page=create_brand">Create Brand</a></li>
            <li><a href="dashboard.php?page=brand_list">View Brands</a></li>
        </ul>
    </div>

    <div id="categories" class="others-content-sectionion" style="display:none;">
        <h3>Manage Categories</h3>
        <ul>
            <li><a href="dashboard.php?page=create_category">Create Product Category</a></li>
            <li><a href="dashboard.php?page=category_list">View Categories</a></li>
        </ul>
    </div>
</div>

<script>
    function showSection(section) {
        const sections = ['models', 'brands', 'categories'];
        sections.forEach((sec) => {
            document.getElementById(sec).style.display = sec === section ? 'block' : 'none';
        });
    }
</script>
