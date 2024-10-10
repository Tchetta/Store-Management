<?php
require_once('../includes/class_autoloader.inc.php');

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
        public function decreaseQuantity($modelId) {
            // You might want to add some checks here, such as verifying if the quantity is greater than 0
            $this->model->decreaseQuantity($modelId);
        }

        public function increaseQuantity($modelId, $quantity) {
            // Increment the quantity of the model by the input quantity
            $sql = "UPDATE model SET quantity = quantity + ? WHERE model_id = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$quantity, $modelId]);
        }
    
        public function getBrandIdByModel($modelId) {
            // Get the brand_id for the given model
            $sql = "SELECT brand_id FROM model WHERE model_id = ?";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$modelId]);
            return $stmt->fetchColumn();
        }
    
}
