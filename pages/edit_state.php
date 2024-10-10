<?php
require_once '../includes/class_autoloader.inc.php';
$stateController = new StateCtrl();
$state = $stateController->getStateById($_GET['id']);
?>

<form action="../includes/edit_state.inc.php" method="POST">
    <input type="hidden" name="state_id" value="<?php echo $state['state_id']; ?>">

    <label for="state_name">State Name:</label>
    <input type="text" name="state_name" value="<?php echo $state['state_name']; ?>" required>

    <button type="submit" name="submit">Update State</button>
</form>

<!-- Links to other operations -->
<div>
    <a href="dashboard.php?page=create_state">Create New State</a> | 
    <a href="dashboard.php?page=state_list">View All States</a>
</div>
