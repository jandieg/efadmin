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
	$objPHPExcel = PHPExcel_IOFactory::load("IMPORTACION-AR-01.xlsx");
	$objPHPExcel->setActiveSheetIndexByName("MIEMBROS");
	$i = 2;
	while (strlen($objPHPExcel->getActiveSheet()->getCell("A".$i)->getValue()) > 0) {		
		$objMiembro = new Miembro();
        $registro = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($objPHPExcel->getActiveSheet()->getCell('B'.$i)->getValue()));
        $ingreso = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($objPHPExcel->getActiveSheet()->getCell('B'.$i)->getValue()));
        $registro = $registro. " 00:00:00";
        $anho = date('Y', PHPExcel_Shared_Date::ExcelToPHP($objPHPExcel->getActiveSheet()->getCell('B'.$i)->getValue()));
        $cobro = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($objPHPExcel->getActiveSheet()->getCell('C'.$i)->getValue()));
        $cobro = $cobro." 00:00:00";
        $nombre = $objPHPExcel->getActiveSheet()->getCell("M".$i)->getValue();
        $apellido = $objPHPExcel->getActiveSheet()->getCell("N".$i)->getValue();
        $estado = 1;
        $valor = $objPHPExcel->getActiveSheet()->getCell("D".$i)->getCalculatedValue();
        $membresia = $objPHPExcel->getActiveSheet()->getCell("G".$i)->getValue();
        print_r($objMiembro->hotfixInscripcion($nombre, $apellido, $registro, 
        $ingreso, $anho, $cobro, $estado, $valor, $membresia));
		
		$i++;
	}
	
}
cargarMiembros();

?>