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

    // Method to delete a brand by ID
    protected function deleteBrand($brandId) {
        $sql = "DELETE FROM brand WHERE brand_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$brandId]);
    }
}
