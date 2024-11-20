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

<form action="../includes/edit_equipment.inc.php" method="POST">
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
    <!-- State selection box -->
    <?php
        $stateController = new StateCtrl();
        $states = $stateController->getAllStates();
     ?>
    <div class="model_form-group">
        <label for="state">State:</label>
        <select name="state" id="state">
            <?php  foreach ($states as $state): ?>
                <option value="<?= $state['state_name'] ?>"><?= $state['state_name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <button type="submit">Update Equipment</button>
</form>
<div class="back-arrow-container">
    <a href="javascript:history.back()" class="back-arrow">
        &#8592; Back
    </a>
</div>
<div class="link-container">
<a href="dashboard.php?page=equipment_list_with_search" class="link">View All Products</a>
</div>
</div>