<?php 
require_once MODELO.'Membresia.php';
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
                $form['form_1'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Membresía", "id" => "_membresia" ,"reemplazo" => "");
                $form['form_2'] = array("elemento" => "caja" ,"tipo" => "number" , "titulo" => "Valor $", "id" => "_valor" ,"reemplazo" => "");

                $resultado = str_replace("{contenedor_1}", generadorEtiqueta($form),  getPage('page_detalle_update') );//generadorContMultipleRow($colum)); 
                $resultado = str_replace("{cabecera}", "Crear Status Member", $resultado);
                $resultado = str_replace("{boton}", generadorBoton2($boton), $resultado);

                echo $resultado;
                exit();

               break;
            case 'KEY_SHOW_FORM_ACTUALIZAR'://///////////////////////////////////////////////////////// 
               if(!empty($_POST['id']) ){    //SELECT `memb_id`, `memb_descripcion`, `memb_valor`, `memb_estado`, `memb_id_usuario`, `memb_fecharegistro`, `memb_fechamodificacion`
                    $objMembresia= new Membresia();
                    $resultset= $objMembresia->getMembresia($_POST['id']); 
                    if ($row = $resultset->fetch_assoc()) {
                        $boton['boton_2'] = array("click" => "setActualizar(".$_POST['id'].")" ,"modal" => "" ,"color" => "btn-info" ,"titulo" => "Guardar" ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                        $boton['boton_3'] = array("click" => "getRecargar()" ,"modal" => "" ,"color" => "btn-info" ,"titulo" => "Regresar" ,"lado" => "" ,"icono" => "fa-mail-reply");

                        //Formularios
                        $form['form_1'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Membresía", "id" => "_membresia" ,"reemplazo" => $row['memb_descripcion']);
                        $form['form_2'] = array("elemento" => "caja" ,"tipo" => "number" , "titulo" => "Valor $", "id" => "_valor" ,"reemplazo" => $row['memb_valor']);
                        $form['form_3'] = array("elemento" => "combo","change" => "",  "titulo" => "Estado", "id" => "_estado", "option" => generadorComboEstado(($row['memb_estado'] == "A") ? "ACTIVO":"INACTIVO"));
                        $resultado = str_replace("{contenedor_1}", generadorEtiqueta($form),  getPage('page_detalle_update') );
                        $resultado = str_replace("{cabecera}", "Actualizar Membresía", $resultado);
                        $resultado = str_replace("{boton}", generadorBoton($boton), $resultado);

                        echo $resultado;
                    }
                    exit();
               }
                   break;
            case 'KEY_GUARDAR':///////////////////////////////////////////////////////////         
                if(!empty($_POST['_membresia']) && !empty($_POST['key_operacion'] ) ){ 

                   $objMembresia= new Membresia();
                    $comp= $objMembresia->setGrabar($_POST['_valor'], $_POST['_membresia'], $_SESSION['user_id_ben']);  
                    if($comp == "OK"){
                         if($_POST['key_operacion']=='gn'){
                           $data = array("success" => "true_gn", "priority"=>'success',"msg" => 'La Membresía se creo correctamente!');  
                           echo json_encode($data);              
                        }  else {
                           $data = array("success" => "true_g", "priority"=>'success',"msg" => 'La Membresía se creo correctamente!');  
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
                 if(!empty($_POST['_membresia']) && !empty($_POST['_estado']) && !empty($_POST['_id'] ) ){ 
                    //setActualizar($id, $valor , $membresia, $user, $estado)
                   $objMembresia= new Membresia();
                    $comp= $objMembresia->setActualizar($_POST['_id'],$_POST['_valor'],$_POST['_membresia'], $_SESSION['user_id_ben'], $_POST['_estado']);  
                    //setActualizar($id, $industria,$estado, $user)
                    if($comp == "OK"){
                         $data = array("success" => "true", "priority"=>'success',"msg" => 'La Membresía se actualizó correctamente!');  
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

$objMembresia= new Membresia();
$cuerpo='';
$cont=1;
$resultset= $objMembresia->getMembresias("A");
 while($row = $resultset->fetch_assoc()) { 
     $cuerpo.= generadorTablaFilas(array(
         "<center>".$cont."</center>",
         generadorLink($row['memb_descripcion'],'getDetalle('.$row['memb_id'].')'),
         "$ ".$row['memb_valor'],
         $row['memb_fecharegistro'],
         $row['memb_fechamodificacion'])); 
     $cont=$cont + 1;   
 }
$boton['boton_1'] = array("color" => "btn-info" ,"click" => "getCrear()" ,"titulo" => "","icono" => "fa-plus");
$t= generadorTablaConBotones(1, "Membresía",'getCrear()', array("N°","Descripción", "Valor","Fecha de Registro", "Última Modificación"), $cuerpo, $boton);
 
 //SELECT `memb_id`, `memb_descripcion`, `memb_valor`, `memb_estado`, `memb_id_usuario`, `memb_fecharegistro`, `memb_fechamodificacion` FROM `membresia` WHERE 1