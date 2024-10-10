<?php

class Port extends Dbh {
    // Method to add a new port
    protected function addPort($portId, $portName) {
        $sql = "INSERT INTO port_types (port_id, port_name) VALUES (?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$portId, $portName]);
    }

    // Method to get a port by ID
    protected function getPortById($portId) {
        $sql = "SELECT * FROM port_types WHERE port_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$portId]);
        return $stmt->fetch();
    }

    // Method to get all ports
    protected function getAllPorts() {
        $sql = "SELECT * FROM port_types";
        $stmt = $this->connect()->query($sql);
        return $stmt->fetchAll();
    }

    // Method to update port name
    protected function updatePortName($portId, $portName) {
        $sql = "UPDATE port_types SET port_name = ? WHERE port_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$portName, $portId]);
    }

    // Method to delete a port by ID
    protected function deletePort($portId) {
        $sql = "DELETE FROM port_types WHERE port_id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$portId]);
    }
}
