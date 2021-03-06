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

function cargarIndustrias() {
	$objPHPExcel = PHPExcel_IOFactory::load("IMPORTACION-AR-01.xlsx");
	$objPHPExcel->setActiveSheetIndexByName("INDUSTRIAS");
	$i = 2;
	while (strlen($objPHPExcel->getActiveSheet()->getCell("A".$i)->getValue()) > 0) {
		$key = (strlen($objPHPExcel->getActiveSheet()->getCell("C".$i)->getValue())==0)?1:0;
		$objIndustria = new Industria();
		$objIndustria->setCreateUpdateIndustria($objPHPExcel->getActiveSheet()->getCell("A".$i)->getValue(), 
		$objPHPExcel->getActiveSheet()->getCell("B".$i)->getValue(), $key);
		$i++;
	}
}

function cargarEmpresas() {
	$objPHPExcel = PHPExcel_IOFactory::load("IMPORTACION-AR-01.xlsx");
	$objPHPExcel->setActiveSheetIndexByName("EMPRESAS");
	$i = 2;
	$data = array();
	while (strlen($objPHPExcel->getActiveSheet()->getCell("A".$i)->getValue()) > 0) {		
		$data[$objPHPExcel->getActiveSheet()->getCell("A".$i)->getCalculatedValue()] = $objPHPExcel->getActiveSheet()->getCell("B".$i)->getValue();
		$objEmpresaLocal = new EmpresaLocal();
		$objEmpresaLocal->setCreateUpdateEmpresa($objPHPExcel->getActiveSheet()->getCell("B".$i)->getValue(), 
		$objPHPExcel->getActiveSheet()->getCell("C".$i)->getValue());
		$i++;
	}
	return $data;
}

function cargarMiembros($datos) {
	$objPHPExcel = PHPExcel_IOFactory::load("IMPORTACION-AR-01.xlsx");
	$objPHPExcel->setActiveSheetIndexByName("MIEMBROS");
	$i = 2;
	while (strlen($objPHPExcel->getActiveSheet()->getCell("A".$i)->getValue()) > 0) {		
		$objMiembro = new Miembro();
		$nombre = $datos[$objPHPExcel->getActiveSheet()->getCell("A".$i)->getCalculatedValue()];
		
		$fecha = date('d/m/Y', PHPExcel_Shared_Date::ExcelToPHP($objPHPExcel->getActiveSheet()->getCell('B'.$i)->getValue()));
		$fecha2 = date('d/m/Y', PHPExcel_Shared_Date::ExcelToPHP($objPHPExcel->getActiveSheet()->getCell('I'.$i)->getValue()));
		$fecha3 = date('d/m/Y', PHPExcel_Shared_Date::ExcelToPHP($objPHPExcel->getActiveSheet()->getCell('N'.$i)->getValue()));
		print_r($objMiembro->setCreateMiembroFromScript($nombre, 
		$fecha, $objPHPExcel->getActiveSheet()->getCell("C".$i)->getValue(),
        $objPHPExcel->getActiveSheet()->getCell("D".$i)->getValue(), $objPHPExcel->getActiveSheet()->getCell("E".$i)->getValue(), 
		$objPHPExcel->getActiveSheet()->getCell("F".$i)->getValue(), $objPHPExcel->getActiveSheet()->getCell("G".$i)->getValue(), 
		$objPHPExcel->getActiveSheet()->getCell("H".$i)->getValue(), $fecha2, 
        $objPHPExcel->getActiveSheet()->getCell("J".$i)->getValue(), $objPHPExcel->getActiveSheet()->getCell("K".$i)->getValue(), 
		$objPHPExcel->getActiveSheet()->getCell("L".$i)->getValue(), $objPHPExcel->getActiveSheet()->getCell("M".$i)->getValue(), 
		$fecha3, $objPHPExcel->getActiveSheet()->getCell("O".$i)->getValue(), 
		$objPHPExcel->getActiveSheet()->getCell("P".$i)->getValue(), $objPHPExcel->getActiveSheet()->getCell("Q".$i)->getValue(), 
		$objPHPExcel->getActiveSheet()->getCell("R".$i)->getValue(), $objPHPExcel->getActiveSheet()->getCell("S".$i)->getValue(), 
		$objPHPExcel->getActiveSheet()->getCell("T".$i)->getValue(), $objPHPExcel->getActiveSheet()->getCell("U".$i)->getValue()));
		$i++;
	}
	
}
cargarIndustrias();
$datos = cargarEmpresas();

cargarMiembros($datos);

?>