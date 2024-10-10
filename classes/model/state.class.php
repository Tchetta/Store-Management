<?php

class State extends Dbh {
    // Add a new state
    protected function addState($stateName) {
        $sql = "INSERT INTO equipment_state (state_name) VALUES (?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$stateName]);
    }

    // Get state by ID
    protected function getStateById($stateId) {
        $sql = "SELECT * FROM equipment_state WHERE state_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$stateId]);
        return $stmt->fetch();
    }

    // Get all states
    protected function getAllStates() {
        $sql = "SELECT * FROM equipment_state";
        $stmt = $this->connect()->query($sql);
        return $stmt->fetchAll();
    }

    // Update state name
    protected function updateStateName($stateId, $newStateName) {
        $sql = "UPDATE equipment_state SET state_name = ? WHERE state_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$newStateName, $stateId]);
    }

    // Delete state by ID
    protected function deleteState($stateId) {
        $sql = "DELETE FROM equipment_state WHERE state_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$stateId]);
    }
}
?>
