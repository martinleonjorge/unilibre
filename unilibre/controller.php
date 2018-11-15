<?php

session_start();
ini_set("error_reporting", 0);

include_once 'model.php';

switch ($_POST['action']) {
       case "blocks":
        echo getLabsByBlockId($_POST['block_id']);
        break;
       case "productsByLab":
        echo getProductsByLab($_POST['lab_id']);
        break;
    default :
        
        break;
}