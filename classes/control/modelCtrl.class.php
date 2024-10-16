<?php
require_once('../includes/class_autoloader.inc.php');

 class Model extends Dbh {
//     public function productExists($model_name) {
//         $stmt = $this->connect()->prepare("SELECT COUNT(*) FROM model WHERE model_name = :model_name");
//         $stmt->execute(['model_name' => $model_name]);
//         return $stmt->fetchColumn() > 0;
//     }

    // Method to add a new model
    protected function addModel($model_name, $number_of_ports, $power_rating, $brand_id, $quantity, $port_types) {
        $stmt = $this->connect()->prepare('INSERT INTO model (model_name, number_of_ports, power_rating, brand_id, quantity, port_types) 
        VALUES (?, ?, ?, ?, ?, ?);');
        if (!$stmt->execute([$model_name, $number_of_ports, $power_rating, $brand_id, $quantity, $port_types])) {
            // Handle error (e.g., log it or throw an exception)
            return false;
        }
        return true; // Model added successfully
    }

    protected function checkModel($model_name) {
        $stmt = $this->connect()->prepare('SELECT model_name FROM model WHERE model_name = ?');
        if (!$stmt->execute([$model_name])) {
            // Handle error
            return false; // Indicate failure
        }
        return $stmt->rowCount() > 0; // Returns true if model exists
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


    protected function increaseQuantity($model_name, $quantity) {
        $stmt = $this->connect()->prepare('UPDATE model SET quantity = quantity + ? WHERE model_name = ?');
        if (!$stmt->execute([$quantity, $model_name])) {
            // Handle error
            return false; // Indicate failure
        }
        return true; // Quantity increased successfully
    }

    // Public method to manage adding or updating a model
    public function manageModel($model_name, $number_of_ports, $power_rating, $brand_id, $quantity, $port_types) {
        if ($this->checkModel($model_name)) {
            // If model exists, increase the quantity
            return $this->increaseQuantity($model_name, $quantity);
        } else {
            // If model does not exist, add it
            return $this->addModel($model_name, $number_of_ports, $power_rating, $brand_id, $quantity, $port_types);
        }
    }


    
}

class ModelCtrl extends Model {
    // Create a new model
    /* public function createModel($modelId, $modelName, $numberOfPorts, $portTypes, $powerRating, $brandId, $quantity) {
        // Validate inputs if necessary
        parent::addModel($modelId, $modelName, $numberOfPorts, $portTypes, $powerRating, $brandId, $quantity);
    } */

    public function createModel($model_id, $modelName, $brandId, $powerRating, $portTypesJson, $quantity) {
        parent::addModel($model_id, $modelName, $brandId, $powerRating, $portTypesJson, $quantity);
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
      
    
}
