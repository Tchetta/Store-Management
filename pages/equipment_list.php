<?php
require_once '../includes/class_autoloader.inc.php';

$equipmentCtrl = new EquipmentCtrl();
$modelCtrl = new ModelCtrl();

?>
 <div class="view-store-container">
    <div class="create_container">
    <a href="dashboard.php?page=add_equipment" class="create-link">Add Product</a>
</div>
<h2>Equipment List</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Serial Number</th>
            <?php
                if($user_role === 'admin') {
                $equipments= $equipmentCtrl->getAllEquipment();
                echo '<th>Store ID</th>';
            } else {
                $equipments= $equipmentCtrl->getAllEquipmentByStoreId($storeId);    
            }
            ?>
            <th>Model</th>
            <th>Category</th>
            <th>Brand</th>
            <th>State</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($equipments as $item): ?>
        <tr>
            <td><?= $item['id'] ?></td>
            <td><?= $item['serial_num'] ?></td>
            <?php
                if($user_role === 'admin') {
                echo '<td>' . $item['store_id'] . '</td>';
            }
            ?>
            <td><?= $item['store_id'] ?></td>
            <td>
                <?php 
                    $modelName = $modelCtrl->getModelName($item['model_id']);
                    echo $modelName;
                ?>
             </td>
            <td><?= $item['category'] ?></td>
            <td><?= $item['brand'] ?></td>
            <td><?= $item['equipment_state'] ?></td>
            <td>
                <a href="dashboard.php?page=edit_equipment&id=<?= $item['id'] ?>" class="edit-action">Edit</a>
                <form action="../includes/delete_equipment.php" method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $item['id'] ?>">
                    <a href="../includes/delete_equipment.inc.php?id=<?php echo htmlspecialchars($user['user_id']); ?>" class="delete-action" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>


