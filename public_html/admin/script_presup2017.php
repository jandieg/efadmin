
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


/*
$fh = fopen('filename.txt','r');
while ($line = fgets($fh)) {
  // <... Do your work with the line ...>
  // echo($line);
}
fclose($fh);
*/
function actualice() {
    

    $objMiembro = new Miembro();
    print_r($objMiembro->setPresupuesto2017(1170,900));
    
    $objMiembro = new Miembro();
    print_r($objMiembro->setPresupuesto2017(1171,500));
    
    $objMiembro = new Miembro();
    print_r($objMiembro->setPresupuesto2017(1172,900));
    
    $objMiembro = new Miembro();
    print_r($objMiembro->setPresupuesto2017(1173,900));
    
    
    $objMiembro = new Miembro();
    print_r($objMiembro->setPresupuesto2017(1174,500));
    
    
    $objMiembro = new Miembro();
    print_r($objMiembro->setPresupuesto2017(1175,900));
    
    $objMiembro = new Miembro();
    print_r($objMiembro->setPresupuesto2017(1176,900));
    
    $objMiembro = new Miembro();
    print_r($objMiembro->setPresupuesto2017(1177,900));
    
    $objMiembro = new Miembro();
    print_r($objMiembro->setPresupuesto2017(1178,900));
    
    $objMiembro = new Miembro();
    print_r($objMiembro->setPresupuesto2017(1179,900));
    
    $objMiembro = new Miembro();
    print_r($objMiembro->setPresupuesto2017(1179,900));
    
    $objMiembro = new Miembro();
    print_r($objMiembro->setPresupuesto2017(1180,900));

    $objMiembro = new Miembro();
    print_r($objMiembro->setPresupuesto2017(1181,900));

    $objMiembro = new Miembro();
    print_r($objMiembro->setPresupuesto2017(1182,900));

    $objMiembro = new Miembro();
    print_r($objMiembro->setPresupuesto2017(1185,900));

    $objMiembro = new Miembro();
    print_r($objMiembro->setPresupuesto2017(1186,900));

    $objMiembro = new Miembro();
    print_r($objMiembro->setPresupuesto2017(1187,900));

}

actualice();

?>