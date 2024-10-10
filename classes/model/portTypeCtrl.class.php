<?php
class PortTypeCtrl extends Dbh {
    // Fetch all port types and the models associated with each port type
    public function getAllPortTypesWithModels() {
        $sql = "SELECT pt.port_type_name, m.model_name 
                FROM port_types pt
                LEFT JOIN model_port_types mpt ON pt.port_type_id = mpt.port_type_id
                LEFT JOIN model m ON mpt.model_id = m.model_id";
        $stmt = $this->connect()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC);
    }
}
