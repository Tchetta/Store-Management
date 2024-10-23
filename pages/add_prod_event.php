<?php 
require_once '../includes/class_autoloader.inc.php';

$modelController = new ModelCtrl();
$categoryController = new ProductCategoryCtrl();
$storeController = new StoreCtrl();

$models = $modelController->getAllModels();
$categories = $categoryController->getAllCategories();
$stores = $storeController->getAllStores();
?>

<form action="../includes/addition.inc.php" method="post">
<select name="model_id" id="">
    <?php foreach ($models as $model) {
      ?>
    <option value="<?php echo $model['model_id']; ?>"><?php echo $model['model_name']. ' (' . $model['model_id'] . ')'; ?></option>
    <?php  } ?>
</select>
<input type="number" name="qty" id="">
<button type="submit">Add product</button>
</form>