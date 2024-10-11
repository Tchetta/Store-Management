<?php

class Brand extends Dbh {
    // Method to add a new brand with quantity and category_id
    protected function addBrand($brandName, $categoryId, $description=null) {
        $sql = "INSERT INTO brand (brand_name, description, category_id) VALUES (?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$brandName, $description, $categoryId]);
    }

    // Method to get a brand by ID
    protected function getBrandById($brandId) {
        $sql = "SELECT * FROM brand WHERE brand_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$brandId]);
        return $stmt->fetch();
    }

    // Method to get all brands
    protected function getAllBrands() {
        $sql = "SELECT * FROM brand";
        $stmt = $this->connect()->query($sql);
        return $stmt->fetchAll();
    }

    // Method to update brand details
    protected function updateBrand($brandId, $brandName, $description, $categoryId, $quantity) {
        $sql = "UPDATE brand SET brand_name = ?, description = ?, category_id = ?, quantity = ? WHERE brand_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$brandName, $description, $categoryId, $quantity, $brandId]);
    }

    /* protected function updateBrandQuantity($brandId) {
        // Sum the quantity of all brands belonging to this category
        $sql = "SELECT SUM(quantity) AS total_quantity FROM model WHERE brand_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$brandId]);
        $totalQuantity = $stmt->fetchColumn();

        // Update the category's quantity
        $sqlUpdate = "UPDATE brand SET quantity = ? WHERE brand_id = ?";
        $stmtUpdate = $this->connect()->prepare($sqlUpdate);
        $stmtUpdate->execute([$totalQuantity, $brandId]);
    } */

    // Method to delete a brand by ID
    protected function deleteBrand($brandId) {
        $sql = "DELETE FROM brand WHERE brand_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$brandId]);
    }
}

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
    
        public function getCategoryIdByBrand($brandId) {
            // Get the brand_id for the given model
            $sql = "SELECT category_id FROM brand WHERE brand_id = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$brandId]);
            return $stmt->fetchColumn();
        }
}
