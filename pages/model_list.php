<?php
require_once '../includes/class_autoloader.inc.php';

$modelCtrl = new ModelCtrl();

// Variables for search and filter
$searchQuery = $_GET['query'] ?? '';
$searchField = $_GET['field'] ?? 'all';
$sortOrder = $_GET['sort'] ?? 'id_asc';

$models = $modelCtrl->getFilteredModelsInStoreWithQuantity($searchQuery, $searchField, $sortOrder, $storeId);

// Set the page-specific data (this will be accessed in the JS file)
echo "<script>window.pageData = " . json_encode($models) . ";</script>";
?>

<!-- Top Navigation for Export and View Options -->
<div class="top-nav">
    <ul class="nav-buttons">
        <li><a href="dashboard.php?page=create_model">Create Model</a></li>
        <li><a href="#" onclick="exportTo('pdf')">PDF</a></li>
        <li><a href="#" onclick="exportTo('excel')">Excel</a></li>
        <li><a href="#" onclick="toggleView('table')">Table View</a></li>
        <li><a href="#" onclick="toggleView('card')">Card View</a></li>
    </ul>
</div>

<div class="content-area">
    <div class="display-container">
        <p class="result-count">Results found: <?= count($models) ?></p>

        <!-- Table View -->
        <div id="tableView" style="display: <?= (isset($_GET['view']) && $_GET['view'] === 'card') ? 'none' : 'block' ?>;">
            <table>
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
                        <?php if ($user_role === 'admin') : ?>
                            <th>Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($models)) : ?>
                        <?php foreach ($models as $model) : ?>
                            <tr>
                                <td><img class="model-image" src="../uploads/model_image/<?= $model['image_path'] ?>" alt="model image"></td>
                                <td><a href="dashboard.php?page=equipment_list_with_search&query=<?= $model['model_name'] ?>"><?= htmlspecialchars($model['model_name']) ?></a></td>
                                <td><?= htmlspecialchars($model['brand']) ?></td>
                                <td><?= htmlspecialchars($model['category']) ?></td>
                                <td><?= htmlspecialchars($model['quantity']) ?></td>
                                <td><?= htmlspecialchars($model['specification']) ?></td>
                                <td><?= htmlspecialchars($model['port_types']) ?></td>
                                <td><?= htmlspecialchars($model['description']) ?></td>
                                <?php if ($user_role === 'admin') : ?>
                                    <td>
                                        <a href="dashboard.php?page=edit_model&model_id=<?= $model['model_id'] ?>" class="edit-action">Edit</a> |
                                        <a href="../includes/delete_model.inc.php?id=<?= $model['model_id'] ?>" class="delete-action" onclick="return confirm('Are you sure you want to delete this model?');">Delete</a>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr><td colspan="10">No models found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Card View -->
        <div id="cardView" style="display: <?= (isset($_GET['view']) && $_GET['view'] === 'card') ? 'block' : 'none' ?>;">
            <?php if (!empty($models)) : ?>
                <?php foreach ($models as $model) : ?>
                    <div class="card">
                        <a href="dashboard.php?page=equipment_list_with_search?query=<?= $model['model_name'] ?>">
                            <div class="card-content">
                                <div class="card-image">
                                    <img class="model-image" src="../uploads/model_image/<?= $model['image_path'] ?>" alt="model image">
                                </div>
                                <p><?= htmlspecialchars($model['category']) ?></p>
                                <p class="uppercase"><?= htmlspecialchars($model['brand']) ?></p>
                                <h4><?= htmlspecialchars($model['model_name']) ?></h4>
                                <p><strong>Quantity:</strong> <span class="quantity-highlight"><?= htmlspecialchars($model['quantity']) ?></span></p>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No models found.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Right Sidebar for Search and Sort -->
    <div class="right-sidebar">
        <form method="GET" action="dashboard.php" class="search-form">
            <input type="hidden" name="page" value="model_list">
            <input type="text" name="query" placeholder="Search..." value="<?= htmlspecialchars($searchQuery) ?>" class="input-small">

            <label for="sort">Sort:</label>
            <select name="sort" class="select-small">
                <option value="id_asc" <?= $sortOrder === 'id_asc' ? 'selected' : '' ?>>ID Asc</option>
                <option value="id_desc" <?= $sortOrder === 'id_desc' ? 'selected' : '' ?>>ID Desc</option>
                <option value="name_asc" <?= $sortOrder === 'name_asc' ? 'selected' : '' ?>>Name Asc</option>
                <option value="name_desc" <?= $sortOrder === 'name_desc' ? 'selected' : '' ?>>Name Desc</option>
            </select>

            <button type="submit" class="btn-small">GO</button>
        </form>
    </div>
</div>

<script src="../js/display.js"></script>
