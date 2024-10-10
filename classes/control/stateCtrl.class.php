<?php
require_once('../includes/class_autoloader.inc.php');

class StateCtrl extends State {
    // Create a new state
    public function createState($stateName) {
        parent::addState($stateName);
    }

    // Get all states
    public function getAllStates() {
        return parent::getAllStates();
    }

    // Get state by ID
    public function getStateById($stateId) {
        return parent::getStateById($stateId);
    }

    // Update state
    public function updateState($stateId, $newStateName) {
        parent::updateStateName($stateId, $newStateName);
    }

    // Delete a state
    public function deleteState($stateId) {
        parent::deleteState($stateId);
    }
}
?>
