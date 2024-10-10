<?php
require_once '../includes/class_autoloader.inc.php';

if (isset($_POST['submit'])) {
    $modelId = $_POST['model_id'];
    $portTypeId = $_POST['port_type_id'];

    $modelPortTypeCtrl = new ModelPortTypeCtrl();

    try {
        $modelPortTypeCtrl->addPortType($modelId, $portTypeId);
        header("Location: ../pages/dashboard.php?page=model_port_types&success=porttypeadded");
    } catch (Exception $e) {
        header("Location: ../pages/dashboard.php?page=model_port_types&error=" . urlencode($e->getMessage()));
    }
}
?>

<form action="" method="POST">
    <label for="model_id">Model ID:</label>
    <input type="text" name="model_id" required>

    <label for="port_type_id">Port Type ID:</label>
    <input type="text" name="port_type_id" required>

    <button type="submit" name="submit">Add Port Type to Model</button>
</form>
