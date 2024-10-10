<?php
require_once 'class_autoloader.inc.php';

if (isset($_GET['id'])) {
    $categoryId = $_GET['id'];

    $categoryCtrl = new ProductCategoryCtrl();

    try {
        $categoryCtrl->deleteCategory($categoryId);
        header("Location: ../pages/dashboard.php?page=category_list&success=categorydeleted");
    } catch (Exception $e) {
        header("Location: ../pages/dashboard.php?page=category_list&error=" . urlencode($e->getMessage()));
    }
    exit();
} else {
    header("Location: ../pages/dashboard.php?page=category_list");
    exit();
}
