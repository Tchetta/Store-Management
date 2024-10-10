<?php
require_once('../includes/class_autoloader.inc.php');

class ProductCategoryCtrl extends ProductCategory {

    // Create a new category
    public function createCategory($categoryName) {
        if (empty($categoryName)) {
            throw new Exception("Name is required.");
        }

        $this->addCategory($categoryName);
    }

    // Update existing category
    public function updateCategory($categoryId, $categoryName, $quantity) {
        if (empty($categoryId)) {
            throw new Exception("Category ID is required.");
        }

        $this->updateCategory($categoryId, $categoryName, $quantity);
    }

    // Delete a category by ID
    public function deleteCategory($categoryId) {
        if (empty($categoryId)) {
            throw new Exception("Category ID is required.");
        }

        $this->deleteCategory($categoryId);
    }
    
        // Other existing methods...
    
        // Decrease product category quantity
        public function decreaseQuantity($categoryId) {
            // You might want to add some checks here, such as verifying if the quantity is greater than 0
           parent::decreaseQuantity($categoryId);
        }

        public function updateCategoryQuantity($categoryId) {
            // Sum the quantity of all brands belonging to this category
            $sql = "SELECT SUM(quantity) AS total_quantity FROM brand WHERE category_id = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$categoryId]);
            $totalQuantity = $stmt->fetchColumn();
    
            // Update the category's quantity
            $sqlUpdate = "UPDATE product_category SET quantity = ? WHERE category_id = ?";
            $stmtUpdate = $this->connect()->prepare($sqlUpdate);
            $stmtUpdate->execute([$totalQuantity, $categoryId]);
        }
    
}

