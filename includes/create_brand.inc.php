<?php
require_once '../includes/class_autoloader.inc.php';

if (isset($_POST['submit'])) {
    $brandName = $_POST['brand_name'];
    $description = $_POST['description'];

    // Debug: Check if the category ID is passed correctly
    if (empty($brandName)) {
        echo "Error: Brand name";
        exit();
    }

    echo "Brand Name: " . $brandName . "<br>";
    echo "Description: " . $description . "<br>";


    $brandController = new BrandCtrl();

    try {
        // Insert the brand with valid data
        $brandController->createBrand($brandName, $description);

        header("Location: ../pages/dashboard.php?page=brand_list&success=brandcreated");
    } catch (Exception $e) {
        header("Location: ../pages/dashboard.php?page=create_brand&error=" . urlencode($e->getMessage())); 
    } 

    exit();
} else {
    header("Location: ../pages/dashboard.php?page=create_brand");
    exit();
}
