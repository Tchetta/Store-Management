<?php

class ProductDetailsCtrl extends ProductDetails {
    // Create product
    public function createProduct($storeId, $productId, $modelId, $stateId, $description, $specification) {
        $this->addProduct($storeId, $productId, $modelId, $stateId, $description, $specification);
        // Update the quantity in related tables
        $this->updateQuantities($productId, $modelId);
    }

    // Update product
    public function updateProduct($serialNum, $storeId, $productId, $modelId, $stateId, $description, $specification) {
        $this->updateProduct($serialNum, $storeId, $productId, $modelId, $stateId, $description, $specification);
    }

    // Mark product as deleted
    public function deleteProduct($serialNum) {
        $this->deleteProduct($serialNum);
    }

    // Search for products
    /* public function searchProducts($searchTerm, $sortBy, $criteria) {
        return $this->searchProducts($searchTerm, $sortBy, $criteria);
    }
 */
    // Get products by criteria
    public function getProductsByCriteria($criteria, $value) {
        return $this->getProductsByCriteria($criteria, $value);
    }

    // Update quantities in related tables
    protected function updateQuantities($productId, $modelId) {
        // Example logic to update the quantities in model and product_category
        // This should be adapted based on your specific requirements and methods
        $modelCtrl = new ModelCtrl();
        $modelCtrl->decreaseQuantity($modelId);

        $categoryCtrl = new ProductCategoryCtrl();
        $categoryCtrl->decreaseQuantity($productId);
    }

    /* public function getAllProducts() {
        parent::getAllProducts();
    } */

    public function getAllProducts() {
        $sql = "SELECT pd.serial_num, 
                       st.store_name, 
                       pc.category_name AS product_name, 
                       m.model_name, 
                       b.brand_name, 
                       s.state_name, 
                       pd.description, 
                       pd.specification, 
                       pd.indate, 
                       pd.outdate 
                FROM productdetails pd
                JOIN stores st ON pd.store_id = st.store_id
                JOIN model m ON pd.model_id = m.model_id
                JOIN brand b ON m.brand_id = b.brand_id
                JOIN product_category pc ON b.category_id = pc.category_id
                JOIN equipment_state s ON pd.state_id = s.state_id
                WHERE pd.outdate IS NULL"; // Assuming you only want non-outdated products
        $stmt = $this->connect()->query($sql);
        return $stmt->fetchAll();
    }

    public function searchProducts($searchTerm, $sortBy, $searchCriteria) {
        $searchTerm = "%$searchTerm%"; // Use wildcards for LIKE search
        $sql = "SELECT pd.serial_num, 
                       st.store_name, 
                       pc.category_name AS product_name, 
                       m.model_name, 
                       b.brand_name, 
                       s.state_name, 
                       pd.description, 
                       pd.specification, 
                       pd.indate, 
                       pd.outdate 
                FROM productdetails pd
                JOIN store st ON pd.store_id = st.store_id
                JOIN model m ON pd.model_id = m.model_id
                JOIN brand b ON m.brand_id = b.brand_id
                JOIN product_category pc ON b.category_id = pc.category_id
                JOIN state s ON pd.state_id = s.state_id
                WHERE pd.$searchCriteria LIKE ? 
                ORDER BY $sortBy";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$searchTerm]);
        return $stmt->fetchAll();
    }
}
