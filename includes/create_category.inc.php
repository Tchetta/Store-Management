<?php
require_once 'class_autoloader.inc.php';

if (isset($_POST['submit'])) {
    $categoryName = $_POST['category_name'];

    $categoryCtrl = new ProductCategoryCtrl();

    try {
        $categoryCtrl->createCategory($categoryName);
        $success = 'Category created successfully\nCategory Name: ' . $categoryName;
        $success = urlencode($success);
        header("Location: ../pages/dashboard.php?page=category_list&success=$success");
    } catch (Exception $e) {
        header("Location: ../pages/dashboard.php?page=create_category&error=" . urlencode($e->getMessage()));
    }
    exit();
} else {
    header("Location: ../pages/dashboard.php?page=create_category&error=nothing+submitted");
    exit();
}
