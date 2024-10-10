<?php
require_once '../includes/class_autoloader.inc.php';
$stateController = new StateCtrl();
$states = $stateController->getAllStates();
?>

<table>
    <tr>
        <th>State ID</th>
        <th>State Name</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($states as $state): ?>
    <tr>
        <td><?php echo $state['state_id']; ?></td>
        <td><?php echo $state['state_name']; ?></td>
        <td>
            <a href="dashboard.php?page=edit_state&id=<?php echo $state['state_id']; ?>">Edit</a> |
            <a href="../includes/delete_state.inc.php?id=<?php echo $state['state_id']; ?>">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<!-- Links to other operations -->
<div>
    <a href="dashboard.php?page=create_state">Create New State</a>
</div>
