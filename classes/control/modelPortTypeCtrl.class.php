

<?php
class ModelPortTypeCtrl extends Dbh {
    require_once('../includes/class_autoloader.inc.php');

    public function addPortType($modelId, $portTypeId) {
        $this->addPortTypeToModel($modelId, $portTypeId);
    }

    // Get all port types for a specific model
    public function getPortTypesByModelId($modelId) {
        return $this->getPortTypesByModelId($modelId);
    }

    // Remove a port type from a model
    public function removePortType($modelId, $portTypeId) {
        $this->removePortTypeFromModel($modelId, $portTypeId);
    }

    // Get all models with their port types
    public function getAllModelsWithPortTypes() {
        return $this->getAllModelsWithPortTypes();
    }

    // Method to link a model with multiple port types
    public function linkModelToPortTypes($modelId, $portTypeIds) {
        $sql = "INSERT INTO model_port_types (model_id, port_type_id) VALUES (?, ?)";
        $stmt = $this->connect()->prepare($sql);
        
        foreach ($portTypeIds as $portTypeId) {
            $stmt->execute([$modelId, $portTypeId]);
        }
    }

    // Method to get all port types for a given model
    public function getPortTypesForModel($modelId) {
        $sql = "SELECT pt.port_type_name FROM port_types pt 
                JOIN model_port_types mpt ON pt.port_type_id = mpt.port_type_id 
                WHERE mpt.model_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$modelId]);
        return $stmt->fetchAll();
    }

    // Method to remove all port types linked to a model
    public function unlinkAllPortTypesFromModel($modelId) {
        $sql = "DELETE FROM model_port_types WHERE model_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$modelId]);
    }
    
    // Method to update the model-port type relationship
    public function updateModelPortTypes($modelId, $newPortTypeIds) {
        // Remove existing port type links
        $this->unlinkAllPortTypesFromModel($modelId);
        
        // Add new port type links
        $this->linkModelToPortTypes($modelId, $newPortTypeIds);
    }
}

