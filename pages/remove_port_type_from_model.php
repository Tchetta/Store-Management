<?php
require_once '../includes/class_autoloader.inc.php';

if (isset($_GET['model_id']) && isset($_GET['port_type_id'])) {
    $modelId = $_GET['model_id'];
    $portTypeId = $_GET['port_type_id'];

    $modelPortTypeCtrl = new ModelPortTypeCtrl();

    try {
        $modelPortTypeCtrl->removePortType($modelId, $portTypeId);
        header("Location: ../pages/dashboard.php?page=model_port_types&success=port+type+removed");
    } catch (Exception $e) {
        header("Location: ../pages/dashboard.php?page=model_port_types&error=" . urlencode($e->getMessage()));
    }
}
?>

<!-- Example Link -->
<a href="?model_id=1&port_type_id=2">Remove Port Type from Model</a>
