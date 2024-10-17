<?php

require_once './class_autoloader.inc.php';

//if(isset($_POST['submit'])) {
    if(!empty($_POST['model_id'])) {
        $modeId = $_POST['model_id'];
        $qty = $_POST['qty'];

        $modelController = new ModelCtrl();
        $modelController->increaseQuantity($modeId, $qty);
        
        $eventCtrl = new Event();
        $eventCtrl->additionEvent($modeId, $qty, 'IN');
        
    } else {
        echo 'empty field';
    }
//} else {
  //  echo 'not submited';
    //header('')l
//}