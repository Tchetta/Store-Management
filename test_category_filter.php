<?php

require_once("includes/class_autoloader.inc.php");

$categoryController = new ProductCategoryCtrl();
$categories = $categoryController->getCategoriesWithQuantities('computer');

foreach ($categories as $category) {
    echo 'Category Name: '.$category['category name'];
}

?>