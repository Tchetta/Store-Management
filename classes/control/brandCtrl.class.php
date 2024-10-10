<?php

class BrandCtrl extends Brand {
    // Create a new brand
    public function createBrand($brandName, $categoryId, $description) {
        if (empty($brandName)) {
            throw new Exception("Brand name is required.");
        }

        $this->addBrand($brandName, $description, $categoryId, $quantity);
    }

    // Update an existing brand
    public function updateBrand($brandId, $brandName, $description, $categoryId, $quantity) {
        if (empty($brandId)) {
            throw new Exception("Brand ID is required.");
        }

        $this->updateBrand($brandId, $brandName, $description, $categoryId, $quantity);
    }

    // Delete a brand
    public function deleteBrand($brandId) {
        if (empty($brandId)) {
            throw new Exception("Brand ID is required.");
        }

        $this->deleteBrand($brandId);
    }

    // Get all brands
    public function getAllBrands() {
        return parent::getAllBrands(); // Call the method from the Brand model class
    }
    

    // Get a single brand by ID
    public function getBrandById($brandId) {
        return parent::getBrandById($brandId); 
    }

    
        public function updateBrandQuantity($brandId) {
            // Sum the quantity of all models belonging to this brand
            $sql = "SELECT SUM(quantity) AS total_quantity FROM model WHERE brand_id = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$brandId]);
            $totalQuantity = $stmt->fetchColumn();
    
            // Update the brand's quantity
            $sqlUpdate = "UPDATE brand SET quantity = ? WHERE brand_id = ?";
            $stmtUpdate = $this->connect()->prepare($sqlUpdate);
            $stmtUpdate->execute([$totalQuantity, $brandId]);
        }
    
}
