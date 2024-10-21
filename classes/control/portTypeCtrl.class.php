<?php

class PortTypeCtrl extends Dbh {
    protected $conn;

    public function __construct() {
        // Assuming you have a database connection set up
        $this->conn = $this->connect();
    }

    public function getAllPortTypes() {
        $stmt = $this->conn->query("SELECT port_type_id, port_type_name FROM port_types");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPortName($portTypeId) {
        $stmt = $this->conn->query("SELECT port_type_name FROM port_types WHERE port_type_id = {$portTypeId}");
        $port = $stmt->fetchColumn();
        return $port;
    }

}
