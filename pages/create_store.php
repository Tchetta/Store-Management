
    <div class="create-store-container">
        <?php
        require_once '../includes/class_autoloader.inc.php';

        // Display any error or success messages from the URL
        if (isset($_GET['error'])) {
            echo '<p class="error-message">Error: ' . htmlspecialchars($_GET['error']) . '</p>';
        } elseif (isset($_GET['success'])) {
            echo '<p class="success-message">Store created successfully!</p>';
        }
        ?>

        <h2>Create Store</h2>
        <form action="../includes/create_store.inc.php" method="POST" class="create-store-form">
            <label for="store_id">Store ID:</label>
            <input type="text" name="store_id" id="store_id" required>

            <label for="store_name">Store Name:</label>
            <input type="text" name="store_name" id="store_name" required>

            <label for="store_location">Store Location:</label>
            <input type="text" name="store_location" id="store_location">

            <label for="manager_id">Store Manager (optional):</label>
            <input type="text" name="manager_id" id="manager_id" placeholder="Enter Manager ID">

            <button type="submit" name="submit">Create Store</button>
        </form>

       <!-- Bottom right aligned link -->
    <div class="bottom-right-link">
        <p><a href="dashboard.php?page=store_list" class="view-stores-link">View Stores</a></p>
    </div>
    </div>

