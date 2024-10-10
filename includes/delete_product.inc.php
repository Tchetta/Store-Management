<?php
require_once '../includes/class_autoloader.inc.php';

if (isset($_GET['serial_num'])) {
    $serialNum = $_GET['serial_num'];

    $productController = new ProductDetailsCtrl();
    $productController->deleteProduct($serialNum);

    header("Location: ../pages/product_list.php?success=productdeleted");
}
