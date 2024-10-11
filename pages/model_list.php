<?php
require_once '../includes/class_autoloader.inc.php';
$modelController = new ModelCtrl();
$models = $modelController->getAllModels();
?>

<table>
    <tr>
        <th>Model ID</th>
        <th>Model</th>
        <th>Number of Ports</th>
        <th>Power Rating</th>
        <th>Brand</th>
        <th>Port Types</th>
        <th>Quantity</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($models as $model): ?>
    <tr>
        <td><?php echo $model['model_id']; ?></td>
        <td><?php echo $model['model_name']; ?></td>
        <td><?php echo $model['number_of_ports']; ?></td>
        <td><?php echo $model['power_rating']; ?></td>
        <td><?php echo $model['brand_id']; ?></td>
        <td><?php echo $model['port_types']; ?></td>
        <td><?php echo $model['quantity']; ?></td>
        <td>
            <a href="dashboard.php?page=edit_model&id=<?php echo $model['model_id']; ?>">Edit</a> |
            <a href="../includes/delete_model.inc.php?id=<?php echo $model['model_id']; ?>">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<!-- Links to other operations -->
<div>
    <a href="dashboard.php?page=create_model">Create New Model</a>
</div>
