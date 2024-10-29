<?php
// Include necessary files and initialize ModelCtrl
require_once '../includes/class_autoloader.inc.php';

$modelCtrl = new ModelCtrl();

if($user_role != 'admin' && $storeId != '') {
$models = $modelCtrl->getModelsInStoreWithQuantity($storeId);
} else {
$models = $modelCtrl->getAllModelsWithQuantity(); // Fetch all models
}

?>

    <div class="view-store-container">
    <div class="create_container">
        <?php if ($user_role === 'admin') : ?>
    <a href="dashboard.php?page=create_model" class="create-link">Create New Model</a>
            <?php endif; ?>
</div>
        <h2 class="h2">Models List</h2>
        <table class="store-table">
            <thead>
                <tr>
                    <th>Model IMAGE</th>
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
                            <td><img class="model-image" src="../uploads/model_image/<?= $model['image_path'] ?>" alt="model image"></td>
                            <td><?php echo htmlspecialchars($model['model_name']); ?></td>
                            <td><?php echo htmlspecialchars($model['brand']); ?></td>
                            <td><?php echo htmlspecialchars($model['category']); ?></td>
                            <td><?php echo $storeId . ': ' . $modelCtrl->getQuantityByStore($model['model_id'], $storeId) ?></td>
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
                                <?php if ($user_role === 'admin') : ?>
                                    <a class="action-link delete" href="../includes/delete_model.inc.php?id=<?php echo $model['model_id']; ?>" onclick="return confirm('Are you sure to Delete this Model?')">Delete </a>
                                <?php else : ?>
                                    <a class="action-link delete" href="dashboard.php?page=remove_equipments&model_id=<?php echo $model['model_id']; ?>">Delete</a>
                                <?php endif; ?>
                                <a class="action-link More" href="dashboard.php?page=equipment_list&model_id=<?php echo $model['model_id']; ?>">More..</a>
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

