<?php
require_once '../includes/class_autoloader.inc.php';

if (isset($_GET['id'])) {
    $storeId = $_GET['id'];

    $storeController = new StoreCtrl();

    try {
        $storeController->deleteStore($storeId);
        header("Location: ../pages/dashboard.php?page=store_list&success=storedeleted");
    } catch (Exception $e) {
        header("Location: ../pages/dashboard.php?page=store_list&error=" . urlencode($e->getMessage()));
    }

    exit();
} else {
    header("Location: ../pages/dashboard.php?page=store_list");
    exit();
}
