<?php
// search_equipment.inc.php
require_once '../includes/class_Autoloader.inc.php';

if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $equipmentCtrl = new EquipmentCtrl();
    $results = $equipmentCtrl->searchEquipment($query);
    echo json_encode($results);
}
