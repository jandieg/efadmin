<?php
require_once MODELO.'Miembro.php';
include(HTML."/html.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    try{
        switch ($_POST['KEY']):
            case 'x':
          
            break;
                
        endswitch;    
    } catch (Exception $exc) { echo getError($exc);}  
    
     exit(); 
}
$objMiembro= new Miembro();
$resultset= $objMiembro->getEmcabezadoEstadoCuenta($_SESSION['user_id_ben'], date('Y'));
 if($row = $resultset->fetch_assoc()) { 
    
    $bloque['b1'] = array("t_1" => "<b>Nombre:</b>", "t_2" => $row['per_nombre'].' '.$row['per_apellido']);
    $bloque['b_2'] = array("t_1" => '<b>Fecha de Registro:</b>', "t_2" => getFormatoFechadmy($row['mie_fecharegistro']));
    $bloque['b_3'] = array("t_1" => "<b>Grupo:</b> ", "t_2" => $row['gru_descripcion']);
    $bloque['b_4'] = array("t_1" => "<b>Forum Leader:</b> ", "t_2" => $row['nombre_forum']);
    $bloque3['b_5'] = array("t_1" => "<b>Forma de Pago:</b> ", "t_2" => '');
    $bloque3['b_6'] = array("t_1" => "Membresía ", "t_2" => $row['memb_descripcion']);
    $bloque3['b_7'] = array("t_1" => "Período ", "t_2" => $row['periodo']);
    $bloque3['b_8'] = array("t_1" => "Valor ", "t_2" => "$ ".$row['memb_valor']); 

$color="";
$objMiembro= new Miembro();
$cuerpo='';
$cont=1;
$resultset= $objMiembro->getEstadoCuenta($_SESSION['user_id_ben'], date('Y'), '1');
 while($row = $resultset->fetch_assoc()) { 
    $cuerpo.= generadorTablaColoresFilas($color ,array($cont, $row['key'],getFormatoFechadmy($row['fecha']),"$ ".$row['valor']));   
    $cont=$cont + 1;   
 }
$tabla= generadorTablaDetalleEstadoCuenta(array( "N°","Documento", "Fecha de Pago","Valor"), $cuerpo);




//$boton['boton_2'] = array("color" => "btn-info","modal" => "" ,"click" => "goToImprimir()" ,"titulo" => "Imprimir","icono" => "fa-print");

$resultado = str_replace("{contenedor_1}", generadorBloqueTexto($bloque),  getPage('page_detalle') );//generadorContMultipleRow($colum)); 
$resultado = str_replace("{contenedor_2}", generadorBloqueTexto($bloque3), $resultado); 
$resultado = str_replace("{contenedor_3}", $tabla, $resultado); 
$resultado = str_replace("{boton}", '', $resultado); 
$t= $resultado ;
}else{
   $t= '<h1>No Hay Datos que Mostrar!</h1>' ; 
}