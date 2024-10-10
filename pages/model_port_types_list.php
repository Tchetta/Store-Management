<?php
require_once '../includes/class_autoloader.inc.php';
$modelPortTypeCtrl = new ModelPortTypeCtrl();
$modelsWithPortTypes = $modelPortTypeCtrl->getAllModelsWithPortTypes();
?>

<table>
    <tr>
        <th>Model ID</th>
        <th>Model Name</th>
        <th>Port Type Name</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($modelsWithPortTypes as $entry): ?>
    <tr>
        <td><?php echo $entry['model_id']; ?></td>
        <td><?php echo $entry['model_name']; ?></td>
        <td><?php echo $entry['port_type_name'] ?? 'No Port Type'; ?></td>
        <td>
            <a href="remove_port_type_from_model.php?model_id=<?php echo $entry['model_id']; ?>&port_type_id=<?php echo $entry['port_type_id']; ?>">Remove Port Type</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
