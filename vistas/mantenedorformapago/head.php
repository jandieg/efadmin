<?php 
require_once MODELO.'FormaPago.php';

include(HTML."/html.php");
include(HTML."/html_combos.php");
//require_once 'public/phpmailer/correo.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    try{
        switch ($_POST['KEY']):  
            case 'KEY_SHOW_FORM_GUARDAR'://///////////////////////////////////////////////////////// 

                $boton['boton_2'] = array("click" => "setCrear('g')" ,"id" => "btnGuardar","modal" => "" ,"color" => "btn-info" ,"titulo" => "Guardar" ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                $boton['boton_3'] = array("click" => "setCrear('gn')" ,"id" => "btnGuardarNuevo","modal" => "" ,"color" => "btn-info" ,"titulo" => "Guardar y Nuevo" ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                $boton['boton_4'] = array("click" => "getRecargar()" ,"id" => "","modal" => "" ,"color" => "btn-info" ,"titulo" => "Regresar" ,"lado" => "" ,"icono" => "fa-mail-reply");

                //Formularios
                $form['form_1'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Forma Pago", "id" => "_forma" ,"reemplazo" => "");

                $resultado = str_replace("{contenedor_1}", generadorEtiqueta($form),  getPage('page_detalle_update') );//generadorContMultipleRow($colum)); 
                $resultado = str_replace("{cabecera}", "Crear Forma Pago", $resultado);
                $resultado = str_replace("{boton}", generadorBoton2($boton), $resultado);

                echo $resultado;
                exit();

               break;
            case 'KEY_SHOW_FORM_ACTUALIZAR'://///////////////////////////////////////////////////////// 
               if(!empty($_POST['id']) ){    //SELECT `for_pag_id`, `for_pag_descripcion`, `for_pag_estado`, `for_pag_fecharegistro`, `for_pag_fechamodificacion`, `for_pag_id_usuario` 
                    $objFormaPago= new FormaPago();
                    $resultset= $objFormaPago->get($_POST['id']); 
                    if ($row = $resultset->fetch_assoc()) {
                        $boton['boton_2'] = array("click" => "setActualizar(".$_POST['id'].")" ,"modal" => "" ,"color" => "btn-info" ,"titulo" => "Guardar" ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                        $boton['boton_3'] = array("click" => "getRecargar()" ,"modal" => "" ,"color" => "btn-info" ,"titulo" => "Regresar" ,"lado" => "" ,"icono" => "fa-mail-reply");

                        //Formularios
                        $form['form_1'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Forma Pago", "id" => "_forma" ,"reemplazo" => $row['for_pag_descripcion']);
                        $form['form_8'] = array("elemento" => "combo","change" => "",  "titulo" => "Estado", "id" => "_estado", "option" => generadorComboEstado(($row['for_pag_estado'] == "A") ? "ACTIVO":"INACTIVO"));
                        $resultado = str_replace("{contenedor_1}", generadorEtiqueta($form),  getPage('page_detalle_update') );
                        $resultado = str_replace("{cabecera}", "Actualizar Forma Pago", $resultado);
                        $resultado = str_replace("{boton}", generadorBoton($boton), $resultado);

                        echo $resultado;
                    }
                    exit();
               }
                   break;
            case 'KEY_GUARDAR':///////////////////////////////////////////////////////////         
                if(!empty($_POST['_forma']) && !empty($_POST['key_operacion'] ) ){ 

                    $objFormaPago= new FormaPago();
                    $comp= $objFormaPago->setGrabar($_POST['_forma'], $_SESSION['user_id_ben']);  
                    if($comp == "OK"){
                         if($_POST['key_operacion']=='gn'){
                           $data = array("success" => "true_gn", "priority"=>'success',"msg" => 'La Forma de Pago se creo correctamente!');  
                           echo json_encode($data);              
                        }  else {
                           $data = array("success" => "true_g", "priority"=>'success',"msg" => 'La Forma de Pago se creo correctamente!');  
                           echo json_encode($data); 
                        }
                    }else{
                        $data = array("success" => "false", "priority"=>'danger',"msg" => $comp); 
                        echo json_encode($data);
                    }


                }  else {
                    $data = array("success" => "false", "priority"=>'info', "msg" => 'Faltan campos por llenar!');  
                    echo json_encode($data); 
                }

                break;
            case 'KEY_ACTUALIZAR':///////////////////////////////////////////////////////////   
                 if(!empty($_POST['_estado']) && !empty($_POST['_forma']) && !empty($_POST['_id'] ) ){ 
                    //setActualizar($id, $descripcion, $user, $estado) 
                    $objFormaPago= new FormaPago();
                    $comp= $objFormaPago->setActualizar($_POST['_id'],$_POST['_forma'], $_SESSION['user_id_ben'], $_POST['_estado']);  
                    //setActualizar($id, $industria,$estado, $user)
                    if($comp == "OK"){
                         $data = array("success" => "true", "priority"=>'success',"msg" => 'La Forma de Pago se actualizó correctamente!');  
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

$objFP= new FormaPago();
$cuerpo='';
$cont=1;
$resultset= $objFP->getFormaPago("A");
 while($row = $resultset->fetch_assoc()) { 
     $cuerpo.= generadorTablaFilas(array(
         "<center>".$cont."</center>",
         generadorLink($row['for_pag_descripcion'],'getDetalle('.$row['for_pag_id'].')'),
         date_format(date_create($row['for_pag_fecharegistro']), 'd/m/Y H:i:s'),
         date_format(date_create($row['for_pag_fechamodificacion']), 'd/m/Y H:i:s'))); 
     $cont=$cont + 1;   
 }
$boton['boton_1'] = array("color" => "btn-info" ,"click" => "getCrear()" ,"titulo" => "","icono" => "fa-plus");
$t= generadorTablaConBotones(1, "Forma de Pago",'getCrear()', array("N°", "Descripción","Fecha de Registro", "Última Modificación"), $cuerpo, $boton);
 
 // SELECT `for_pag_id`, `for_pag_descripcion`, `for_pag_estado`, `for_pag_fecharegistro`, `for_pag_fechamodificacion`, `for_pag_id_usuario` 