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

function cargarCobros() {
	$objPHPExcel = PHPExcel_IOFactory::load("cob20164.xls");
	$objPHPExcel->setActiveSheetIndexByName("BO-01");
	$i = 3;

	while (strlen($objPHPExcel->getActiveSheet()->getCell("A".$i)->getValue()) > 0) {
        $codigo = $objPHPExcel->getActiveSheet()->getCell("A".$i)->getValue();
        $status = $objPHPExcel->getActiveSheet()->getCell("C".$i)->getValue();
        $estado = 1;
        if (in_array(trim($status), array("MC", "MS"))) {
            $estado = 2;
        }
        $lista = array();
        $fechas = array();
        $numeros = $objPHPExcel->getActiveSheet()->getCell("D".$i)->getValue();
        $lista = explode('--', $numeros);
        $cont = 0;

        foreach ($lista as $l) {
            if (strlen($l) > 0) {
                $fechas[] = "2016-" . $l . "-01";
                $cont++;
            }            
        }
        print_r($fechas);
        $listaf = implode(',', $fechas);
        $listaf.=',';
        $valor = $objPHPExcel->getActiveSheet()->getCell("E".$i)->getCalculatedValue();
        $total = $valor * $cont;
		$objPresupuestoCobro = new PresupuestoCobro();        
        print_r($objPresupuestoCobro->setPresupuestoFromScript($valor, $codigo, $total, $listaf, $estado));
		$i++;
	}
}

	

cargarCobros();

?>