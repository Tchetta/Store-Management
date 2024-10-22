   
    <div class="model_container model_mt-5">
        <h2 class="model_mb-4">Create New Brand</h2>
<form action="../includes/create_brand.inc.php" method="POST">
<div class="model_form-group">
<label for="brand_name">Brand Name:</label>
    <input type="text" name="brand_name" required><br>
</div>
<div class="model_form-group">
    <label for="description">Description:</label>
    <textarea name="description"></textarea><br>
</div>

    <button type="submit" name="submit">Create Brand</button>
</form>
<div class="back-arrow-container">
    <a href="javascript:history.back()" class="back-arrow">
        &#8592; Back
    </a>
</div>
<!-- Links to other operations -->


<div class="link-container">
    <a href="dashboard.php?page=brand_list" class="link">View All Brands</a>
</div>
    </div>