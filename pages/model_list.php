<?php
require_once '../includes/class_autoloader.inc.php';

// Pagination variables for models
$modelLimit = 5; // Number of models to display per page
$modelPage = isset($_GET['model_page']) && is_numeric($_GET['model_page']) ? (int)$_GET['model_page'] : 1;
$modelStart = ($modelPage - 1) * $modelLimit;

// Initialize the ModelCtrl class
$modelController = new ModelCtrl();
$brandController = new BrandCtrl();

// Fetch total number of models to calculate the number of pages
$totalModels = count($modelController->getAllModels());
$totalModelPages = ceil($totalModels / $modelLimit);

// Fetch models for the current page
$models = $modelController->getModelsByPage($modelStart, $modelLimit);
?>


<!-- Model Table -->
<h2>Model List (Table View)</h2>
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
        <td><?php echo htmlspecialchars($model['model_id']); ?></td>
        <td><?php echo htmlspecialchars($model['model_name']); ?></td>
        <td><?php echo htmlspecialchars($model['number_of_ports']); ?></td>
        <td><?php echo htmlspecialchars($model['power_rating']); ?></td>
        <td><?php 
            $brand = $brandController->getBrandById($model['brand_id']);
            echo htmlspecialchars($brand['brand_name']); ?></td>
        <td>
            <?php 
            // Decode port types JSON
            $portTypes = json_decode($model['port_types'], true);
            if ($portTypes) {
                foreach ($portTypes as $port) {
                    echo htmlspecialchars($port['port_name']) . " (Qty: " . htmlspecialchars($port['quantity']) . ")<br>";
                }
            } else {
                echo "No ports selected";
            }
            ?>
        </td>
        <td><?php echo htmlspecialchars($model['quantity']); ?></td>
        <td>
            <a href="dashboard.php?page=edit_model&id=<?php echo htmlspecialchars($model['model_id']); ?>">Edit</a> |
            <a href="../includes/delete_model.inc.php?id=<?php echo htmlspecialchars($model['model_id']); ?>" onclick="return confirm('Are you sure you want to delete this model?');">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<!-- Pagination for Model Table -->
<div>
    <?php if ($totalModelPages > 1): ?>
        <nav>
            <ul style="list-style: none; display: flex; gap: 10px;">
                <?php for ($i = 1; $i <= $totalModelPages; $i++): ?>
                    <li style="display: inline;">
                        <a href="?model_page=<?php echo $i; ?>" style="<?php echo $i == $modelPage ? 'font-weight:bold;' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>

<!-- Display models in divs (Model Overview) -->
<h2>Model Overview (Card View)</h2>
<div class="model-container">
    <?php foreach ($models as $model): ?>
        <div class="model-card">
            <img src="<?= htmlspecialchars($model['image_path']) ?>" alt="<?php echo htmlspecialchars($model['model_name']); ?>" style="width: 100%; height: auto; border-radius: 10px;"/>
            <h3><?php echo htmlspecialchars($model['model_name']); ?></h3>
            <p>Ports: <?php echo htmlspecialchars($model['number_of_ports']); ?></p>
            <p>Power Rating: <?php echo htmlspecialchars($model['power_rating']); ?></p>
            <p>Brand: <?php 
                $brand = $brandController->getBrandById($model['brand_id']);
                echo htmlspecialchars($brand['brand_name']); ?></p>
            <p>Port Types:</p>
            <ul>
                <?php 
                // Decode port types JSON
                $portTypes = json_decode($model['port_types'], true);
                if ($portTypes) {
                    foreach ($portTypes as $port) {
                        echo "<li>" . htmlspecialchars($port['port_name']) . " (Qty: " . htmlspecialchars($port['quantity']) . ")</li>";
                    }
                } else {
                    echo "<li>No ports selected</li>";
                }
                ?>
            </ul>
            <p>Quantity: <?php echo htmlspecialchars($model['quantity']); ?></p>
            <a href="dashboard.php?page=edit_model&id=<?php echo htmlspecialchars($model['model_id']); ?>">Edit</a>
            <a href="../includes/delete_model.inc.php?id=<?php echo htmlspecialchars($model['model_id']); ?>" onclick="return confirm('Are you sure you want to delete this model?');">Delete</a>
        </div>
    <?php endforeach; ?>
</div>

<!-- Pagination for Model Cards (if needed) -->
<div>
    <?php if ($totalModelPages > 1): ?>
        <nav>
            <ul style="list-style: none; display: flex; gap: 10px;">
                <?php for ($i = 1; $i <= $totalModelPages; $i++): ?>
                    <li style="display: inline;">
                        <a href="?model_page=<?php echo $i; ?>" style="<?php echo $i == $modelPage ? 'font-weight:bold;' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>


