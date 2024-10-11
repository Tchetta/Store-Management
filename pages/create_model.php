<?php
require_once '../includes/class_autoloader.inc.php';

// Fetch brands from the database
$brandCtrl = new BrandCtrl();
$brands = $brandCtrl->getAllBrands();

// Fetch all port types (You can implement a filter by brand if needed)
$portCtrl = new PortTypeCtrl(); // Assuming you have a PortType controller
$allPortTypes = $portCtrl->getAllPortTypes(); // Fetch all port types from the database
?>

<form action="../includes/create_model.inc.php" method="POST" id="modelForm">
    <label for="model_name">Model Name:</label>
    <input type="text" name="model_name" required>

    <label for="brand_id">Brand:</label>
    <select name="brand_id" id="brand_id" required>
        <option value="">Select Brand</option>
        <?php
        foreach ($brands as $brand) {
            echo "<option value='{$brand['brand_id']}'>{$brand['brand_name']}</option>";
        }
        ?>
    </select>

    <div id="portTypeSection" style="display: none;">
        <h3>Select Port Types and Quantities:</h3>
        <div id="portTypesContainer">
            <?php foreach ($allPortTypes as $portType): ?>
                <label>
                    <input type="checkbox" name="port_types[<?= $portType['port_type_id'] ?>]" value="<?= $portType['port_type_id'] ?>">
                    <?= $portType['port_type_name'] ?> Quantity:
                    <input type="number" name="quantities[<?= $portType['port_type_id'] ?>]" min="0" value="0" placeholder="Optional">
                </label>
                <br>
            <?php endforeach; ?>
        </div>
    </div>

    <label for="power_rating">Power Rating:</label>
    <input type="text" name="power_rating" required>

    <button type="submit" name="submit">Create Model</button>
</form>

<!-- Links to other operations -->
<div>
    <a href="dashboard.php?page=model_list">View All Models</a>
</div>

<script>
// JavaScript to handle brand selection and show/hide port types section
document.getElementById('brand_id').addEventListener('change', function() {
    const portTypeSection = document.getElementById('portTypeSection');
    if (this.value) {
        portTypeSection.style.display = 'block';
    } else {
        portTypeSection.style.display = 'none';
    }
});
</script>
