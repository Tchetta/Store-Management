<?php
require_once '../includes/class_autoloader.inc.php';

$productController = new ProductDetailsCtrl();

// Fetch all products initially (consider not outdated)
$products = $productController->getAllProducts();

// Handle search and sorting if the form is submitted
if (isset($_POST['search_term'])) {
    $searchTerm = $_POST['search_term'];
    $sortBy = $_POST['sort_by'];
    $searchCriteria = $_POST['search_criteria']; // description or specification
    $products = $productDetailsCtrl->searchProducts($searchTerm, $sortBy, $searchCriteria);
}

// Fetch categories and states for filtering
$categoryCtrl = new ProductCategoryCtrl();
$categories = $categoryCtrl->getAllCategories();

$stateCtrl = new StateCtrl();
$states = $stateCtrl->getAllStates();

if (!is_array($products)) {
    $products = []; // Ensure $products is an array
}
?>
