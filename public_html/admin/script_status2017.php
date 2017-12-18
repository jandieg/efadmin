<?php
session_start();
error_reporting(E_ERROR | E_PARSE);
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
	ini_set('memory_limit', '3500M'); 
	ini_set('max_execution_time', 300); //300 seconds = 5 minutes

require_once '../../incluidos/Conexion.php';
require_once '../../incluidos/modelo/Miembro.php';

require_once '../../incluidos/modelo/PresupuestoCobro.php';
/** Include PHPExcel */
require_once dirname(__FILE__) . '/PHPExcel/Classes/PHPExcel.php';
require_once dirname(__FILE__) . '/PHPExcel/Classes/PHPExcel/IOFactory.php';



function cargarStatus() {
	$objPHPExcel = PHPExcel_IOFactory::load("SPE02.xls");
	$objPHPExcel->setActiveSheetIndexByName("MX6");
	$i = 3;
	while (strlen($objPHPExcel->getActiveSheet()->getCell("A".$i)->getValue()) > 0) {
        $codigo = $objPHPExcel->getActiveSheet()->getCell("A".$i)->getValue();
        $valor = date('d/m/Y', PHPExcel_Shared_Date::ExcelToPHP($objPHPExcel->getActiveSheet()->getCell('D'.$i)->getValue()));
        $fecha = implode('-', array_reverse(explode('/', $valor))); 
        echo " " . $fecha . " ";       
        $objPresupuestoCobro = new PresupuestoCobro();        
        print_r($objPresupuestoCobro->updateStatus2017($codigo, $fecha));
		$i++;
	}
}

	

cargarStatus();

?>