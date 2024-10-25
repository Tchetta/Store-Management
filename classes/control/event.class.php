<?php
require_once './class_autoloader.inc.php';

class Event extends Dbh
{
    public function additionEvent($model, $qty, $optype, $sn = '') {
        $sql = "INSERT INTO events (model_id, quantity, operation_type, serial_num) values (:model, :qty, :op, :sn)";
        $stm = $this->connect()->prepare($sql);
        $stm->execute([
            'model' => $model,
            'qty' => $qty,
            'op' => $optype,
            'sn' => $sn
        ]);

    }
    public function deletionEvent($model, $qty, $optype, $sn = '') {
        $sql = "INSERT INTO events (model_id, quantity, operation_type, serial_num) values (:model, :qty, :op, :sn)";
        $stm = $this->connect()->prepare($sql);
        $stm->execute([
            'model' => $model,
            'qty' => $qty,
            'op' => $optype,
            'sn' => $sn
        ]);

    }
}
