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
