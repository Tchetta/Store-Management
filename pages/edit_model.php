<?php
require_once '../includes/class_autoloader.inc.php';
$modelController = new ModelCtrl();
$model = $modelController->getModelById($_GET['id']);
?>

<form action="../includes/edit_model.inc.php" method="POST">
    <input type="hidden" name="model_id" value="<?php echo $model['model_id']; ?>">

    <label for="model_name">Model Name:</label>
    <input type="text" name="model_name" value="<?php echo $model['model_name']; ?>" required>

    <label for="number_of_ports">Number of Ports:</label>
    <input type="number" name="number_of_ports" value="<?php echo $model['number_of_ports']; ?>" required>

    <label for="port_types">Port Types:</label>
    <input type="text" name="port_types" value="<?php echo $model['port_types']; ?>" required>

    <label for="power_rating">Power Rating:</label>
    <input type="text" name="power_rating" value="<?php echo $model['power_rating']; ?>">

    <label for="brand_id">Brand ID:</label>
    <input type="number" name="brand_id" value="<?php echo $model['brand_id']; ?>" required>

    <label for="quantity">Quantity:</label>
    <input type="number" name="quantity" value="<?php echo $model['quantity']; ?>">

    <button type="submit" name="submit">Update Model</button>
</form>

<!-- Links to other operations -->
<div>
    <a href="dashboard.php?page=create_model">Create New Model</a> | 
    <a href="dashboard.php?page=model_list">View All Models</a>
</div>
