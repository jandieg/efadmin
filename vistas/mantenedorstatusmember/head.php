<?php 
require_once MODELO.'StatusMember.php';

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
                $form['form_1'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Código", "id" => "_codigo" ,"reemplazo" => "");
                $form['form_2'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Status Member", "id" => "_sm" ,"reemplazo" => "");

                $resultado = str_replace("{contenedor_1}", generadorEtiqueta($form),  getPage('page_detalle_update') );//generadorContMultipleRow($colum)); 
                $resultado = str_replace("{cabecera}", "Crear Status Member", $resultado);
                $resultado = str_replace("{boton}", generadorBoton2($boton), $resultado);

                echo $resultado;
                exit();

               break;
            case 'KEY_SHOW_FORM_ACTUALIZAR'://///////////////////////////////////////////////////////// 
               if(!empty($_POST['id']) ){    //SELECT `mem_sta_id`, `mem_sta_codigo`, `mem_sta_descripcion`, `mem_sta_estado`, `mem_sta_id_usuario`, `mem_sta_fecharegistro`, `mem_sta_fechamodificacion`
                    $objStatus= new StatusMember();
                    $resultset= $objStatus->getStatus($_POST['id']); 
                    if ($row = $resultset->fetch_assoc()) {
                        $boton['boton_2'] = array("click" => "setActualizar(".$_POST['id'].")" ,"modal" => "" ,"color" => "btn-info" ,"titulo" => "Guardar" ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                        $boton['boton_3'] = array("click" => "getRecargar()" ,"modal" => "" ,"color" => "btn-info" ,"titulo" => "Regresar" ,"lado" => "" ,"icono" => "fa-mail-reply");

                        //Formularios
                        $form['form_1'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Código", "id" => "_codigo" ,"reemplazo" => $row['mem_sta_codigo']);
                        $form['form_2'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Status Member", "id" => "_sm" ,"reemplazo" => $row['mem_sta_descripcion']);
                        $form['form_3'] = array("elemento" => "combo","change" => "",  "titulo" => "Estado", "id" => "_estado", "option" => generadorComboEstado(($row['mem_sta_estado'] == "A") ? "ACTIVO":"INACTIVO"));
                        $resultado = str_replace("{contenedor_1}", generadorEtiqueta($form),  getPage('page_detalle_update') );
                        $resultado = str_replace("{cabecera}", "Actualizar Status Member", $resultado);
                        $resultado = str_replace("{boton}", generadorBoton($boton), $resultado);

                        echo $resultado;
                    }
                    exit();
               }
                   break;
            case 'KEY_GUARDAR':///////////////////////////////////////////////////////////         
                if(!empty($_POST['_codigo']) && !empty($_POST['_sm']) && !empty($_POST['key_operacion'] ) ){ 

                   $objStatus= new StatusMember();
                    $comp= $objStatus->setGrabar($_POST['_codigo'], $_POST['_sm'], $_SESSION['user_id_ben']);  
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
                 if(!empty($_POST['_codigo']) && !empty($_POST['_estado']) && !empty($_POST['_sm']) && !empty($_POST['_id'] ) ){ 
                    //setActualizar($id, $descripcion, $user, $estado) 
                   $objStatus= new StatusMember();
                    $comp= $objStatus->setActualizar($_POST['_id'],$_POST['_codigo'],$_POST['_sm'], $_SESSION['user_id_ben'], $_POST['_estado']);  
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

$objSM= new StatusMember();
$cuerpo='';
$cont=1;
$resultset= $objSM->get("A");
 while($row = $resultset->fetch_assoc()) { 
     $cuerpo.= generadorTablaFilas(array(
         "<center>".$cont."</center>",
         $row['mem_sta_codigo'],
         generadorLink($row['mem_sta_descripcion'],'getDetalle('.$row['mem_sta_id'].')'),
         date_format(date_create($row['mem_sta_fecharegistro']), 'd/m/Y H:i:s'),
         date_format(date_create($row['mem_sta_fechamodificacion']), 'd/m/Y H:i:s'))); 
     $cont=$cont + 1;   
 }
$boton['boton_1'] = array("color" => "btn-info" ,"click" => "getCrear()" ,"titulo" => "","icono" => "fa-plus");
$t= generadorTablaConBotones(1, "Status Member",'getCrear()', array("N°","Código", "Descripción","Fecha de Registro", "Última Modificación"), $cuerpo, $boton);
 
 // SELECT `for_pag_id`, `for_pag_descripcion`, `for_pag_estado`, `for_pag_fecharegistro`, `for_pag_fechamodificacion`, `for_pag_id_usuario` 