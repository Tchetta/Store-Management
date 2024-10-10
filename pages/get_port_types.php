<?php
require_once '../includes/class_autoloader.inc.php';

if (isset($_GET['brand_id'])) {
    $brandId = $_GET['brand_id'];
    $brandCtrl = new BrandCtrl();
    $brand = $brandCtrl->getBrandById($brandId);

    // Check the category of the selected brand
    if (stripos($brand['category_name'], 'electronics') !== false || 
        stripos($brand['category_name'], 'computer') !== false || 
        stripos($brand['category_name'], 'telecom') !== false) {
        
        $portTypeCtrl = new PortTypeCtrl();
        $portTypesWithModels = $portTypeCtrl->getAllPortTypesWithModels(); // Fetch port types with models

        // Format the result
        $response = [];
        foreach ($portTypesWithModels as $portType => $models) {
            $modelNames = array_column($models, 'model_name');
            $response[] = [
                'port_type_name' => $portType,
                'models' => implode(', ', $modelNames) // Combine model names into a comma-separated string
            ];
        }

        echo json_encode($response);
    } else {
        echo json_encode([]); // Return an empty array if the category doesn't match
    }
}
?>
