<?php

$equipmentCtrl = new EquipmentCtrl();
$modelCtrl = new ModelCtrl();

// Variables for search and filter
$searchQuery = $_GET['query'] ?? '';
$searchField = $_GET['field'] ?? 'all'; // Options: 'all', 'store', 'category', 'brand', etc.
$sortOrder = $_GET['sort'] ?? 'id_asc'; // Sort options

// Fetch equipment based on filters and search
$equipments = $equipmentCtrl->getFilteredEquipments($searchQuery, $searchField, $sortOrder, $storeId);

?>

<div class="view-store-container">
    <!-- Display Result Count -->
    <p class="result-count">Results found: <?= count($equipments) ?></p>
    
    <div class="search-sort-container">
        <!-- Search and Sort Form -->
        <form method="GET" action="dashboard.php" class="search-form">
            <input type="hidden" name="page" value="equipment_list_with_search">
            <input type="text" name="query" placeholder="Search..." value="<?= htmlspecialchars($searchQuery) ?>" class="input-small">
            
            <label for="field">By:</label>
            <select name="field" class="select-small">
                <option value="all" <?= $searchField === 'all' ? 'selected' : '' ?>>All Fields</option>
                <option value="store" <?= $searchField === 'store' ? 'selected' : '' ?>>Store</option>
                <option value="category" <?= $searchField === 'category' ? 'selected' : '' ?>>Category</option>
                <option value="brand" <?= $searchField === 'brand' ? 'selected' : '' ?>>Brand</option>
                <option value="model" <?= $searchField === 'model' ? 'selected' : '' ?>>Model</option>
            </select>

            <label for="sort">Sort:</label>
            <select name="sort" class="select-small">
                <option value="id_asc" <?= $sortOrder === 'id_asc' ? 'selected' : '' ?>>ID Asc</option>
                <option value="id_desc" <?= $sortOrder === 'id_desc' ? 'selected' : '' ?>>ID Desc</option>
                <option value="name_asc" <?= $sortOrder === 'name_asc' ? 'selected' : '' ?>>Name Asc</option>
                <option value="name_desc" <?= $sortOrder === 'name_desc' ? 'selected' : '' ?>>Name Desc</option>
                <option value="category" <?= $sortOrder === 'category' ? 'selected' : '' ?>>Category</option>
                <option value="brand" <?= $sortOrder === 'brand' ? 'selected' : '' ?>>Brand</option>
                <option value="store" <?= $sortOrder === 'store' ? 'selected' : '' ?>>Store</option>
            </select>

            <button type="submit" class="btn-small">Search</button>
        </form>

        <!-- Export Buttons -->
        <div class="export-buttons">
            <button onclick="exportTo('pdf')" class="btn-small">PDF</button>
            <button onclick="exportTo('excel')" class="btn-small">Excel</button>
        </div>

        <script>
        function exportTo(format) {
            const equipments = JSON.stringify(<?= json_encode($equipments); ?>);
            const storeId = <?= isset($storeId) ? json_encode($storeId) : 'null'; ?>;
            
            // Encode data for URL
            const params = new URLSearchParams();
            params.append('equipments', equipments);
            if (storeId) {
                params.append('store_id', storeId);
            }
            
            // Redirect to the respective export file with parameters
            const url = format === 'pdf' 
                ? '../includes/export_equipment_to_pdf.inc.php?' + params.toString() 
                : '../includes/export_equipment_to_excel.inc.php?' + params.toString();
            
            window.location.href = url;
        }
        </script>
    </div>

    <!-- View Toggle Buttons -->
    <div class="view-toggle">
        <button onclick="toggleView('table')" class="btn-small">Table View</button>
        <button onclick="toggleView('card')" class="btn-small">Card View</button>
    </div>

    <!-- Table View -->
    <div id="tableView" style="display: <?= (isset($_GET['view']) && $_GET['view'] === 'card') ? 'none' : 'block' ?>;">

        <table>
            <thead>
                <tr>
                    <th>Serial Number</th>
                    <th>Store</th>
                    <th>Model</th>
                    <th>Category</th>
                    <th>Brand</th>
                    <th>State</th>
                    <th>Specifications</th>
                    <th>Description</th>
                    <?php if ($user_role !== 'admin') : ?>
                        <th>Actions</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($equipments)) : ?>
                    <?php foreach ($equipments as $item) : ?>
                        <tr>
                            <td><?= $item['serial_num'] ?></td>
                            <td><?= $item['store_name'] ?></td>
                            <td><?= $item['model_name'] ?></td>
                            <td><?= $item['category_name'] ?></td>
                            <td><?= $item['brand'] ?></td>
                            <td><?= $item['equipment_state'] ?></td>
                            <td><?= $item['specification'] ?></td>
                            <td><?= $item['description'] ?></td>
                            <?php if ($user_role !== 'admin') : ?>
                                <td>
                                    <a href="dashboard.php?page=edit_equipment&id=<?= $item['id'] ?>" class="edit-action">Edit</a> |
                                    <a href="../includes/delete_equipment.inc.php?id=<?= $item['id'] ?>" class="delete-action" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr><td colspan="10">No equipment found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Display in Card View -->
    <div id="cardView" style="display: <?= $_GET['view'] === 'card' ? 'block' : 'none' ?>;">
        <?php if (!empty($equipments)) : ?>
            <?php foreach ($equipments as $item) : ?>
                <div class="card">
                    <h4><?= htmlspecialchars($item['model_name']) ?></h4>
                    <p><strong>Serial Number:</strong> <?= htmlspecialchars($item['serial_num']) ?></p>
                    <p><strong>Store:</strong> <?= htmlspecialchars($item['store_name']) ?></p>
                    <p><strong>Category:</strong> <?= htmlspecialchars($item['category_name']) ?></p>
                    <p><strong>Brand:</strong> <?= htmlspecialchars($item['brand']) ?></p>
                    <p><strong>State:</strong> <?= htmlspecialchars($item['equipment_state']) ?></p>
                    <p><strong>Specifications:</strong> <?= htmlspecialchars($item['specification']) ?></p>
                    <p><strong>Description:</strong> <?= htmlspecialchars($item['description']) ?></p>
                    <?php if ($user_role !== 'admin') : ?>
                        <div>
                            <a href="dashboard.php?page=edit_equipment&id=<?= $item['id'] ?>" class="edit-action">Edit</a> |
                            <a href="../includes/delete_equipment.inc.php?id=<?= $item['id'] ?>" class="delete-action" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No equipment found.</p>
        <?php endif; ?>
    </div>
</div>

<script>
    function toggleView(view) {
        document.getElementById('tableView').style.display = view === 'table' ? 'block' : 'none';
        document.getElementById('cardView').style.display = view === 'card' ? 'block' : 'none';
    }
</script>

<style>
    /* Styles for card view */
    .card { border: 1px solid #ddd; padding: 10px; margin: 10px 0; }
    .card h4 { margin: 0 0 5px; }
    .card p { margin: 2px 0; }
    .view-toggle { margin-top: 10px; }
</style>
