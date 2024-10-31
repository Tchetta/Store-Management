<?php
require_once '../includes/class_autoloader.inc.php';

class EquipmentCtrl extends Dbh
{
    public function addEquipment($serial_num, $store_id, $model_id, $category, $brand) {
        $sql = "INSERT INTO equipment (serial_num, store_id, model_id, category, brand) values (?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$serial_num, $store_id, $model_id, $category, $brand]);
    }

    // Update individual fields
    public function updateSerialNum($id, $serial_num) {
        $sql = "UPDATE equipment SET serial_num = ? WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$serial_num, $id]);
    }

    public function updateStoreId($id, $store_id) {
        $sql = "UPDATE equipment SET store_id = ? WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$store_id, $id]);
    }

    public function updateModelId($id, $model_id) {
        $sql = "UPDATE equipment SET model_id = ? WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$model_id, $id]);
    }

    public function updateCategory($id, $category) {
        $sql = "UPDATE equipment SET category = ? WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$category, $id]);
    }

    public function updateBrand($id, $brand) {
        $sql = "UPDATE equipment SET brand = ? WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$brand, $id]);
    }

    public function updateEquipmentState($id, $equipment_state) {
        $sql = "UPDATE equipment SET equipment_state = ? WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$equipment_state, $id]);
    }

    // Delete equipment
    public function deleteEquipment($id) {
        $sql = "DELETE FROM equipment WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id]);
    }

    // Fetch all equipment to display
    public function getAllEquipment() {
        $sql = "SELECT * FROM equipment";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Fetch all equipment by storeId
    public function getAllEquipmentByStoreId($storeId) {
        $sql = "SELECT * FROM equipment WHERE store_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$storeId]);
        return $stmt->fetchAll();
    }

    public function getFilteredEquipment($storeId = null, $modelId = null) {
        $query = "SELECT * FROM equipment WHERE 1=1";
        $params = [];

        if (!empty($storeId) && $storeId !== '') {
            $query .= " AND store_id = :storeId";
            $params[':storeId'] = $storeId;
        }

        if (!empty($modelId)) {
            $query .= " AND model_id = :modelId";
            $params[':modelId'] = $modelId;
        }

        $stmt = $this->connect()->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function removeEquipmentBySerial($modelId, $serialNum) {
        // Check if the equipment with the specific serial number exists for the given model
        $sql1 = 'SELECT COUNT(*) FROM equipment WHERE model_id = :model_id AND serial_num = :serial_num';
        $stmt1 = $this->connect()->prepare($sql1);
        $stmt1->bindParam(':model_id', $modelId, PDO::PARAM_INT);
        $stmt1->bindParam(':serial_num', $serialNum, PDO::PARAM_STR);
        $stmt1->execute();
        
        if ($stmt1->fetchColumn() > 0) {
            // Proceed with deletion if the serial number exists
            $sql = "DELETE FROM equipment WHERE model_id = :model_id AND serial_num = :serial_num";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':model_id', $modelId, PDO::PARAM_INT);
            $stmt->bindParam(':serial_num', $serialNum, PDO::PARAM_STR);
            $stmt->execute();
        } else {
            // Throw an exception if no matching serial number is found
            throw new Exception("Error: No such serial number: {$serialNum} found for model ID {$modelId}.", 1);
        }
    }
    

    public function removeEquipmentByQuantity($modelId, $quantity) {
        $sql = "DELETE FROM equipment WHERE model_id = :model_id LIMIT :quantity";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':model_id', $modelId, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Fetch all equipment by modelId
    public function getAllEquipmentByModelId($modelId) {
        $sql = "SELECT * FROM equipment WHERE model_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$modelId]);
        return $stmt->fetchAll();
    }

    public function getModelId($eqId) {
        $sql = "SELECT model_id FROM equipment WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchColumn();
    }

    // Fetch specific equipment by id
    public function getEquipmentById($id) {
        $sql = "SELECT * FROM equipment WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
