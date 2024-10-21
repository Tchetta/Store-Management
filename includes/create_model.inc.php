<?php
require_once '../includes/class_autoloader.inc.php';

if (isset($_POST['submit'])) {
    // Collect form data
    $modelName = $_POST['model_name'];
    $brandId = $_POST['brand_id'];
    $categoryId = $_POST['category_id'];
    $description = $_POST['description'] ?? '';
    
    $unit_length = (isset($_POST['unit_length'])) ? $_POST['unit_length'] : 'm' ;
    $unit_diagonal = (isset($_POST['unit_diagonal'])) ? $_POST['unit_diagonal'] : '"' ;
    $unit_width = (isset($_POST['unit_width'])) ?$_POST['unit_width'] : 'cm' ;
    $unit_height = (isset($_POST['unit_height'])) ? $_POST['unit_height'] : 'cm' ;

    // Handle parameters and specifications
    $specifications = '';
    if (isset($_POST['input_current']) && !empty($_POST['input_current'])) {
        $specifications .= 'Input Current: ' . $_POST['input_current'] . ' A' . PHP_EOL; // Added unit for current
    }
    if (isset($_POST['input_voltage']) && !empty($_POST['input_voltage'])) {
        $specifications .= 'Input Voltage: ' . $_POST['input_voltage'] . ' V' . PHP_EOL; // Added unit for voltage
    }
    if (isset($_POST['output_current']) && !empty($_POST['output_current'])) {
        $specifications .= 'Output Current: ' . $_POST['output_current'] . ' A' . PHP_EOL; // Added unit for current
    }
    if (isset($_POST['output_voltage']) && !empty($_POST['output_voltage'])) {
        $specifications .= 'Output Voltage: ' . $_POST['output_voltage'] . ' V' . PHP_EOL; // Added unit for voltage
    }

    // Handle dimensions
    if (isset($_POST['length']) && !empty($_POST['length'])) {
        $specifications .= 'Length: ' . $_POST['length'] . ' ' . $unit_length . PHP_EOL; 
    }
    if (isset($_POST['width']) && !empty($_POST['width'])) {
        $specifications .= 'Width: ' . $_POST['width'] . ' ' . $unit_width . PHP_EOL; 
    }
    if (isset($_POST['height']) && !empty($_POST['height'])) {
        $specifications .= 'Height: ' . $_POST['height'] . ' ' . $unit_height . PHP_EOL; 
    }
    if (isset($_POST['diagonal']) && !empty($_POST['diagonal'])) {
        $specifications .= 'Diagonal: ' . $_POST['diagonal'] . ' ' . $unit_diagonal . PHP_EOL; 
    }

    // Handle color
    if (isset($_POST['color']) && !empty($_POST['color'])) {
        $specifications .= 'Color: ' . $_POST['color'] . PHP_EOL;
    }

    // Handle port types and quantities
    $portTypes = '';
    $num_of_ports = 0;
    if (isset($_POST['port_types'])) {
        foreach ($_POST['port_types'] as $portTypeId) {
            // Check if the quantity for this port type ID exists and is a scalar value (number)
            $portQuantity = $_POST['quantities'][$portTypeId] ?? 0;
            
            // Fetch the port type name (assuming getPortName is a valid method)
            $portTypeName = (new PortTypeCtrl())->getPortName($portTypeId);
            
            // Append port type and quantity to the $portTypes string
            $portTypes .= $portTypeName . ': ' . $portQuantity . PHP_EOL;
            $num_of_ports+=$portQuantity;
        }
    }


    // Handle image upload
    $imagePath = 'default.png'; // Default image
    if (isset($_FILES['model_image']) && $_FILES['model_image']['error'] === 0) {
        $imageDir = '../uploads/model_image/';
        $imageName = basename($_FILES['model_image']['name']);
        $targetFilePath = $imageDir . $imageName;

        if (move_uploaded_file($_FILES['model_image']['tmp_name'], $targetFilePath)) {
            $imagePath = $imageName; // Store the actual uploaded image path
        } else {
            // Handle upload failure (optional)
            echo 'Image upload failed';
        }
    }

    // Create the model using the ModelCtrl
    $modelCtrl = new ModelCtrl();
    $modelCtrl->createModel($modelName, $brandId, $num_of_ports, $portTypes, $categoryId, $specifications, $description, $imagePath);
    
    // Redirect to a success or model listing page
    header('Location: ../pages/dashboard.php?page=model_list&status=success');
    exit();
} else {
    // Handle form submission failure (optional)
    echo 'Invalid request';
}
?>
