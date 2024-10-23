<?php
require_once './class_autoloader.inc.php';

class Productdetails extends Dbh
{
    public function addProductdetails($sn,	$store,	$model,	$states,	$indate, $outdate, $descriptn, $specification ) {
        $sql = "INSERT INTO productdetails (serial_num,	store_id,	model_id,	state_id,	indate, outdate, description, specification)
        values (:sn, :store, :model, :states, :indate, :outdate, :description, :specification)";
        $stm = $this->connect()->prepare($sql);
        $stm->execute([
            'sn' => $sn,
            'store' => $store,
            'model' => $model,
            'state' => $states,	
            'indate' => $indate, 
            'outdate' => $outdate, 
            'description' => $descriptn, 
            'specification' => $specification
        ]);

    }
    
}
