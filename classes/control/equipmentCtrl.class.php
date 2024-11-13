<?php
require_once '../includes/class_autoloader.inc.php';

class EquipmentCtrl extends Dbh
{
    public function addEquipment($serial_num, $store_id, $model_id, $category = '', $brand = '',  $state = 'New') {
        if (empty($model_id)) {
            throw new Exception("Invalid model ID provided.");
        }
    
        $sql = "INSERT INTO equipment (serial_num, store_id, model_id, category, brand, equipment_state) values (?, ?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$serial_num, $store_id, $model_id, $category, $brand, $state]);
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
    public function deleteEquipment($serial_num) {
        $sql = "DELETE FROM equipment WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$serial_num]);
    }

    // Fetch all equipment to display
    public function getAllEquipments() {
        $sql = "SELECT * FROM equipment";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Fetch all equipment by storeId
    public function getAllEquipmentsByStoreId($storeId) {
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

    public function getFilteredEquipments($query = '', $field = 'all', $sort = 'id_asc', $storeId = null) {
        $sql = "SELECT e.id, e.serial_num, s.store_name AS store_name, 
                       m.model_name, m.category AS category_name,
                       e.indate, m.port_types, 
                       m.brand, e.equipment_state, m.specification, 
                       m.description 
                FROM equipment e 
                LEFT JOIN stores s ON e.store_id = s.store_id 
                LEFT JOIN model m ON e.model_id = m.model_id 
                WHERE 1";
    
        // Consider the store
        if (isset($storeId) && $storeId !== "") {
            $sql .= " AND e.store_id = :storeId";
        }

        // Filtering based on field selection
        if (!empty($query)) {
            switch ($field) {
                case 'store':
                    $sql .= " AND s.store_name LIKE :query";
                    break;
                case 'category':
                    $sql .= " AND m.category LIKE :query";
                    break;
                case 'brand':
                    $sql .= " AND m.brand LIKE :query";
                    break;
                case 'model':
                    $sql .= " AND m.model_name LIKE :query";
                    break;
                case 'all':
                default:
                    $sql .= " AND (s.store_name LIKE :query 
                                OR e.equipment_state LIKE :query 
                                OR m.category LIKE :query 
                                OR m.brand LIKE :query 
                                OR m.model_name LIKE :query 
                                OR m.specification LIKE :query 
                                OR m.description LIKE :query)";
                    break;
            }
        }
    
        // Sorting
        switch ($sort) {
            case 'id_desc':
                $sql .= " ORDER BY e.id DESC";
                break;
            case 'name_asc':
                $sql .= " ORDER BY m.model_name ASC";
                break;
            case 'name_desc':
                $sql .= " ORDER BY m.model_name DESC";
                break;
            case 'category':
                $sql .= " ORDER BY m.category DESC";
                break;
            case 'brand':
                $sql .= " ORDER BY m.brand DESC";
                break;
            case 'store':
                $sql .= " ORDER BY e.store_id DESC";
                break;
            default:
                $sql .= " ORDER BY e.id ASC";
                break;
        }
    
        // Prepare and execute the query
        $stmt = $this->connect()->prepare($sql);
    
        // Bind query parameter if there is a search term
        if (!empty($query)) {
            $stmt->bindValue(':query', '%' . $query . '%', PDO::PARAM_STR);
        }

        if (isset($storeId) && $storeId !== "") {
            $stmt->bindValue(':storeId', $storeId, PDO::PARAM_STR);
        }
    
        $stmt->execute();
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
    

    /* public function removeEquipmentByQuantity($modelId, $quantity) {
        $sql = "DELETE FROM equipment WHERE model_id = :model_id LIMIT :quantity";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':model_id', $modelId, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->execute();
    } */

    // Fetch all equipment by modelId
    public function getAllEquipmentsByModelId($modelId) {
        $sql = "SELECT * FROM equipment WHERE model_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$modelId]);
        return $stmt->fetchAll();
    }

    public function getModelId($eqId) {
        $sql = "SELECT model_id FROM equipment WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$eqId]);
        return $stmt->fetchColumn();
    }

    // Fetch specific equipment by id
    public function getEquipmentById($id) {
        $sql = "SELECT * FROM equipment WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function removeEquipmentBySerialNumber($serialNumber, $storeId) {
        $sql = "DELETE FROM equipment 
                WHERE serial_num = :serialNumber AND store_id = :storeId 
                LIMIT 1";
        
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':serialNumber', $serialNumber, PDO::PARAM_STR);
        $stmt->bindParam(':storeId', $storeId, PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            return true; // Success
        } else {
            throw new Exception("Failed to remove equipment with Serial Number: $serialNumber");
        }
    }

    public function removeEquipmentByQuantity($storeId, $modelId, $quantity) {
        // Start a transaction to ensure atomicity
        $this->connect()->beginTransaction();
    
        try {
            // Select the serial numbers of the equipment to be removed
            $selectSql = "SELECT serial_num FROM equipment 
                          WHERE store_id = :storeId AND model_id = :modelId 
                          ORDER BY serial_num ASC 
                          LIMIT :quantity";
            
            $stmtSelect = $this->connect()->prepare($selectSql);
            $stmtSelect->bindParam(':storeId', $storeId, PDO::PARAM_STR);
            $stmtSelect->bindParam(':modelId', $modelId, PDO::PARAM_INT);
            $stmtSelect->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmtSelect->execute();
    
            $serialNumbers = $stmtSelect->fetchAll(PDO::FETCH_COLUMN);
    
            // Verify if there are enough equipment items to remove
            if (count($serialNumbers) < $quantity) {
                throw new Exception("Not enough equipment available to remove the specified quantity.");
            }
    
            // Delete the selected equipment items by serial number
            $deleteSql = "DELETE FROM equipment 
                          WHERE serial_num = :serialNumber 
                          AND store_id = :storeId";
            
            $stmtDelete = $this->connect()->prepare($deleteSql);
            $stmtDelete->bindParam(':storeId', $storeId, PDO::PARAM_STR);
    
            foreach ($serialNumbers as $serialNumber) {
                $stmtDelete->bindParam(':serialNumber', $serialNumber, PDO::PARAM_STR);
                $stmtDelete->execute();
            }
    
            // Commit the transaction after successful deletion
            $this->connect()->commit();
    
            return count($serialNumbers); // Return the count of removed items
    
        } catch (Exception $e) {
            // Roll back on failure
            $this->connect()->rollBack();
            throw new Exception("Failed to remove equipment by quantity: " . $e->getMessage());
        }
    }

        // EquipmentCtrl.php
    public function searchEquipment($query) {
        $sql = "
            SELECT e.*, s.store_name, c.category_name
            FROM equipment AS e
            LEFT JOIN stores AS s ON e.store_id = s.store_id
            LEFT JOIN product_category AS c ON e.category_id = c.category_id
            WHERE e.model_name LIKE :query
            OR s.store_name LIKE :query
            OR c.category_name LIKE :query
            OR e.serial_num LIKE :query
        ";
        
        $stmt = $this->connect()->prepare($sql);
        $searchTerm = '%' . $query . '%';
        $stmt->bindParam(':query', $searchTerm, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
}
