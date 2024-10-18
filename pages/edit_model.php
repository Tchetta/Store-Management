<?php
// Include necessary files and initialize ModelCtrl
require_once '../includes/class_autoloader.inc.php';

$modelId = $_GET['model_id'] ?? null;
$modelCtrl = new ModelCtrl();

if ($modelId) {
    // Get the model details by ID
    $model = $modelCtrl->getModelById($modelId);
    if (!$model) {
        die('Model not found');
    }
} else {
    die('Invalid model ID');
}
?>
 <div class="model_container model_mt-5">
    <h2 class="model_mb-4">Edit Model: <?php echo htmlspecialchars($model['model_name']); ?></h2>
    <form action="../includes/edit_model.inc.php" method="POST" enctype="multipart/form-data">
  
    <input type="hidden" name="model_id" value="<?php echo $modelId; ?>">
    <div class="model_form-group">
        <label for="model_name">Model Name</label>
        <input type="text" name="model_name" id="model_name" value="<?php echo htmlspecialchars($model['model_name']); ?>" required>
    </div>
    <div class="model_form-group">
        <label for="brand_id">Brand</label>
        <input type="text" name="brand_id" id="brand_id" value="<?php echo htmlspecialchars($model['brand']); ?>" required>
    </div>
    <div class="model_form-group">
        <label for="category_id">Category</label>
        <input type="text" name="category_id" id="category_id" value="<?php echo htmlspecialchars($model['category']); ?>" required>
    </div>
    <div class="model_form-group">
        <label for="quantity">Quantity</label>
        <input type="number" name="quantity" id="quantity" value="<?php echo htmlspecialchars($model['quantity']); ?>" required>
    </div>
    <div class="model_form-group">
        <label for="description">Description</label>
        <textarea name="description" id="description"><?php echo htmlspecialchars($model['description']); ?></textarea>
    <!-- </div>
    <div class="model_form-group"> -->
        <label for="specification">Specifications</label>
        <textarea name="specification" id="specification"><?php echo htmlspecialchars($model['specification']); ?></textarea>
        </div>
        <div class="model_form-group">
        <label for="ports">Port Types</label>
        <textarea name="portTypes" id="ports"><?php echo htmlspecialchars($model['port_types']); ?></textarea>
    </div>
    <div class="model_form-group">
        <label for="model_image">Upload Image (optional)</label>
        <input type="file" name="model_image" id="model_image">
    </div>
        <button type="submit" name="submit">Save Changes</button>
    </form>
    </div>
   

   

