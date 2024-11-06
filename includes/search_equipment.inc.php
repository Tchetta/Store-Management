<?php
// search_equipment.inc.php
require_once 'class_Autoloader.inc.php';

header('Content-Type: application/json'); // Set content type for JSON response

if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $equipmentCtrl = new EquipmentCtrl();

    try {
        $results = $equipmentCtrl->searchEquipment($query);
        echo json_encode($results ? $results : []);
    } catch (Exception $e) {
        echo json_encode(['error' => 'Error retrieving search results.']);
    }
} else {
    echo json_encode(['error' => 'Query parameter is missing.']);
}
