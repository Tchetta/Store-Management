<?php

class ProductCategory extends Dbh {
    // Method to add a new product category
    public function addCategory($categoryName) {
        if (empty($categoryName)) {
            throw new Exception("Name is required.");
        }
        
        $sql = "INSERT INTO product_category (category_name) VALUES (?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$categoryName]);
    }

    // Method to get a category by ID
    public function getCategoryById($categoryId) {
        $sql = "SELECT * FROM product_category WHERE category_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$categoryId]);
        return $stmt->fetch();
    }

    // Method to get all categories
    public function getAllCategories() {
        $sql = "SELECT * FROM product_category";
        $stmt = $this->connect()->query($sql);
        return $stmt->fetchAll();
    }

    // Method to update category details
    public function updateCategory($categoryId, $categoryName, $quantity) {
        $sql = "UPDATE product_category SET category_name = ?, quantity = ? WHERE category_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$categoryName, $quantity, $categoryId]);
    }

    // Method to delete a category by ID
    public function deleteCategory($categoryId) {
        $sql = "DELETE FROM product_category WHERE category_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$categoryId]);
    }

    // Decrease the quantity of a product category by 1
    public function decreaseQuantity($categoryId) {
        $sql = "UPDATE product_category SET quantity = quantity - 1 WHERE category_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$categoryId]);
    }
}

