<?php
require_once('../includes/class_autoloader.inc.php');

class ModelPortTypeCtrl extends ModelPortType {
    // Add a port type to a model
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
}
?>
