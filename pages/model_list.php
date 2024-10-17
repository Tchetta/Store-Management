<?php
// Include necessary files and initialize ModelCtrl
require_once '../includes/class_autoloader.inc.php';

$modelCtrl = new ModelCtrl();
$models = $modelCtrl->getAllModels(); // Fetch all models
?>

    <div class="container">
        <h2 class="my-4">Models List</h2>
        <table class="table table-striped">
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
                                <a href="dashboard.php?page=edit_model&model_id=<?php echo $model['model_id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                <!-- Delete button with confirmation -->
                                <form action="delete_model.php" method="POST" style="display:inline-block;">
                                    <input type="hidden" name="model_id" value="<?php echo $model['model_id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this model?');">Delete</button>
                                </form>
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

    <p><a href="dashboard.php?page=model_list">View Models</a></p>
    <p><a href="dashboard.php?page=create_model">Create Models</a></p>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

