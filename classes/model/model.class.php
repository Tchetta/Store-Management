<?php
class Model extends Dbh {
    // Method to add a new model
    protected function addModel($modelName, $numberOfPorts, $powerRating, $brandId, $quantity = null) {
        $sql = "INSERT INTO model (model_name, number_of_ports, power_rating, brand_id, quantity) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$modelName, $numberOfPorts, $powerRating, $brandId, $quantity]);
        return $this->connect()->lastInsertId(); // Get the inserted model ID for port linking
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

    // Decrease the quantity of a model
    public function decreaseQuantity($modelId, $decreaseBy = 1) {
        $sql = "UPDATE model SET quantity = quantity - ? WHERE model_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$decreaseBy, $modelId]);
    }

    // Increase the quantity of a model
    /* public function increaseQuantity($modelId, $increaseBy = 1) {
        $sql = "UPDATE model SET quantity = quantity + ? WHERE model_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$increaseBy, $modelId]);
    } */
}
