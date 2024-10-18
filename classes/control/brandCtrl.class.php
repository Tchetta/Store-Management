<?php

class Brand extends Dbh {
    // Method to add a new brand with name and description (categoryId removed)
    protected function addBrand($brandName, $description = null) {
        $sql = "INSERT INTO brand (brand_name, description) VALUES (?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$brandName, $description]);
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

    // Method to update brand name
    protected function updateBrandName($brandId, $brandName) {
        $sql = "UPDATE brand SET brand_name = ? WHERE brand_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$brandName, $brandId]);
    }

    // Method to update brand description
    protected function updateBrandDescription($brandId, $description) {
        $sql = "UPDATE brand SET description = ? WHERE brand_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$description, $brandId]);
    }

    // Method to update brand quantity
    public function updateBrandQuantity($brandName) {
        // Sum the quantity of all brands belonging to this category
        $sql = "SELECT SUM(quantity) AS total_quantity FROM model WHERE brand = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$brandName]);
        $totalQuantity = $stmt->fetchColumn();

        // Update the category's quantity
        $sqlUpdate = "UPDATE brand SET quantity = ? WHERE brand_name = ?";
        $stmtUpdate = $this->connect()->prepare($sqlUpdate);
        $stmtUpdate->execute([$totalQuantity, $brandName]);
    }

    // Method to delete a brand by ID
    protected function deleteBrand($brandId) {
        $sql = "DELETE FROM brand WHERE brand_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$brandId]);
    }
}

class BrandCtrl extends Brand {
    // Create a new brand
    public function createBrand($brandName, $description) {
        if (empty($brandName)) {
            throw new Exception("Brand name is required.");
        }

        $this->addBrand($brandName, $description);
    }

    // Update brand name
    public function setBrandName($brandId, $brandName) {
        if (empty($brandId)) {
            throw new Exception("Brand ID is required.");
        }
        if (empty($brandName)) {
            throw new Exception("Brand name is required.");
        }

        $this->updateBrandName($brandId, $brandName);
    }

    // Update brand description
    public function setBrandDescription($brandId, $description) {
        if (empty($brandId)) {
            throw new Exception("Brand ID is required.");
        }

        $this->updateBrandDescription($brandId, $description);
    }

    // Update brand quantity
    public function setBrandQuantity($brandId, $quantity) {
        if (empty($brandId)) {
            throw new Exception("Brand ID is required.");
        }

        $this->updateBrandQuantity($brandId, $quantity);
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

    // Update the quantity of a brand based on models associated with it
    public function updateBrandQuantityFromModels($brandId) {
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
