<?php

class Model extends Dbh {
    // Method to add a new model
    protected function addModel($modelId, $modelName, $numberOfPorts, $portTypes, $powerRating, $brandId, $quantity = null) {
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
        $stmt->execute([$modelId]);
    }

    // Decrease the quantity of a model by 1
    public function decreaseQuantity($modelId) {
        $sql = "UPDATE model SET number_of_ports = number_of_ports - 1 WHERE model_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$modelId]);
    }
}
