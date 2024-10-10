<?php
require_once '../includes/class_autoloader.inc.php';

if (isset($_POST['submit'])) {
    $brandId = $_POST['brand_id'];
    $brandName = $_POST['brand_name'];
    $description = $_POST['description'];
    $categoryId = $_POST['category_id'];
    $quantity = $_POST['quantity'];

    // Basic validation
    if (empty($brandId) || empty($brandName) || empty($categoryId)) {
        header("Location: ../pages/dashboard.php?page=edit_brand&brand_id=$brandId&error=emptyfields");
        exit();
    }

    $brandController = new BrandCtrl();

    try {
        $brandController->updateBrand($brandId, $brandName, $description, $categoryId, $quantity);
        header("Location: ../pages/dashboard.php?page=brand_list&success=brandupdated");
    } catch (Exception $e) {
        header("Location: ../pages/dashboard.php?page=edit_brand&brand_id=$brandId&error=" . urlencode($e->getMessage()));
    }

    exit();
} else {
    header("Location: ../pages/dashboard.php?page=edit_brand&brand_id=$brandId");
    exit();
}
