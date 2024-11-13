<?php
$equipmentCtrl = new EquipmentCtrl();
$modelCtrl = new ModelCtrl();

// Variables for search and filter
$searchQuery = $_GET['query'] ?? '';
$searchField = $_GET['field'] ?? 'all';
$sortOrder = $_GET['sort'] ?? 'id_asc';

// Fetch equipment based on filters and search
$equipments = $equipmentCtrl->getFilteredEquipments($searchQuery, $searchField,  $sortOrder, $storeId);

// Set the page-specific data (this will be accessed in the JS file)
echo "<script>window.equipments = " . json_encode($equipments) . ";</script>";
echo "<script>window.storeId = " . (isset($storeId) ? json_encode($storeId) : 'null') . ";</script>";

?>


    <!-- Top Navigation for Export and View Options -->
    <div class="top-nav">
    <ul class="nav-buttons">
        <li><a href="<?php echo ($user_role !== 'admin') ? 'dashboard.php?page=add_equipment' : ''; ?>">Add New Equipments</a></li>
        <li><a href="#" onclick="exportTo('pdf')">PDF</a></li>
        <li><a href="#" onclick="exportTo('excel')">Excel</a></li>
        <li><a href="#" onclick="toggleView('table')">Table View</a></li>
        <li><a href="#" onclick="toggleView('card')">Card View</a></li>
    </ul>
</div>

    <div class="content-area">
        <!-- Left Side: Display Results (Table or Card View) -->
        <div class="display-container">
            <!-- Display Result Count -->
            <p class="result-count">Results found: <?= count($equipments) ?></p>

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
            <?php
                // Set state class based on equipment state
                $stateClass = '';
                switch ($item['equipment_state']) {
                    case 'NEW':
                        $stateClass = 'state-new';
                        break;
                    case 'OLD':
                        $stateClass = 'state-old';
                        break;
                    case 'FAULTY':
                        $stateClass = 'state-faulty';
                        break;
                    case 'TO REPAIR':
                        $stateClass = 'state-to-repair';
                        break;
                    case 'MAINTAINED':
                        $stateClass = 'state-maintained';
                        break;
                }
            ?>
            <tr>
                <td><?= $item['serial_num'] ?></td>
                <td><?= $item['store_name'] ?></td>
                <td><?= $item['model_name'] ?></td>
                <td><?= $item['category_name'] ?></td>
                <td><?= $item['brand'] ?></td>
                <td class="<?= $stateClass ?>"><?= $item['equipment_state'] ?></td>
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

            <!-- Card View -->
<div id="cardView" style="display: <?= (isset($_GET['view']) && $_GET['view'] === 'card') ? 'none' : 'block' ?>;">
    <?php if (!empty($equipments)) : ?>
        <?php foreach ($equipments as $item) : ?>
            <?php
                // Set state class based on equipment state
                $stateClass = '';
                switch ($item['equipment_state']) {
                    case 'NEW':
                        $stateClass = 'state-new';
                        break;
                    case 'OLD':
                        $stateClass = 'state-old';
                        break;
                    case 'FAULTY':
                        $stateClass = 'state-faulty';
                        break;
                    case 'TO REPAIR':
                        $stateClass = 'state-to-repair';
                        break;
                    case 'MAINTAINED':
                        $stateClass = 'state-maintained';
                        break;
                }
            ?>
            <div class="card">
                <h5><?= htmlspecialchars($item['category_name']) ?></h5>
                <p class="uppercase"><?= htmlspecialchars($item['brand']) ?></p>
                <h4><?= htmlspecialchars($item['model_name']) ?></h4>
                <p><strong>Serial Number:</strong> <?= htmlspecialchars($item['serial_num']) ?></p>
                <p><strong>Store:</strong> <?= htmlspecialchars($item['store_name']) ?></p>
                <p><strong>State:</strong> <span class="<?= $stateClass ?>"><?= htmlspecialchars($item['equipment_state']) ?></span></p>
                <?php if ($user_role !== 'admin') : ?>
                    <div>
                        <a class="action-link" href="dashboard.php?page=edit_equipment&id=<?= $item['id'] ?>">Edit</a> |
                        <a class="action-link delete" href="../includes/delete_equipment.inc.php?id=<?= $item['id'] ?>" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p>No equipment found.</p>
    <?php endif; ?>
</div>

        </div>

        <!-- Right Sidebar for Search and Sort -->
        <div class="right-sidebar">
            <form method="GET" action="dashboard.php" class="search-form">
                <input type="hidden" name="page" value="equipment_list_with_search">
                <input type="text" name="query" placeholder="Search..." value="<?= htmlspecialchars($searchQuery) ?>" class="input-small">

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

                <button type="submit" class="btn-small">GO</button>
            </form>
        </div>
    </div>

<script src="../js/display.js"></script>

