<?php
require_once '../includes/class_autoloader.inc.php';

$equipmentCtrl = new EquipmentCtrl();
$equipment = $equipmentCtrl->getAllEquipment();
?>

<h1>Equipment List</h1>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Serial Number</th>
            <th>Store ID</th>
            <th>Model ID</th>
            <th>Category</th>
            <th>Brand</th>
            <th>State</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($equipment as $item): ?>
        <tr>
            <td><?= $item['id'] ?></td>
            <td><?= $item['serial_num'] ?></td>
            <td><?= $item['store_id'] ?></td>
            <td><?= $item['model_id'] ?></td>
            <td><?= $item['category'] ?></td>
            <td><?= $item['brand'] ?></td>
            <td><?= $item['equipment_state'] ?></td>
            <td>
                <a href="dashboard.php?page=edit_equipment&id=<?= $item['id'] ?>">Edit</a>
                <form action="../includes/delete_equipment.php" method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $item['id'] ?>">
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this equipment?')">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
