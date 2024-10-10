<?php

class ProductDetails extends Dbh {
    // Add a new product
    protected function addProduct($storeId, $productId, $modelId, $stateId, $description, $specification) {
        $sql = "INSERT INTO productdetails (store_id, product_id, model_id, state_id, description, specification) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$storeId, $productId, $modelId, $stateId, $description, $specification]);
    }

    // Update product details
    protected function updateProduct($serialNum, $storeId, $productId, $modelId, $stateId, $description, $specification) {
        $sql = "UPDATE productdetails SET store_id = ?, product_id = ?, model_id = ?, 
                state_id = ?, description = ?, specification = ? 
                WHERE serial_num = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$storeId, $productId, $modelId, $stateId, $description, $specification, $serialNum]);
    }

    // Delete product by marking as outdated
    protected function deleteProduct($serialNum) {
        $sql = "UPDATE productdetails SET outdate = CURRENT_TIMESTAMP WHERE serial_num = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$serialNum]);
    }

    // Get all products (considering not outdated)
    protected function getAllProducts() {
        $sql = "SELECT * FROM productdetails WHERE outdate IS NULL";
        $stmt = $this->connect()->query($sql);
        return $stmt->fetchAll();
    }

    // Get product by serial number
    protected function getProductById($serialNum) {
        $sql = "SELECT * FROM productdetails WHERE serial_num = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$serialNum]);
        return $stmt->fetch();
    }

    /* // Search products
    protected function searchProducts($searchTerm, $sortBy) {
        $sql = "SELECT * FROM productdetails WHERE (description LIKE ? OR specification LIKE ?) AND outdate IS NULL 
                ORDER BY $sortBy";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(["%$searchTerm%", "%$searchTerm%"]);
        return $stmt->fetchAll();
    } */

    // Get products by specific criteria (dynamic sorting and filtering)
    protected function getProductsByCriteria($criteria, $value) {
        $sql = "SELECT * FROM productdetails WHERE $criteria = ? AND outdate IS NULL";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$value]);
        return $stmt->fetchAll();
    }

    // Updated search method
protected function searchProducts($searchTerm, $sortBy, $searchCriteria) {
    $column = $searchCriteria === 'description' ? 'description' : 'specification';
    $sql = "SELECT * FROM productdetails WHERE ($column LIKE ?) AND outdate IS NULL ORDER BY $sortBy";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(["%$searchTerm%"]);
    return $stmt->fetchAll();
}

}
