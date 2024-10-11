<?php
require_once '../includes/class_autoloader.inc.php';

if (isset($_POST['submit'])) {
    $brandName = $_POST['brand_name'];
    $description = $_POST['description'];
    $categoryId = (int)$_POST['category_id'];

    // Debug: Check if the category ID is passed correctly
    if (empty($brandName) || empty($categoryId)) {
        echo "Error: Brand name or category is empty";
        exit();
    }

     // Ensure the category ID is valid before proceeding
    $categoryController = new ProductCategoryCtrl();
    $category = $categoryController->getCategoryById($categoryId);

    if (!$category) {
        // If category doesn't exist, return an error
        header("Location: ../pages/dashboard.php?page=create_brand&error=invalidcategory");
        exit();
    } 

    echo "Brand Name: " . $brandName . "<br>";
    echo "Category ID: " . $categoryId . "<br>";
    echo "Description: " . $description . "<br>";


    $brandController = new BrandCtrl();

    try {
        // Insert the brand with valid data
        $brandController->createBrand($brandName, $categoryId, $description);

        header("Location: ../pages/dashboard.php?page=brand_list&success=brandcreated");
    } catch (Exception $e) {
        header("Location: ../pages/dashboard.php?page=create_brand&error=" . urlencode($e->getMessage())); 
    } 

    exit();
} else {
    header("Location: ../pages/dashboard.php?page=create_brand");
    exit();
}
