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
require_once '../../incluidos/modelo/Industria.php';
require_once '../../incluidos/modelo/EmpresaLocal.php';
/** Include PHPExcel */
require_once dirname(__FILE__) . '/PHPExcel/Classes/PHPExcel.php';
require_once dirname(__FILE__) . '/PHPExcel/Classes/PHPExcel/IOFactory.php';


function cargarMiembros() {
	$objPHPExcel = PHPExcel_IOFactory::load("PE-02.xlsx");
	$objPHPExcel->setActiveSheetIndexByName("MIEMBROS");
	$i = 2;
	while (strlen($objPHPExcel->getActiveSheet()->getCell("A".$i)->getValue()) > 0) {		
		$objMiembro = new Miembro();
        print_r($objMiembro->hotfixCodigos($objPHPExcel->getActiveSheet()->getCell("M".$i)->getValue(), 
        $objPHPExcel->getActiveSheet()->getCell("N".$i)->getValue(), 
        $objPHPExcel->getActiveSheet()->getCell("F".$i)->getValue(), 
        $objPHPExcel->getActiveSheet()->getCell("E".$i)->getValue()));
		
		$i++;
	}
	
}
cargarMiembros();

?>