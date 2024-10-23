<?php
require_once '../classes/control/dbh.class.php';
if (isset($_POST['submit'])) {
    // Get the selected store
    $store_id = $_POST['store_id'];

        
        foreach ($serialNums as $serialNum) {
            $serial_numbers = $_POST['serial_numbers'];
            // Ensure the quantity is provided and valid
            if (isset($serial_numbers[$serial_num])){
               $stmt->execute(['sn'=>$serialNum]);
            }
        }

        // Redirect or show a success message
        echo "Product(s) added successfully!";
    } else {
        echo "No models selected!";
    }
