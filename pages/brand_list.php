<?php
require_once '../includes/class_autoloader.inc.php';

$brandController = new BrandCtrl();

// Variables for search and filter
$searchQuery = $_GET['query'] ?? '';
$sortOrder = $_GET['sort'] ?? 'id_asc';

$brands = $brandController->getBrandsWithQuantities($searchQuery, $sortOrder, $storeId);

// Set the page-specific data (this will be accessed in the JS file)
echo "<script>window.pageData = " . json_encode($brands) . ";</script>";
?>

<!-- Top Navigation for Export and View Options -->
<div class="top-nav">
    <ul class="nav-buttons">
        <li><a href="#" onclick="exportTo('pdf')">PDF</a></li>
        <li><a href="#" onclick="exportTo('excel')">Excel</a></li>
        <li><a href="#" onclick="toggleView('table')">Table View</a></li>
        <li><a href="#" onclick="toggleView('card')">Card View</a></li>
    </ul>
</div>

<div class="content-area">
    <div class="display-container">
        <p class="result-count">Results found: <?= count($brands) ?></p>

        <!-- Table View -->
        <div id="tableView" style="display: <?= (isset($_GET['view']) && $_GET['view'] === 'card') ? 'none' : 'block' ?>;">
            <table>
                <thead>
                    <tr>
                        <th>Brand Name</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <?php if ($user_role === 'admin') : ?>
                            <th>Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($brands)) : ?>
                        <?php foreach ($brands as $brand) : ?>
                            <tr>
                                <td><a href="dashboard.php?page=equipment_list_with_search&query=<?= htmlspecialchars($brand['brand_name']) ?>"><?= htmlspecialchars($brand['brand_name']) ?></a></td>
                                <td><?= htmlspecialchars($brand['description']) ?></td>
                                <td><?= htmlspecialchars($brand['quantity']) ?></td>
                                <?php if ($user_role === 'admin') : ?>
                                    <td>
                                        <a href="dashboard.php?page=edit_brand&brand_id=<?= $brand['brand_id'] ?>" class="edit-action">Edit</a> |
                                        <a href="../includes/delete_brand.inc.php?brand_id=<?= $brand['brand_id'] ?>" class="delete-action" onclick="return confirm('Are you sure you want to delete this brand?');">Delete</a>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr><td colspan="5">No brands found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Card View -->
        <div id="cardView" style="display: <?= (isset($_GET['view']) && $_GET['view'] === 'card') ? 'block' : 'none' ?>;">
            <?php if (!empty($brands)) : ?>
                <?php foreach ($brands as $brand) : ?>
                    <div class="card">
                        <a href="dashboard.php?page=equipment_list_with_search&query=<?= $brand['brand_name'] ?>">
                            <div class="card-content">
                                <h4><?= htmlspecialchars($brand['brand_name']) ?></h4>
                                <p><strong>Quantity:</strong> <span class="quantity-highlight"><?= htmlspecialchars($brand['quantity']) ?></span></p>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No brands found.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Right Sidebar for Search and Sort -->
    <div class="right-sidebar">
        <form method="GET" action="dashboard.php" class="search-form">
            <input type="hidden" name="page" value="brand_list">
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

