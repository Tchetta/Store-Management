<?php
require_once('../includes/class_autoloader.inc.php');

class ModelPortType extends Dbh {
    // Method to add a port type to a model
    protected function addPortTypeToModel($modelId, $portTypeId) {
        $sql = "INSERT INTO model_port_types (model_id, port_type_id) VALUES (?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$modelId, $portTypeId]);
    }

    // Method to get all port types for a specific model
    protected function getPortTypesByModelId($modelId) {
        $sql = "SELECT pt.* FROM port_types pt
                JOIN model_port_types mpt ON pt.port_type_id = mpt.port_type_id
                WHERE mpt.model_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$modelId]);
        return $stmt->fetchAll();
    }

    // Method to remove a port type from a model
    protected function removePortTypeFromModel($modelId, $portTypeId) {
        $sql = "DELETE FROM model_port_types WHERE model_id = ? AND port_type_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$modelId, $portTypeId]);
    }

    // Method to get all models with their port types
    protected function getAllModelsWithPortTypes() {
        $sql = "SELECT m.model_id, m.model_name, pt.port_type_name
                FROM model m
                LEFT JOIN model_port_types mpt ON m.model_id = mpt.model_id
                LEFT JOIN port_types pt ON mpt.port_type_id = pt.port_type_id";
        $stmt = $this->connect()->query($sql);
        return $stmt->fetchAll();
    }
}
?>
