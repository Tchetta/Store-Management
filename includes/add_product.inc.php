<?php
if (isset($_POST['submit'])) {
    // Get the selected store
    $store_id = $_POST['store_id'];
    
    // Check if any models were selected
    if (!empty($_POST['model_id'])) {
        $selected_models = $_POST['model_id'];
        $model_quantities = $_POST['model_quantity'];
        $serial_numbers = $_POST['serial_numbers'];  // Optional field for serial numbers
        
        foreach ($selected_models as $model_id) {
            // Ensure the quantity is provided and valid
            if (isset($model_quantities[$model_id]) && is_numeric($model_quantities[$model_id]) && $model_quantities[$model_id] > 0) {
                $quantity = (int)$model_quantities[$model_id];
                
                // Get the optional serial numbers (if provided)
                $serial = isset($serial_numbers[$model_id]) ? trim($serial_numbers[$model_id]) : null;

                // Example: Insert the product details into the database
                // Assuming you have a ProductCtrl class to handle the insertion
                $productCtrl = new ProductCtrl();
                $productCtrl->addProduct($store_id, $model_id, $quantity, $serial);
            }
        }

        // Redirect or show a success message
        echo "Product(s) added successfully!";
    } else {
        echo "No models selected!";
    }
}
