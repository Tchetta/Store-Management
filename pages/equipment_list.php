<?php
require_once '../includes/class_autoloader.inc.php';

$equipmentCtrl = new EquipmentCtrl();
$modelCtrl = new ModelCtrl();

$modelId = $_GET['model_id'] ?? null ;


if (isset($_GET['store_id']) && $_GET['store_id'] != '') {
    $storeId = $_GET['store_id'];
}

?>

<div class="view-store-container">

<?php if ($user_role !== 'admin') : ?>

    <div class="create_container">
    <a href="dashboard.php?page=add_equipment" class="create-link">Add Product</a>
</div>
<?php endif; ?>

<?php
    if ($user_role === 'admin' || (isset($storeId) && $storeId !== '')) {
        if ((isset($storeId) && $storeId !== '') || (isset($modelId) && $storeId !== '')) {
            // Get filtered equipment based on available filters
            $equipments = $equipmentCtrl->getFilteredEquipment($storeId ?? null, $modelId ?? null);
    
            // Display the filter criteria in the title
            $title = "Equipment List";
            if (isset($storeId)) {
                $title .= " in Store {$storeId}";
            }
            if (isset($modelId)) {
                $modelName = $modelCtrl->getModelName($modelId);
                $title .= " with Model {$modelName}";
            }
            echo "<h2>$title</h2>";
        } else if ($user_role === 'admin') {
            $equipments = $equipmentCtrl->getAllEquipment();
            echo '<h2>All Equipment List</h2>';
        }    
    } else {
        $error = 'You are not a manager of any store';
        header("Location: dashboard.php?error={$error}");
    }

    // Display equipment
     
        
?>


<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Serial Number</th>            
            <th>Store</th>
            <th>Model</th>
            <th>Category</th>
            <th>Brand</th>
            <th>State</th>
            <?php if ($user_role !== 'admin') : ?>
            <th>Actions</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($equipments)) :
         foreach ($equipments as $item): ?>
        <tr>
            <td><?= $item['id'] ?></td>
            <td><?= $item['serial_num'] ?></td>
            <?php
                echo '<td>' . $item['store_id'] . '</td>';
            ?>
            <td>
                <?php 
                    $modelName = $modelCtrl->getModelName($item['model_id']);
                    echo $modelName;
                ?>
             </td>
            <td><?= $item['category'] ?></td>
            <td><?= $item['brand'] ?></td>
            <td><?= $item['equipment_state'] ?></td>
            <?php if ($user_role !== 'admin') : ?>
            <td>
                <a href="dashboard.php?page=edit_equipment&id=<?= $item['id'] ?>" class="edit-action">Edit</a>
                <a style="display:inline;" href="../includes/delete_equipment.inc.php?id=<?= $item['id'] ?>" class="delete-action" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
            </td>
            <?php endif; ?>
        </tr>
        <?php endforeach; ?>
        <?php else : ?>
            <tr><td col-span="8">No Equipments Found<td></tr>
        <?php endif; ?>
    </tbody>
</table>


