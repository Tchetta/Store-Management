<?php
require_once('../includes/class_autoloader.inc.php');

class Model extends Dbh {
    // Add a new model
    public function createModel($modelName, $brand, $numPorts, $portTypes = '', $category, $specification = '', $description = '', $imagePath = 'default.png') {
        $sql = "INSERT INTO model (model_name, brand, number_of_ports, port_types, category, specification, description, image_path) 
                VALUES (:model_name, :brand, :number_of_ports, :port_types, :category, :specification, :description, :image_path)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([
            'model_name' => $modelName,
            'brand' => $brand,
            'port_types' => $portTypes,
            'category' => $category,
            'specification' => $specification,
            'description' => $description,
            'image_path' => $imagePath,
            'number_of_ports' => $numPorts
        ]);
    }

    // Get a model by ID
    protected function getModelById($modelId) {
        $sql = "SELECT * FROM model WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['model_id' => $modelId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get all models
    protected function getAllModels() {
        $sql = "SELECT * FROM model";
        $stmt = $this->connect()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllModelsWithQuantity() {
        $sql = "SELECT * FROM model WHERE quantity > 0";
        $stmt = $this->connect()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getModelsInStoreWithQuantity($storeId) {
        $sql = "
            SELECT m.*
            FROM model m
            INNER JOIN equipment e ON m.model_id = e.model_id
            WHERE e.store_id = :storeId
            GROUP BY m.model_id
            HAVING COUNT(e.model_id) > 0
        ";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':storeId', $storeId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Getters for each column
    protected function getModelName($modelId) {
        $sql = "SELECT model_name FROM model WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['model_id' => $modelId]);
        return $stmt->fetchColumn();
    }

    protected function getNumberOfPorts($modelId) {
        $sql = "SELECT number_of_ports FROM model WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['model_id' => $modelId]);
        return $stmt->fetchColumn();
    }

    protected function getPortTypes($modelId) {
        $sql = "SELECT port_types FROM model WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['model_id' => $modelId]);
        return $stmt->fetchColumn();
    }

    protected function getPowerRating($modelId) {
        $sql = "SELECT power_rating FROM model WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['model_id' => $modelId]);
        return $stmt->fetchColumn();
    }

    protected function getBrand($modelId) {
        $sql = "SELECT brand FROM model WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['model_id' => $modelId]);
        return $stmt->fetchColumn();
    }

    protected function getQuantity($modelId) {
        $sql = "SELECT quantity FROM model WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['model_id' => $modelId]);
        return $stmt->fetchColumn();
    }

    public function getQuantityByStore($modelId, $storeId = null) {
        $sql = "
            SELECT COUNT(*) as quantity 
            FROM equipment 
            WHERE model_id = :model_id 
        ";
        // Add `store_id` condition only if `$storeId` is non-empty and not null
        if (!empty($storeId)) {
            $sql .= " AND store_id = :store_id";
        }
        
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':model_id', $modelId, PDO::PARAM_INT);
    
        // Bind `store_id` only if it has a valid value
        if (!empty($storeId)) {
            $stmt->bindParam(':store_id', $storeId, PDO::PARAM_STR);
        }
    
        $stmt->execute();
        return $stmt->fetchColumn();
    }          

    protected function getCategory($modelId) {
        $sql = "SELECT category FROM model WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['model_id' => $modelId]);
        return $stmt->fetchColumn();
    }

    protected function getSpecification($modelId) {
        $sql = "SELECT specification FROM model WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['model_id' => $modelId]);
        return $stmt->fetchColumn();
    }

    protected function getDescription($modelId) {
        $sql = "SELECT description FROM model WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['model_id' => $modelId]);
        return $stmt->fetchColumn();
    }

    protected function getInputCurrent($modelId) {
        $sql = "SELECT input_current FROM model WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['model_id' => $modelId]);
        return $stmt->fetchColumn();
    }

    protected function getInputVoltage($modelId) {
        $sql = "SELECT input_voltage FROM model WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['model_id' => $modelId]);
        return $stmt->fetchColumn();
    }

    protected function getImagePath($modelId) {
        $sql = "SELECT image_path FROM model WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['model_id' => $modelId]);
        return $stmt->fetchColumn();
    }

    // Setters for each column
    protected function setModelName($modelId, $modelName) {
        $sql = "UPDATE model SET model_name = :model_name WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['model_name' => $modelName, 'model_id' => $modelId]);
    }

    protected function setNumberOfPorts($modelId, $numberOfPorts) {
        $sql = "UPDATE model SET number_of_ports = :number_of_ports WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['number_of_ports' => $numberOfPorts, 'model_id' => $modelId]);
    }

    protected function setPortTypes($modelId, $portTypes) {
        $sql = "UPDATE model SET port_types = :port_types WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['port_types' => $portTypes, 'model_id' => $modelId]);
    }

    protected function setPowerRating($modelId, $powerRating) {
        $sql = "UPDATE model SET power_rating = :power_rating WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['power_rating' => $powerRating, 'model_id' => $modelId]);
    }

    protected function setBrand($modelId, $brand) {
        $sql = "UPDATE model SET brand = :brand WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['brand' => $brand, 'model_id' => $modelId]);
    }

    protected function setQuantity($modelId, $quantity) {
        $sql = "UPDATE model SET quantity = :quantity WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['quantity' => $quantity, 'model_id' => $modelId]);
    }

    protected function setCategory($modelId, $category) {
        $sql = "UPDATE model SET category = :category WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['category' => $category, 'model_id' => $modelId]);
    }

    protected function setSpecification($modelId, $specification) {
        $sql = "UPDATE model SET specification = :specification WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['specification' => $specification, 'model_id' => $modelId]);
    }

    protected function setDescription($modelId, $description) {
        $sql = "UPDATE model SET description = :description WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['description' => $description, 'model_id' => $modelId]);
    }

    protected function setInputCurrent($modelId, $inputCurrent) {
        $sql = "UPDATE model SET input_current = :input_current WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['input_current' => $inputCurrent, 'model_id' => $modelId]);
    }

    protected function setInputVoltage($modelId, $inputVoltage) {
        $sql = "UPDATE model SET input_voltage = :input_voltage WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['input_voltage' => $inputVoltage, 'model_id' => $modelId]);
    }

    protected function setImagePath($modelId, $imagePath) {
        $sql = "UPDATE model SET image_path = :image_path WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['image_path' => $imagePath, 'model_id' => $modelId]);
    }

    // Delete a model by ID
    protected function deleteModel($modelId) {
        $sql = "DELETE FROM model WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['model_id' => $modelId]);
    }

    


    // Decrease model quantity
    protected function decreaseQuantity($modelId, $quantity) {
        $sql = "UPDATE model SET quantity = quantity - :quantity WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['quantity' => $quantity, 'model_id' => $modelId]);
    }

    // Increase model quantity
    protected function increaseQuantity($modelId, $quantity) {
        $sql = "UPDATE model SET quantity = quantity + :quantity WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['quantity' => $quantity, 'model_id' => $modelId]);
    }
}

class ModelCtrl extends Model {
    // Create a new model
    public function createModel($modelName, $brand, $numPorts, $portTypes = '', $category, $specification = '', $description = '', $imagePath = 'default.png') {
        // Validate inputs if necessary
        parent::createModel($modelName, $brand, $numPorts, $portTypes, $category, $specification, $description, $imagePath);
    }

    public function getQuantityInStore($modelId, $storeId) {
        $query = "SELECT COUNT(*) AS quantity 
                  FROM equipment 
                  WHERE model_id = :modelId AND store_id = :storeId";
        $stmt = $this->connect()->prepare($query);
        $stmt->execute([
            ':modelId' => $modelId,
            ':storeId' => $storeId
        ]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $result['quantity'] ?? 0; // Default to 0 if no result
    }
    

    public function getFilteredModelsInStoreWithQuantity($searchQuery = '', $searchField = 'all', $sortOrder = 'id_asc', $storeId = null) {
        // Start with base query selecting models
        $query = "SELECT * FROM model WHERE quantity > 0";
        $params = [];
    
        // Apply search conditions
        if (!empty($searchQuery)) {
            switch ($searchField) {
                case 'model':
                    $query .= " AND model_name LIKE :searchQuery";
                    break;
                case 'brand':
                    $query .= " AND brand LIKE :searchQuery";
                    break;
                case 'category':
                    $query .= " AND category LIKE :searchQuery";
                    break;
                default: // 'all' or unspecified field
                    $query .= " AND (model_name LIKE :searchQuery 
                                OR brand LIKE :searchQuery 
                                OR category LIKE :searchQuery)";
            }
            $params[':searchQuery'] = '%' . $searchQuery . '%';
        }
    
        // Apply sorting
        switch ($sortOrder) {
            case 'name_asc':
                $query .= " ORDER BY model_name ASC";
                break;
            case 'name_desc':
                $query .= " ORDER BY model_name DESC";
                break;
            case 'category':
                $query .= " ORDER BY category ASC";
                break;
            case 'brand':
                $query .= " ORDER BY brand ASC";
                break;
            default: // id_asc
                $query .= " ORDER BY model_id ASC";
        }
    
        // Prepare and execute main query to get all filtered models
        $stmt = $this->connect()->prepare($query);
        $stmt->execute($params);
        $models = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Process models to set the correct quantity for each
        $filteredModels = [];
        foreach ($models as &$model) {
            if ($storeId && $storeId !== '') {
                // Use equipment count in the specified store
                $model['quantity'] = $this->getQuantityInStore($model['model_id'], $storeId);
            }
            
            // Only add models with a quantity greater than zero to the filtered list
            if ($model['quantity'] > 0) {
                $filteredModels[] = $model;
            }
        }

        return $filteredModels;

    }
    
    

    // Get all models
    public function getAllModels() {
        return parent::getAllModels();
    }

    // Get model by ID
    public function getModelById($modelId) {
        return parent::getModelById($modelId);
    }

        // Getters
        public function getModelName($modelId) {
            return parent::getModelName($modelId);
        }
    
        public function getNumberOfPorts($modelId) {
            return parent::getNumberOfPorts($modelId);
        }
    
        public function getPortTypes($modelId) {
            return parent::getPortTypes($modelId);
        }
    
        public function getPowerRating($modelId) {
            return parent::getPowerRating($modelId);
        }
    
        public function getBrand($modelId) {
            return parent::getBrand($modelId);
        }
    
        public function getQuantity($modelId) {
            return parent::getQuantity($modelId);
        }
    
        public function getCategory($modelId) {
            return parent::getCategory($modelId);
        }
    
        public function getSpecification($modelId) {
            return parent::getSpecification($modelId);
        }
    
        public function getDescription($modelId) {
            return parent::getDescription($modelId);
        }
    
        public function getInputCurrent($modelId) {
            return parent::getInputCurrent($modelId);
        }
    
        public function getInputVoltage($modelId) {
            return parent::getInputVoltage($modelId);
        }

        public function getImagePath($modelId) {
            return parent::getImagePath($modelId);
        }
    
        // Setters
        public function setModelName($modelId, $modelName) {
            parent::setModelName($modelId, $modelName);
        }
    
        public function setNumberOfPorts($modelId, $numberOfPorts) {
            parent::setNumberOfPorts($modelId, $numberOfPorts);
        }
    
        public function setPortTypes($modelId, $portTypes) {
            parent::setPortTypes($modelId, $portTypes);
        }
    
        public function setPowerRating($modelId, $powerRating) {
            parent::setPowerRating($modelId, $powerRating);
        }
    
        public function setBrand($modelId, $brand) {
            parent::setBrand($modelId, $brand);
        }
    
        public function setQuantity($modelId, $quantity) {
            parent::setQuantity($modelId, $quantity);
        }
    
        public function setCategory($modelId, $category) {
            parent::setCategory($modelId, $category);
        }
    
        public function setSpecification($modelId, $specification) {
            parent::setSpecification($modelId, $specification);
        }
    
        public function setDescription($modelId, $description) {
            parent::setDescription($modelId, $description);
        }
    
        public function setInputCurrent($modelId, $inputCurrent) {
            parent::setInputCurrent($modelId, $inputCurrent);
        }
    
        public function setInputVoltage($modelId, $inputVoltage) {
            parent::setInputVoltage($modelId, $inputVoltage);
        }
    
        public function setImagePath($modelId, $imagePath) {
            parent::setImagePath($modelId, $imagePath);
        }
    
    // Delete a model
    public function deleteModel($modelId) {
        parent::deleteModel($modelId);
    }

    // Decrease model quantity and update brand and category quantities
    public function decreaseQuantity($modelId, $quantity) {
        parent::decreaseQuantity($modelId, $quantity);

        $brandCtrl = new BrandCtrl();
        $categoryCtrl = new ProductCategoryCtrl();

        $brand = $this->getBrandByModel($modelId);
        $category = $this->getCategoryByModel($modelId);

        $brandCtrl->updateBrandQuantity($brand);
        $categoryCtrl->updateCategoryQuantity($category);
    }

    // Increase model quantity
    public function increaseQuantity($modelId, $quantity) {
        parent::increaseQuantity($modelId, $quantity);

        $brandCtrl = new BrandCtrl();
        $categoryCtrl = new ProductCategoryCtrl();

        $brand = $this->getBrandByModel($modelId);
        $category = $this->getCategoryByModel($modelId);

        $brandCtrl->updateBrandQuantity($brand);
        $categoryCtrl->updateCategoryQuantity($category);
    }

    // Method to update model quantity
    public function updateModelQuantity($modelId) {
        // Count the number of rows in the equipment table with the given model_id
        $sql = "SELECT COUNT(*) AS total_count FROM equipment WHERE model_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$modelId]); // Use $modelId instead of $model_id
        $count = $stmt->fetchColumn();
        
        // Update the quantity in the model table
        $sql_update = "UPDATE model SET quantity = ? WHERE model_id = ?";
        $stmt = $this->connect()->prepare($sql_update);
        $stmt->execute([$count, $modelId]); // Use $modelId instead of $model_id

        $brandCtrl = new BrandCtrl();
        $categoryCtrl = new ProductCategoryCtrl();

        $brand = $this->getBrandByModel($modelId);
        $category = $this->getCategoryByModel($modelId);

        $brandCtrl->updateBrandQuantity($brand);
        $categoryCtrl->updateCategoryQuantity($category);
    }

    // Get the brand ID associated with a model
    public function getBrandByModel($modelId) {
        $sql = "SELECT brand FROM model WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['model_id' => $modelId]);
        return $stmt->fetchColumn();
    }
    public function getCategoryByModel($modelId) {
        $sql = "SELECT category FROM model WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['model_id' => $modelId]);
        return $stmt->fetchColumn();
    }

    // Paginate models
    public function getModelsByPage($start, $limit) {
        $sql = "SELECT * FROM model LIMIT :start, :limit";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindValue(':start', $start, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update image path for a model
    public function updateImagePath($modelId, $imagePath) {
        $sql = "UPDATE model SET image_path = :image_path WHERE model_id = :model_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindValue(':image_path', $imagePath, PDO::PARAM_STR);
        $stmt->bindValue(':model_id', $modelId, PDO::PARAM_INT);
        return $stmt->execute();
    }


    // Get the total number of models for pagination
    public function getTotalModelsCount() {
        $sql = "SELECT COUNT(*) FROM model";
        $stmt = $this->connect()->query($sql);
        return $stmt->fetchColumn();
    }

    // Search models by name
    public function searchModelsByName($searchTerm) {
        $sql = "SELECT * FROM model WHERE model_name LIKE :searchTerm";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['searchTerm' => '%' . $searchTerm . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // In ModelCtrl class
public function getModelsByBrand($brandId) {
    $sql = "SELECT * FROM model WHERE brand = :brand_id";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['brand_id' => $brandId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getModelsByCategory($categoryId) {
    $sql = "SELECT * FROM model WHERE category = :category_id";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['category_id' => $categoryId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// In ModelCtrl class
/* public function getModelsByBrandOrCategory($brand = null, $category = null) {
    $sql = "SELECT * FROM model WHERE (:brand IS NULL OR brand = :brand) 
                                  AND (:category IS NULL OR category = :category)";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute(['brand' => $brand, 'category' => $category]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
} */
    public function getModelsByBrandOrCategory($brand, $category) {
        $sql = "SELECT * FROM model WHERE ";
        $params = [];
        
        if (!empty($brand)) {
            $sql .= "brand = :brand ";
            $params[':brand'] = $brand;
        }
        
        if (!empty($category)) {
            if (!empty($brand)) {
                $sql .= "OR ";
            }
            $sql .= "category = :category ";
            $params[':category'] = $category;
        }
        
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function addNewModel($modelName, $brand = null, $category = null) {
        try {
            // Prepare the SQL statement to insert the new model
            $sql = "INSERT INTO model (model_name, brand, category) VALUES (:model_name, :brand, :category)";
            $stmt = $this->connect()->prepare($sql);
            
            // Bind parameters
            $stmt->bindParam(':model_name', $modelName);
            $stmt->bindValue(':brand', $brand ?? null, PDO::PARAM_NULL);
            $stmt->bindValue(':category', $category ?? null, PDO::PARAM_NULL);
            
            // Execute the statement
            if ($stmt->execute()) {
                // Log the lastInsertId to ensure it's correct
                $modelId = $this->connect()->lastInsertId();
                error_log("New model ID: " . $modelId);  // Debugging line
                
                return $modelId;
            } else {
                throw new Exception("Failed to execute the insert query.");
            }
        } catch (PDOException $e) {
            // Optional: log the error message for debugging purposes
            error_log($e->getMessage());
            throw new Exception("Failed to add new model: " . $e->getMessage());
        }
    }
    
    

    public function getModelIdByName($modelName) {
        $sql = "SELECT model_id FROM model WHERE model_name = :model_name";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':model_name', $modelName);
        $stmt->execute();
    
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['model_id'] : false;
    }    
    

}
