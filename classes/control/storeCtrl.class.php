<?php

class Store extends Dbh {

    // Create store
    protected function createStoreInModel($storeId, $storeName, $storeLocation) {
        try {
            $sql = "INSERT INTO stores (store_id, store_name, store_location) VALUES (?, ?, ?)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$storeId, $storeName, $storeLocation]);
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
}

class StoreCtrl extends Store {

    // Create store
    public function createStore($storeId, $storeName, $storeLocation) {
        // Validate required inputs
        if (empty($storeId) || empty($storeName)) {
            throw new Exception("Store ID and Store Name are required.");
        }

        // Call the parent method to create the store in the database
        parent::createStoreInModel($storeId, $storeName, $storeLocation);
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
}
