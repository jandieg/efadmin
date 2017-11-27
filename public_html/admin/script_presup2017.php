
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



function actualice() {
  $fh = fopen('data.txt','r');
  while ($line = fgets($fh)) {
      $datos = trim($line);
      $lista = explode(',',$datos);
      $objMiembro = new Miembro();
      print_r($objMiembro->setPresupuesto2017($lista[0],$lista[1]));    
  }
  fclose($fh);
}

actualice();

?>