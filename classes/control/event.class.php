<?php
require_once './class_autoloader.inc.php';

class Event extends Dbh
{
    public function additionEvent($model, $qty, $optype) {
        $sql = "INSERT INTO events (model_id, quantity, operation_type) values (:model, :qty, :op)";
        $stm = $this->connect()->prepare($sql);
        $stm->execute([
            'model' => $model,
            'qty' => $qty,
            'op' => $optype,
        ]);

    }
    public function deletionEvent($model, $qty, $optype) {
        $sql = "INSERT INTO events (model_id, quantity, operation_type) values (:model, :qty, :op)";
        $stm = $this->connect()->prepare($sql);
        $stm->execute([
            'model' => $model,
            'qty' => $qty,
            'op' => $optype,
        ]);

    }
}
