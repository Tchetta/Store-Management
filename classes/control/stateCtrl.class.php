<?php

class StateCtrl extends Dbh {
    public function getAllStates() {
        $sql = "SELECT * FROM equipment_state";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $states = $stmt->fetchAll();

        return $states;
    }

    public function addState($stateName) {
        $sql = "INSERT INTO equipment_state (state_name) VALUES ( :stateName )";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(":stateName", $stateName, PDO::PARAM_STR);
        $stmt->execute();
    }
} 