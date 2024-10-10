<?php
require_once '../includes/class_autoloader.inc.php';

if (isset($_POST['submit'])) {
    $brandName = $_POST['brand_name'];
    $description = $_POST['description'];
    $categoryId = $_POST['category_id'];
    

    // Basic validation
    if (empty($brandName) || empty($categoryId)) {
        header("Location: ../pages/dashboard.php?page=create_brand&error=emptyfields");
        exit();
    }

    $brandController = new BrandCtrl();

    try {
        $brandController->createBrand($brandName, $categoryId, $description, );
        header("Location: ../pages/dashboard.php?page=brand_list&success=brandcreated");
    } catch (Exception $e) {
        header("Location: ../pages/dashboard.php?page=create_brand&error=" . urlencode($e->getMessage()));
    }

    exit();
} else {
    header("Location: ../pages/dashboard.php?page=create_brand");
    exit();
}
