<?php
require_once 'class_autoloader.inc.php';

if (isset($_POST['submit'])) {
    $categoryId = $_POST['category_id'];
    $categoryName = $_POST['category_name'];
    $quantity = $_POST['quantity'];

    $categoryCtrl = new ProductCategoryCtrl();

    try {
        $categoryCtrl->updateCategory($categoryId, $categoryName, $quantity);
        header("Location: ../pages/dashboard.php?page=category_list&success=category+updated");
    } catch (Exception $e) {
        header("Location: ../pages/dashboard.php?page=edit_category&id=$categoryId&error=" . urlencode($e->getMessage()));
    }
    exit();
} else {
    header("Location: ../pages/dashboard.php?page=edit_category&id=$categoryId");
    exit();
}
