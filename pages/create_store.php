<?php
require_once '../includes/class_autoloader.inc.php';

// Display any error or success messages from the URL
if (isset($_GET['error'])) {
    echo '<p style="color:red;">Error: ' . htmlspecialchars($_GET['error']) . '</p>';
} elseif (isset($_GET['success'])) {
    echo '<p style="color:green;">Store created successfully!</p>';
}
?>

<h2>Create Store</h2>
<form action="../includes/create_store.inc.php" method="POST">
    <label for="store_id">Store ID:</label>
    <input type="text" name="store_id" id="store_id" required><br>

    <label for="store_name">Store Name:</label>
    <input type="text" name="store_name" id="store_name" required><br>

    <label for="store_location">Store Location:</label>
    <input type="text" name="store_location" id="store_location"><br>

    <button type="submit" name="submit">Create Store</button>
</form>

<p><a href="dashboard.php?page=store_list">View Stores</a></p>
