<?php
require_once 'class_autoloader.inc.php';

if (isset($_POST['submit'])) {
    $categoryName = $_POST['category_name'];

    $categoryCtrl = new ProductCategoryCtrl();

    try {
        $categoryCtrl->createCategory($categoryName);
        header("Location: ../pages/dashboard.php?page=category_list&success=categorycreated");
    } catch (Exception $e) {
        header("Location: ../pages/dashboard.php?page=create_category&error=" . urlencode($e->getMessage()));
    }
    exit();
} else {
    header("Location: ../pages/dashboard.php?page=create_category");
    exit();
}
