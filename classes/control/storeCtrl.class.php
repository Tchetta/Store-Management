<?php

class Store extends Dbh {

    // Create store
    /* protected function createStoreInModel($storeId, $storeName, $storeLocation, $manId) {
        try {
            $sql = "INSERT INTO stores (store_id, store_name, store_location, manager_id) VALUES (?, ?, ?, ?)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$storeId, $storeName, $storeLocation, $manId]);
        } catch (Exception $e) {
            throw new Exception("Error creating store: " . $e->getMessage());
        }
    } */

    protected function createStoreInModel($storeId, $storeName, $storeLocation, $manId) {
        try {
            $sql = "INSERT INTO stores (store_id, store_name, store_location, manager_id) VALUES (:storeId, :storeName, :storeLocation, :manId)";
            $stmt = $this->connect()->prepare($sql);
    
            // Use named placeholders and bind values directly via execute
            $stmt->execute([
                ':storeId' => $storeId,
                ':storeName' => $storeName,
                ':storeLocation' => $storeLocation,
                ':manId' => $manId
            ]);
        } catch (Exception $e) {
            throw new Exception("Error creating store: " . $e->getMessage());
        }
    }
    

    // Update store
    public function updateStore($storeId, $data) {
        $setPart = [];
        $params = [];

        foreach ($data as $key => $value) {
            if ($value !== null) {
                $setPart[] = "$key = ?";
                $params[] = $value;
            }
        }

        if (!empty($setPart)) {
            $setQuery = implode(", ", $setPart);
            $sql = "UPDATE stores SET $setQuery WHERE store_id = ?";
            $params[] = $storeId;

            $stmt = $this->connect()->prepare($sql);
            $stmt->execute($params);
        }
    }

    // Delete store
    public function deleteStore($storeId) {
        $sql = "DELETE FROM stores WHERE store_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$storeId]);
    }

    // Get all stores
    public function getAllStores() {
        $sql = "SELECT * FROM stores";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Get store by ID
    public function getStoreById($storeId) {
        $sql = "SELECT * FROM stores WHERE store_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$storeId]);
        return $stmt->fetch();
    }
    // Get store by ID
    public function getStoreByManagerId($manId) {
        $sql = "SELECT store_id FROM stores WHERE manager_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$manId]);
        return $stmt->fetchColumn();
    }

    public function getStoresByPage($start, $limit) {
        $sql = "SELECT * FROM stores LIMIT ?, ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bind_param("ii", $start, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
}

class StoreCtrl extends Store {

    // Create store
    public function createStore($storeId, $storeName, $storeLocation, $manId) {
        // Validate required inputs
        if (empty($storeId) || empty($storeName)) {
            throw new Exception("Store ID and Store Name are required.");
        }

        // Call the parent method to create the store in the database
        parent::createStoreInModel($storeId, $storeName, $storeLocation, $manId);
    }

    // Update store information
    public function updateStore($storeId, $newData) {
        if (empty($storeId)) {
            throw new Exception("Store ID is required for updating.");
        }
        parent::updateStore($storeId, $newData);
    }

    // Delete store by ID
    public function deleteStore($storeId) {
        if (empty($storeId)) {
            throw new Exception("Store ID is required.");
        }
        parent::deleteStore($storeId);
    }

    // Fetch all stores
    public function getAllStores() {
        return parent::getAllStores();
    }

    public function getStoresByPage($start, $limit) {
        // Safely inject integers into the SQL query (no placeholders for LIMIT)
        $sql = "SELECT * FROM stores LIMIT $start, $limit";
        $stmt = $this->connect()->prepare($sql);
    
        // Execute the statement
        $stmt->execute();
    
        // Fetch the results
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    public function getManagerId($storeId) {
        try {
            // Prepare the SQL statement
            $sql = "SELECT manager_id FROM stores WHERE store_id = :storeId LIMIT 1";
            $stmt = $this->connect()->prepare($sql);
    
            // Bind the parameter using the execute method
            $stmt->execute([':storeId' => $storeId]);
    
            // Fetch the result
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Check if a manager was found and return the manager_id
            if ($result) {
                return $result['manager_id'];
            } else {
                return null;  // Return null if no manager found
            }
        } catch (Exception $e) {
            throw new Exception("Error fetching manager ID: " . $e->getMessage());
        }
    }
    
}
