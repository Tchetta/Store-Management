<?php
// Include necessary controllers
require_once '../includes/class_Autoloader.inc.php';

$storeCtrl = new StoreCtrl();
$modelCtrl = new ModelCtrl();

// Fetch models for selection
if (isset($_GET['model_id'])) {
    $modelId = $_GET['model_id'];
} else {
    $models = $modelCtrl->getAllModels();
}
// Check if a specific model_id is provided in the URL
// $selectedModelId = $_GET['model_id'] ?? ''; // Get the model_id from URL if available
?>

<div class="model_container model_mt-5">
    <h2 class="model_mb-4">Remove Equipment</h2>

    <!-- Remove Equipment Form -->
    <form action="../includes/remove_equipment.inc.php" method="POST">
        <div class="model_form-group">
            <label for="model">Model:</label>
            <select id="model" name="model_id" required>
                <option value="">Select Model</option>
                
                <?php if (!empty($models)): ?>
                    <?php foreach ($models as $model): ?>
                        <?php if (isset($modelId)): ?>
                        <option value="<?= $model['model_id'] ?>"
                            <?php if ($model['model_id'] == $modelId) echo 'selected'; else echo ''; endif;?>>
                            <?= $model['model_name'] ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <div class="model_form-group">
            <label for="remove_serial_number">Serial Number(s):</label>
            <textarea id="remove_serial_number" name="remove_serial_num" placeholder="Enter serial numbers to remove, separated by commas"></textarea>
        </div>

        <div class="model_form-group">
            <label for="remove_quantity">Quantity to Remove:</label>
            <input type="number" id="remove_quantity" name="remove_quantity" min="1" placeholder="Enter quantity to remove if no serial numbers are specified">
        </div>

        <button type="submit" name="remove_submit">Remove Equipment</button>
    </form>

    <div class="back-arrow-container">
        <a href="javascript:history.back()" class="back-arrow">&#8592; Back</a>
    </div>
</div>
