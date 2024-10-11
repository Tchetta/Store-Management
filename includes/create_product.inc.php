<?php
require_once '../includes/class_autoloader.inc.php';
require_once 'dbh.class.php'; // Include your database connection
require_once 'control/modelCtrl.class.php';

//     Handle multiple models and quantities
     $modelsSelected = $_POST['model_name']; // Array of selected models
     $modelQuantities = $_POST['model_quantity']; // Array of quantities keyed by model_id
    
//     $productController = new ProductDetailsCtrl();
     $modelCtrl = new ModelCtrl();
       $brandCtrl = new BrandCtrl();
       $categoryCtrl = new ProductCategoryCtrl();

// Instantiate the ProductController with the PDO instance
$productController = new $ProductController($pdo);
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_product'])) {
        $model_name = $_POST['model_name'];
        $quantity = (int)$_POST['quantity'];
        $number_of_ports = $_POST['number_of_ports'];
        $power_rating = $_POST['power_rating'];
        $brand_id = $_POST['brand_id'];

        $message = $productController->addProduct($model_name, $quantity, $number_of_ports, $power_rating, $brand_id);
    } elseif (isset($_POST['remove_product'])) {
        $remove_model_name = $_POST['remove_model_name'];
        $remove_quantity = (int)$_POST['remove_quantity'];
        $message = $productController->removeQuantity($remove_model_name, $remove_quantity);
    }
}

require 'views/product_form.php'; // Load the view