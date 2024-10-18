<?php
// Include necessary files and initialize ModelCtrl
require_once '../includes/class_autoloader.inc.php';

$modelCtrl = new ModelCtrl();
$models = $modelCtrl->getAllModels(); // Fetch all models
?>

    <div class="view-store-container">
        <h2 class="h2">Models List</h2>
        <table class="store-table">
            <thead>
                <tr>
                    <th>Model ID</th>
                    <th>Model Name</th>
                    <th>Brand</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Specifications</th>
                    <th>Port Types</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($models) > 0): ?>
                    <?php foreach ($models as $model): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($model['model_id']); ?></td>
                            <td><?php echo htmlspecialchars($model['model_name']); ?></td>
                            <td><?php echo htmlspecialchars($model['brand']); ?></td>
                            <td><?php echo htmlspecialchars($model['category']); ?></td>
                            <td><?php echo htmlspecialchars($model['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($model['specification']); ?></td>
                            <td>
                                <?php
                                // Display port types as a comma-separated list
                                $portTypes = $modelCtrl->getPortTypes($model['model_id']);
                                echo htmlspecialchars($portTypes);
                                ?>
                            </td>
                            <td><?php echo htmlspecialchars($model['description']); ?></td>
                            <td>
                                <!-- Edit button -->
                                <a class="action-link" href="dashboard.php?page=edit_model&model_id=<?php echo $model['model_id']; ?>">Edit</a>
                                <a class="action-link delete" href="../includes/delete_model.inc.php=<?php echo $model['model_id']; ?>">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9">No models found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    
    

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

