<?php

$page_title = 'Lista de productos';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(2);
$inventorys = join_inventory_table();

$fileName = "inventory" . date("YmdHis") . ".csv";
$fp = fopen($fileName, "w");


$contentString = "";
$titles = "Id;Categoria;Laboratorio;Cantidad en stock;Cantidad en prestamo;Descripcion articulo;Referencia;\r\n";
foreach ($inventorys as $line) {
    $auxString = "";
    $i = 0;
    foreach ($line as $value) {
        if($i==0){
            $auxString .= $value . ";";
            $i++;
        }else{
            $i=0;
        }
    }
    $lineString = $auxString . "\r\n";
    $contentString .= $lineString;
}
$contentString =$titles . $contentString;
fwrite($fp, $contentString);
fclose($fp);

header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary"); 
header("Content-disposition: attachment; filename=\"" . basename($fileName) . "\""); 
readfile($fileName);