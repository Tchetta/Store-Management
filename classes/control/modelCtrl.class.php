<?php
require_once('../includes/class_autoloader.inc.php');

class Model extends Dbh {
    // public function productExists($model_name) {
    //     $stmt = $this->connect()->prepare("SELECT COUNT(*) FROM model WHERE model_name = :model_name");
    //     $stmt->execute(['model_name' => $model_name]);
    //     return $stmt->fetchColumn() > 0;
    // }

    // Method to add a new model
    protected function addModel($modelName, $brandId, $powerRating, $portTypesJson, $quantity = null, $imagePath = 'uploads/model_img/default.png') {
    $sql = "INSERT INTO model (model_name, brand_id, power_rating, port_types, quantity, image_path) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$modelName, $brandId, $powerRating, $portTypesJson, $quantity, $imagePath]);
}


    // Method to get a model by ID
    protected function getModelById($modelId) {
        $sql = "SELECT * FROM model WHERE model_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$modelId]);
        return $stmt->fetch();
    }

    // Method to get all models
    protected function getAllModels() {
        $sql = "SELECT * FROM model";
        $stmt = $this->connect()->query($sql);
        return $stmt->fetchAll();
    }

    // Method to update model details
    protected function updateModel($modelId, $modelName, $numberOfPorts, $portTypes, $powerRating, $brandId, $quantity) {
        $sql = "UPDATE model SET model_name = ?, number_of_ports = ?, port_types = ?, power_rating = ?, brand_id = ?, quantity = ? WHERE model_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$modelName, $numberOfPorts, $portTypes, $powerRating, $brandId, $quantity, $modelId]);
    }

    // Method to delete a model by ID
    protected function deleteModel($modelId) {
        $sql = "DELETE FROM model WHERE model_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$modelId]);
    }

        // Subtract the quantity from the existing quantity

    public function decreaseQuantity($model_name, $quantity){
        $stmt = $this->connect()->prepare("UPDATE model SET quantity = quantity - :quantity WHERE model_name = :model_name");
        $stmt->execute(['quantity' => $quantity, 'model_name' => $model_name]);
    }


    public function increaseQuantity($model_name, $quantity) {
        $stmt = $this->connect()->prepare("UPDATE model SET quantity = quantity + :quantity WHERE model_name = :model_name");
        $stmt->execute(['quantity' => $quantity, 'model_name' => $model_name]);
    }

    
}

class ModelCtrl extends Model {
    // Create a new model
    /* public function createModel($modelId, $modelName, $numberOfPorts, $portTypes, $powerRating, $brandId, $quantity) {
        // Validate inputs if necessary
        parent::addModel($modelId, $modelName, $numberOfPorts, $portTypes, $powerRating, $brandId, $quantity);
    } */

    public function createModel($modelName, $brandId, $powerRating, $portTypesJson, $quantity, $image_path) {
        parent::addModel($modelName, $brandId, $powerRating, $portTypesJson, $quantity, $image_path);
    }

    // Get all models
    public function getAllModels() {
        return parent::getAllModels();
    }

    // Get model by ID
    public function getModelById($modelId) {
        return parent::getModelById($modelId);
    }

    // Update a model
    public function updateModel($modelId, $modelName, $numberOfPorts, $portTypes, $powerRating, $brandId, $quantity) {
        parent::updateModel($modelId, $modelName, $numberOfPorts, $portTypes, $powerRating, $brandId, $quantity);
    }

    // Delete a model
    public function deleteModel($modelId) {
        parent::deleteModel($modelId);
    }
    
    
        // Other existing methods...
    
        // Decrease model quantity
        public function decreaseQuantity($model_name, $quantity) {
            // You might want to add some checks here, such as verifying if the quantity is greater than 0
            parent::decreaseQuantity($model_name, $quantity);

            $brandCtrl = new BrandCtrl();
            $categoryCtrl = new productCategoryCtrl();

            $brandId = $this->getBrandIdByModel($model_name);
            $categoryId = $this->getCategoryIdByModel($model_name);

            $brandCtrl->updateBrandQuantity($brandId);
            $categoryCtrl->updateCategoryQuantity($categoryId);
        }

        public function increaseQuantity($model_name, $quantity) {
            // You might want to add some checks here, such as verifying if the quantity is greater than 0
            parent::increaseQuantity($model_name, $quantity);
            
        }
    
        public function getBrandIdByModel($modelId) {
            // Get the brand_id for the given model
            $sql = "SELECT brand_id FROM model WHERE model_id = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$modelId]);
            return $stmt->fetchColumn();
        }

        public function getCategoryIdByModel($modelId) {
            // Get the brand_id for the given model
            $brandId = $this->getBrandIdByModel($modelId);
            $brand = new BrandCtrl();
            return $brand->getCategoryIdByBrand($brandId);
        }
      
        public function getModelsByPage($start, $limit) {
            $sql = "SELECT * FROM model LIMIT :start, :limit"; // Adjust table name as necessary
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindValue(':start', $start, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        public function updateImagePath($modelId, $imagePath) {
            $sql = "UPDATE models SET image_path = :image_path WHERE model_id = :model_id"; // Adjust table name as necessary
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindValue(':image_path', $imagePath, PDO::PARAM_STR);
            $stmt->bindValue(':model_id', $modelId, PDO::PARAM_INT);
            return $stmt->execute(); // Returns true on success
        }
        
    
}
