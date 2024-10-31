<?php
require_once '../includes/class_autoloader.inc.php';

if (isset($_POST['submit'])) {
    $storeId = $_POST['store_id'];
    $storeName = $_POST['store_name'];
    $storeLocation = $_POST['store_location'];
    $manager_id = $_POST['manager_id'] ?? '';

    // Basic validation
    if (empty($storeId)) {
        header("Location: ../pages/dashboard.php?page=edit_store&id=$storeId&error=empty+fields");
        exit();
    }

    $storeController = new StoreCtrl();

    $data = [
        'store_name' => $storeName,
        'store_location' => $storeLocation,
        'manager_id' => $manager_id
    ];

    try {
        $storeController->updateStore($storeId, $data);
        header("Location: ../pages/dashboard.php?page=store_list&success=store+updated");
    } catch (Exception $e) {
        header("Location: ../pages/dashboard.php?page=edit_store&id=$storeId&error=" . urlencode($e->getMessage()));
    }

    exit();
} else {
    header("Location: ../pages/dashboard.php?page=edit_store&id=$storeId");
    exit();
}
