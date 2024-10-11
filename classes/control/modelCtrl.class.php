<?php
require_once('../includes/class_autoloader.inc.php');

class Model extends Dbh {
    // Method to add a new model
    protected function addModel($modelId, $modelName, $brandId, $numberOfPorts=null, $portTypes=null, $powerRating=null, $quantity = null) {
        $sql = "INSERT INTO model (model_id, model_name, number_of_ports, port_types, power_rating, brand_id, quantity) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$modelId, $modelName, $numberOfPorts, $portTypes, $powerRating, $brandId, $quantity]);
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
        $stmt->execute([$by, $modelId]);
    }

    // Decrease the quantity of a model by 1
    public function decreaseQuantity($modelId, $by) {
        $sql = "UPDATE model SET number_of_ports = number_of_ports - ? WHERE model_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$by, $modelId]);
    }
    // Increase the quantity of a model by 1
    public function increaseQuantity($modelId, $by) {
        $sql = "UPDATE model SET number_of_ports = number_of_ports + ? WHERE model_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$modelId, $by]);
    }
}

class ModelCtrl extends Model {
    // Create a new model
    public function createModel($modelId, $modelName, $numberOfPorts, $portTypes, $powerRating, $brandId, $quantity) {
        // Validate inputs if necessary
        parent::addModel($modelId, $modelName, $numberOfPorts, $portTypes, $powerRating, $brandId, $quantity);
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
    
        public function __construct() {
            $this->model = new Model();
        }
    
        // Other existing methods...
    
        // Decrease model quantity
        public function decreaseQuantity($modelId, $by = 1) {
            // You might want to add some checks here, such as verifying if the quantity is greater than 0
            parent::increaseQuantity($modelId);

            $brandCtrl = new BrandCtrl();
            $categoryCtrl = new productCategoryCtrl();

            $brandId = $this->getBrandIdByModel($modelId);
            $categoryId = $this->getCategoryIdByModel($modelId);

            $brandCtrl->updateBrandQuantity($brandId);
            $categoryCtrl->updateCategoryQuantity($categoryId);
        }

        public function increaseQuantity($modelId, $by = 1) {
            // You might want to add some checks here, such as verifying if the quantity is greater than 0
            parent::increaseQuantity($modelId);
            
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
