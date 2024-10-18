<?php
require_once '../includes/class_autoloader.inc.php';

if (isset($_POST['submit'])) {
    $brandId = $_POST['brand_id'];
    $brandName = $_POST['brand_name'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];

    // Basic validation
    if (empty($brandId) || empty($brandName)) {
        header("Location: ../pages/dashboard.php?page=edit_brand&brand_id=$brandId&error=emptyfields");
        exit();
    }

    $brandController = new BrandCtrl();

    try {
        $brandController->setBrandName($brandId, $brandName);
        $brandController->setBrandDescription($brandId, $description);
        $brandController->setBrandQuantity($brandId, $quantity);

        header("Location: ../pages/dashboard.php?page=brand_list&success=brandupdated");
    } catch (Exception $e) {
        header("Location: ../pages/dashboard.php?page=edit_brand&brand_id=$brandId&error=" . urlencode($e->getMessage()));
    }

    exit();
} else {
    header("Location: ../pages/dashboard.php?page=edit_brand&brand_id=$brandId");
    exit();
}
