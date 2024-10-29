<?php
require_once '../includes/class_autoloader.inc.php';

if (isset($_GET['brand_id'])) {
    $brandId = $_GET['brand_id'];
    $brandCtrl = new BrandCtrl();
    $brand = $brandCtrl->getBrandById($brandId);

    // Check the category of the selected brand
    // Assuming categories are fetched based on the brand and defined elsewhere in your application
    if (stripos($brand['category_name'], 'electronics') !== false || 
        stripos($brand['category_name'], 'computer') !== false || 
        stripos($brand['category_name'], 'telecom') !== false) {
        
        $portTypeCtrl = new PortTypeCtrl();
        $portTypes = $portTypeCtrl->getAllPortTypes(); // Fetch all port types
        echo json_encode($portTypes);
    } else {
        echo json_encode([]);
    }
}
?>
