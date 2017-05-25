<?php 
require_once MODELO.'EstadoPresupuesto.php';

include(HTML."/html.php");
include(HTML."/html_combos.php");
//require_once 'public/phpmailer/correo.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    try{
        switch ($_POST['KEY']):  

            case 'KEY_SHOW_FORM_ACTUALIZAR':
               if(!empty($_POST['id']) ){    
                    $objEstadoPresupuesto= new EstadoPresupuesto();
                    $resultset= $objEstadoPresupuesto->get($_POST['id']); 
                    if ($row = $resultset->fetch_assoc()) {
                        $boton['boton_2'] = array("click" => "setActualizar(".$_POST['id'].")" ,"modal" => "" ,"color" => "btn-info" ,"titulo" => "Guardar" ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                        $boton['boton_3'] = array("click" => "getRecargar()" ,"modal" => "" ,"color" => "btn-info" ,"titulo" => "Regresar" ,"lado" => "" ,"icono" => "fa-mail-reply");

                        //Formularios
                        $form['form_1'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Descripción", "id" => "_descripcion" ,"reemplazo" => $row['est_pre_descripcion']);
                        //$form['form_8'] = array("elemento" => "combo","change" => "",  "titulo" => "Estado", "id" => "_estado", "option" => generadorComboEstado(($row['cat_estado'] == "A") ? "ACTIVO":"INACTIVO"));
                        $resultado = str_replace("{contenedor_1}", generadorEtiqueta($form),  getPage('page_detalle_update') );
                        $resultado = str_replace("{cabecera}", "Actualizar Estado Monetario", $resultado);
                        $resultado = str_replace("{boton}", generadorBoton($boton), $resultado);

                        echo $resultado;
                    }
                    exit();
               }
                   break;
         
            case 'KEY_ACTUALIZAR':///////////////////////////////////////////////////////////   
                 if( !empty($_POST['_descripcion']) && !empty($_POST['_id']) ){ 
                    $objEstadoPresupuesto= new EstadoPresupuesto();
                    $comp= $objEstadoPresupuesto->setActualizar($_POST['_id'],$_POST['_descripcion'], $_SESSION['user_id_ben']);  
                    if($comp == "OK"){
                         $data = array("success" => "true", "priority"=>'success',"msg" => 'El Estado Monetario se actualizó correctamente!');  
                           echo json_encode($data);
                    }else{
                        $data = array("success" => "false", "priority"=>'danger',"msg" => $comp); 
                        echo json_encode($data);
                    }


                }  else {
                    $data = array("success" => "false", "priority"=>'info', "msg" => 'Faltan campos por llenar!');  
                    echo json_encode($data); 
                }

                break;         
        endswitch;    
    } catch (Exception $exc) { echo getError($exc);}    
    exit(); 
}

$objEstadoPresupuesto= new EstadoPresupuesto();
$cuerpo='';
$cont=1;
$resultset= $objEstadoPresupuesto->getEstadoPresupuestos();
 while($row = $resultset->fetch_assoc()) { 
     $cuerpo.= generadorTablaFilas(array(
         "<center>".$cont."</center>",
         generadorLink($row['est_pre_descripcion'],'getDetalle('.$row['est_pre_id'].')'),
         $row['est_pre_fecharegistro'],
         $row['est_pre_fechamodificacion'])); 
     $cont=$cont + 1;   
 }
$boton= array();
//$boton['boton_1'] = array("color" => "btn-info" ,"click" => "getCrear()" ,"titulo" => "","icono" => "fa-plus");
$t= generadorTablaConBotones(1, "Estados Monetarios",'getCrear()', array("N°", "Descripción","Fecha de Registro", "Última Modificación"), $cuerpo, $boton);
 
 //SELECT `est_pre_id`, `est_pre_descripcion`, `est_pre_estado`, `est_pre_fecharegistro`, `est_pre_fechamodificacion`, `est_pre_id_usuario` FROM `estado_presupuesto` WHERE 1