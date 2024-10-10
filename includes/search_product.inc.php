
<?php
require_once '../includes/class_autoloader.inc.php';

    if (isset($_POST['search_term'])) {
        $searchTerm = $_POST['search_term'];
        $sortBy = $_POST['sort_by'];
        $searchCriteria = $_POST['search_criteria'];
    
        $productController = new ProductDetailsCtrl();
        $results = $productController->searchProducts($searchTerm, $sortBy, $searchCriteria);

    // Handle displaying results (this could be a separate function)
    foreach ($results as $product) {
        echo "Product Serial Number: " . $product['serial_num'] . "<br>";
        echo "Store ID: " . $product['store_id'] . "<br>";
        echo "Model ID: " . $product['model_id'] . "<br>";
        echo "State ID: " . $product['state_id'] . "<br>";
        echo "Description: " . $product['description'] . "<br>";
        echo "Specification: " . $product['specification'] . "<br>";
        echo "In Date: " . $product['indate'] . "<br>";
        echo "Out Date: " . $product['outdate'] . "<br>";
        echo "<hr>";
    }
