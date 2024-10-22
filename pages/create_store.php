
    
        <?php
        require_once '../includes/class_autoloader.inc.php';

        // Display any error or success messages from the URL
        if (isset($_GET['error'])) {
            echo '<p class="error-message">Error: ' . htmlspecialchars($_GET['error']) . '</p>';
        } elseif (isset($_GET['success'])) {
            echo '<p class="success-message">Store created successfully!</p>';
        }
        ?>
 <div class="model_container model_mt-5">
        <h2  class="model_mb-4">Create Store</h2>
        <form action="../includes/create_store.inc.php" method="POST" >
        <div class="model_form-group">
            <label for="store_id">Store ID:</label>
            <input type="text" name="store_id" id="store_id" required>
        </div>
        <div class="model_form-group">
            <label for="store_name">Store Name:</label>
            <input type="text" name="store_name" id="store_name" required>
        </div>
        <div class="model_form-group">
            <label for="store_location">Store Location:</label>
            <input type="text" name="store_location" id="store_location">
        </div>
        <div class="model_form-group">
            <label for="manager_id">Store Manager (optional):</label>
            <input type="text" name="manager_id" id="manager_id" placeholder="Enter Manager ID">
        </div>
            <button type="submit" name="submit">Create Store</button>
        </form>

        <div class="back-arrow-container">
    <a href="javascript:history.back()" class="back-arrow">
        &#8592; Back
    </a>
</div>
<div class="link-container">
    <a href="dashboard.php?page=store_list" class="link">View All Stores</a>
</div>
    </div>

