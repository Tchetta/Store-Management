<?php
// require_once('../includes/class_autoloader.inc.php');

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

// In CategoryCtrl class
public function getCategoriesWithQuantities($searchQuery = '', $sortOrder = 'category_asc', $storeId = null) {
    // Start with base query selecting categories (distinct)
    $query = "SELECT DISTINCT category FROM model WHERE category IS NOT NULL";
    $params = [];

    // Apply search conditions if searchQuery is provided
    if (!empty($searchQuery)) {
        $query .= " AND category LIKE :searchQuery";
        $params[':searchQuery'] = '%' . $searchQuery . '%';
    }

    // Apply sorting
    switch ($sortOrder) {
        case 'category_asc':
            $query .= " ORDER BY category ASC";
            break;
        case 'category_desc':
            $query .= " ORDER BY category DESC";
            break;
        default:
            $query .= " ORDER BY category ASC";
    }

    // Prepare and execute the query to get categories
    $stmt = $this->connect()->prepare($query);
    $stmt->execute($params);
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    

    // Process categories to calculate the total quantity in each category
    // $categoriesWithQuantities = [];
    $validCategories = [];
    foreach ($categories as &$category) {
        $categoryName = $category['category'];

        $sql2 = "SELECT * FROM product_category WHERE category_name = :cname";
        $stmt2 = $this->connect()->prepare($sql2);
        $stmt2->execute([":cname" => $categoryName]);
        $validCategory = $stmt2->fetch(PDO::FETCH_ASSOC);

        $quantity = $this->getQuantityInCategory($categoryName, $storeId);


        if ($quantity > 0) {
            $validCategory['quantity'] = $quantity;
            $validCategories[] = $validCategory;
        }

    }

    return $validCategories;
}

public function getQuantityInCategory($categoryName, $storeId) {
    // Sum the quantity of models that belong to this category in the specified store
    $query = "SELECT COUNT(*) AS total_quantity
              FROM equipment e
              JOIN model m ON e.model_id = m.model_id
              WHERE m.category = :categoryName";
    
    if ($storeId !== null) {
        $query .= " AND e.store_id = :storeId";
    }
    
    $stmt = $this->connect()->prepare($query);
    $params = [':categoryName' => $categoryName];
    if ($storeId !== null) {
        $params[':storeId'] = $storeId;
    }
    $stmt->execute($params);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['total_quantity'] ?? 0; // Default to 0 if no result
}



    // Method to update category details
    public function updateCategory($categoryId, $categoryName, $quantity) {
        $sql = "UPDATE product_category SET category_name = ?, quantity = ? WHERE category_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$categoryName, $quantity, $categoryId]);
    }

    // Method to update category details
    public function setCategoryName($categoryId, $categoryName) {
        $sql = "UPDATE product_category SET category_name = ?WHERE category_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$categoryName, $categoryId]);
    }

    // Method to delete a category by ID
    public function deleteCategory($categoryId) {
        $sql = "DELETE FROM product_category WHERE category_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$categoryId]);
    }

    // Decrease the quantity of a product category by 1
    public function decreaseQuantity($categoryId, $by) {
        $sql = "UPDATE product_category SET quantity = quantity - ? WHERE category_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$categoryId, $by]);
    }
    public function increaseQuantity($categoryId, $by) {
        $sql = "UPDATE product_category SET quantity = quantity + ? WHERE category_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$categoryId, $by]);
    }
    public function updateCategoryQuantity($categoryName) {
        // Sum the quantity of all brands belonging to this category
        $sql = "SELECT SUM(quantity) AS total_quantity FROM model WHERE category = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$categoryName]);
        $totalQuantity = $stmt->fetchColumn();

        // Update the category's quantity
        $sqlUpdate = "UPDATE product_category SET quantity = ? WHERE category_name = ?";
        $stmtUpdate = $this->connect()->prepare($sqlUpdate);
        $stmtUpdate->execute([$totalQuantity, $categoryName]);
    }
}

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

        parent::updateCategory($categoryId, $categoryName, $quantity);
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
        public function decreaseQuantity($categoryId, $by = 1) {
            // You might want to add some checks here, such as verifying if the quantity is greater than 0
           parent::decreaseQuantity($categoryId, $by = 1);
        }
        // Increase product category quantity
        public function increaseQuantity($categoryId, $by = 1) {
            // You might want to add some checks here, such as verifying if the quantity is greater than 0
           parent::increaseQuantity($categoryId, $by = 1);
        }

        
    
}

