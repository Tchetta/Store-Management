<?php
require_once '../includes/class_autoloader.inc.php';

$equipmentCtrl = new EquipmentCtrl();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $equipment = $equipmentCtrl->getEquipmentById($id);
} else {
    header('Location: equipment_list.php');
    exit();
}
?>
<div class="model_container model_mt-5">    
<h1>Edit Equipment</h1>

<form action="../includes/edit_equipment_handler.php" method="POST">
    <input type="hidden" name="id" value="<?= $equipment['id'] ?>">
    <div class="model_form-group">
    <label for="serial_num">Serial Number:</label>
    <input type="text" name="serial_num" value="<?= $equipment['serial_num'] ?>" required><br>
    </div>
    <div class="model_form-group">
    <label for="store_id">Store ID:</label>
    <input type="text" name="store_id" value="<?= $equipment['store_id'] ?>" required><br>
    </div>
    <div class="model_form-group">
    <label for="model_id">Model ID:</label>
    <input type="text" name="model_id" value="<?= $equipment['model_id'] ?>" required><br>
    </div>
    <div class="model_form-group">
    <label for="category">Category:</label>
    <input type="text" name="category" value="<?= $equipment['category'] ?>" required><br>
    </div>
    <div class="model_form-group">
    <label for="brand">Brand:</label>
    <input type="text" name="brand" value="<?= $equipment['brand'] ?>" required><br>
    </div>
    <div class="model_form-group">
    <label for="equipment_state">State:</label>
    <input type="text" name="equipment_state" value="<?= $equipment['equipment_state'] ?>" required><br>
    </div>
    <button type="submit">Update Equipment</button>
</form>
<div class="link-container">
<a href="dashboard.php?page=equipment_list" class="link">View All Products</a>
</div>
</div>