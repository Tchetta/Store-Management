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
