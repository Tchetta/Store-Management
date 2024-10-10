<?php
require_once '../includes/class_autoloader.inc.php';

if (isset($_POST['submit'])) {
    $storeId = $_POST['store_id'];
    $storeName = $_POST['store_name'];
    $storeLocation = $_POST['store_location'];

    // Basic validation
    if (empty($storeId) || empty($storeName)) {
        header("Location: ../pages/dashboard.php?page=create_store&error=emptyfields");
        exit();
    }

    $storeController = new StoreCtrl();

    try {
        $storeController->createStore($storeId, $storeName, $storeLocation);
        header("Location: ../pages/dashboard.php?page=store_list&success=storecreated");
    } catch (Exception $e) {
        header("Location: ../pages/dashboard.php?page=create_store&error=" . urlencode($e->getMessage()));
    }

    exit();
} else {
    header("Location: ../pages/dashboard.php?page=create_store");
    exit();
}
