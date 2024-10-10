<?php

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
