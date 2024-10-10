<?php
require_once '../includes/class_autoloader.inc.php';

if (isset($_GET['brand_id'])) {
    $brandId = $_GET['brand_id'];

    $brandController = new BrandCtrl();

    try {
        $brandController->deleteBrand($brandId);
        header("Location: ../pages/dashboard.php?page=brand_list&success=branddeleted");
    } catch (Exception $e) {
        header("Location: ../pages/dashboard.php?page=brand_list&error=" . urlencode($e->getMessage()));
    }

    exit();
} else {
    header("Location: ../pages/dashboard.php?page=brand_list");
    exit();
}
