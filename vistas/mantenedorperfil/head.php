<?php 
require_once MODELO.'Perfil.php';
include(HTML."/html.php");
include(HTML."/html_combos.php");
require_once(LENGUAJE."/lenguaje_1.php");
$objPerfil;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    try{
        switch ($_POST['KEY']):            
            case 'KEY_SHOW_FORM_ACTUALIZAR':///////////////////////////////////////////////////////////             
                   if(isset($_POST['id'])){ 
                       $objPerfil= new Perfil();
                       $resultado='';
                       $resultset= $objPerfil->getPerfil($_POST['id']);  
                       if($row = $resultset->fetch_assoc()) { 
                           $form['form_1'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Descripción", "id" => "c_descrpcion" ,"reemplazo" => $row['per_descripcion']);
                           $form['form_8'] = array("elemento" => "combo","change" => "",  "titulo" => "Estado", "id" => "c_estado", "option" => generadorComboEstado($row['per_estado']));  

                           $boton['boton_1'] = array("elemento" => "boton" ,"modal" => "" ,"color" => "btn-info" ,"click" => "setActualizar(".$_POST['id'].")" ,"titulo" => $lblbtnGuardar ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                           $boton['boton_2'] = array("elemento" => "boton" ,"modal" => "#modal_eliminar_Perfil" ,"color" => "btn-info" ,"click" => "getEliminar(".$_POST['id'].")" ,"titulo" => "Inactivar" ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                           $boton['boton_3'] = array("elemento" => "boton" ,"modal" => "" ,"color" => "btn-info" ,"click" => "getRecargar()" ,"titulo" => $lblbtnRegresar ,"lado" => "" ,"icono" => "fa-mail-reply");     

                           $resultado = str_replace("{contenedor_1}", generadorEtiqueta($form),  getPage('page_detalle_update') );//generadorContMultipleRow($colum)); 
                           $resultado = str_replace("{cabecera}", "Editar Perfil", $resultado);
                           $resultado = str_replace("{boton}", generadorBoton($boton), $resultado);
                       }    
                       echo $resultado; 
                   }
                   break;
            case 'KEY_SHOW_FORM_GUARDAR':///////////////////////////////////////////////////////////             
                $form['form_1'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Descripción", "id" => "c_descrpcion" ,"reemplazo" => "");
                $form['form_8'] = array("elemento" => "combo","change" => "",  "titulo" => "Estado", "id" => "c_estado", "option" => generadorComboEstado(NULL));  

                $boton['boton_2'] = array("click" => "setCrear('g')" ,"modal" => ""  ,"color" => "btn-info" ,"titulo" =>$lblbtnGuardar ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                $boton['boton_3'] = array("click" => "setCrear('gn')" ,"modal" => ""  ,"color" => "btn-info" ,"titulo" => $lblbtnGuardarNuevo ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                $boton['boton_4'] = array("click" => "getRecargar()" ,"modal" => ""  ,"color" => "btn-info" ,"titulo" => $lblbtnRegresar ,"lado" => "" ,"icono" => "fa-mail-reply");

                $resultado = str_replace("{contenedor_1}", generadorEtiqueta($form),  getPage('page_detalle_update') );//generadorContMultipleRow($colum)); 
                $resultado = str_replace("{cabecera}", "Crear Perfil", $resultado);
                $resultado = str_replace("{boton}", generadorBoton($boton), $resultado);
                echo $resultado; 
                break;
            case 'KEY_ACTUALIZAR':///////////////////////////////////////////////////////////             
                if(!empty($_POST['id']) && !empty($_POST['descripcion']) && !empty($_POST['estado'])){ 
                    $objPerfil= new Perfil();
                    $comp= $objPerfil->setActualizarPerfil($_POST['id'], $_POST['descripcion'], $_POST['estado'], $_SESSION['user_id_ben']);   
                    if($comp == "OK"){
                        $data = array("success" => "true", "priority"=>'info',"msg" => 'El perfil se actualizo correctamente!');
                        echo json_encode($data);
                    }else{
                        $data = array("success" => "false", "priority"=>'info',"msg" => $comp); 
                        echo json_encode($data);
                    }
                }  else {
                    $data = array("success" => "false", "priority"=>'info',"msg" => 'Faltan campos por llenar!');  
                    echo json_encode($data);
                }
                break;
            case 'KEY_ELIMINAR':///////////////////////////////////////////////////////////             
                if(!empty($_POST['id'])){ 
                    $objPerfil= new Perfil();
                    $comp= $objPerfil->setInactivarPerfil($_POST['id'], $_SESSION['user_id_ben']);
                     if($comp == "OK"){
                        $data = array("success" => "true", "priority"=>'info',"msg" => '');
                        echo json_encode($data);
                    }else{
                        $data = array("success" => "false", "priority"=>'info',"msg" => $comp); 
                        echo json_encode($data);
                    }
                }
                break;
            case 'KEY_GUARDAR':///////////////////////////////////////////////////////////             
                if(!empty($_POST['descripcion']) && !empty($_POST['estado']) && !empty($_POST['key_operacion'])){ 
                    $objPerfil= new Perfil();
                    $comp= $objPerfil->setCrearPerfil( $_POST['descripcion'], $_POST['estado'],  $_SESSION['user_id_ben']);    

                        if($comp == "OK"){
                            if($_POST['key_operacion']=='gn'){
                              $data = array("success" => "true_gn", "priority"=>'success',"msg" => 'El perfil se creo correctamente!');  
                              echo json_encode($data);              
                           }  else {
                              $data = array("success" => "true_g", "priority"=>'success',"msg" => 'El perfil se creo correctamente!');  
                              echo json_encode($data); 
                           }
                        }else{
                            $data = array("success" => "false", "priority"=>'info',"msg" => $comp); 
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
$objPerfil= new Perfil();
$cuerpo='';
$cont=1;
$resultset= $objPerfil->getPerfiles();
 while($row = $resultset->fetch_assoc()) { 
     $cuerpo.= generadorTablaFilas(array(
         "<center>".$cont."</center>",
         generadorLink($row['per_descripcion'],'getActualizar('.$row['per_id'].')'),
         $row['per_estado'],
         date_format(date_create($row['per_fecharegistro']), 'd/m/Y H:i:s'),
         date_format(date_create($row['per_fechamodificacion']), 'd/m/Y H:i:s') )); 
     $cont=$cont + 1;  
 }    
 $t= generadorTabla_(1, "Perfiles",'getCrear()', array("N°", "Descripción","Estado",$lblFRegistro,$lblFModificacion), $cuerpo); 

     
