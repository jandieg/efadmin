<?php
require_once MODELO.'SeccionIndustria.php';
require_once MODELO.'Industria.php';
include(HTML."/html.php");
include(HTML."/html_combos.php");
//require_once 'public/phpmailer/correo.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    try{
        switch ($_POST['KEY']):  
            case 'KEY_SHOW_FORM_GUARDAR'://///////////////////////////////////////////////////////// 
                $objSeccion= new SeccionIndustria();
                $listaSecciones= $objSeccion->getListas(NULL, NULL);
                        
                $boton['boton_2'] = array("click" => "setCrear('g')" ,"id" => "btnGuardar","modal" => "" ,"color" => "btn-info" ,"titulo" => "Guardar" ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                $boton['boton_3'] = array("click" => "setCrear('gn')" ,"id" => "btnGuardarNuevo","modal" => "" ,"color" => "btn-info" ,"titulo" => "Guardar y Nuevo" ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                $boton['boton_4'] = array("click" => "getRecargar()" ,"id" => "","modal" => "" ,"color" => "btn-info" ,"titulo" => "Regresar" ,"lado" => "" ,"icono" => "fa-mail-reply");

                //Formularios
                $form['form_1'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Industria", "id" => "_industria" ,"reemplazo" => "");
                $form['form_2'] = array("elemento" => "combo","change" => "",  "titulo" => "Sección", "id" => "_seccion", "option" => $listaSecciones); 
                $resultado = str_replace("{contenedor_1}", generadorEtiqueta($form),  getPage('page_detalle_update') );//generadorContMultipleRow($colum)); 
                $resultado = str_replace("{cabecera}", "Crear Industria", $resultado);
                $resultado = str_replace("{boton}", generadorBoton2($boton), $resultado);

                echo $resultado;
                exit();

               break;
            case 'KEY_SHOW_FORM_ACTUALIZAR'://///////////////////////////////////////////////////////// 
               if(!empty($_POST['id']) ){    
                    $objIndustrias= new Industria();
                    $resultset= $objIndustrias->get($_POST['id']); //seccion_id
                    if ($row = $resultset->fetch_assoc()) {
                        $objSeccion= new SeccionIndustria();
                        $listaSecciones= $objSeccion->getListas($row['seccion_id'], NULL);
                        $boton['boton_2'] = array("click" => "setActualizar(".$_POST['id'].")" ,"modal" => "" ,"color" => "btn-info" ,"titulo" => "Guardar" ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                        $boton['boton_3'] = array("click" => "getRecargar()" ,"modal" => "" ,"color" => "btn-info" ,"titulo" => "Regresar" ,"lado" => "" ,"icono" => "fa-mail-reply");

                        //Formularios
                        $form['form_1'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Industria", "id" => "_industria" ,"reemplazo" => $row['ind_descripcion']);
                        $form['form_2'] = array("elemento" => "combo","change" => "",  "titulo" => "Sección", "id" => "_seccion", "option" => $listaSecciones);
                        $form['form_8'] = array("elemento" => "combo","change" => "",  "titulo" => "Estado", "id" => "_estado", "option" => generadorComboEstado(($row['ind_estado'] == "A") ? "ACTIVO":"INACTIVO"));
                        $resultado = str_replace("{contenedor_1}", generadorEtiqueta($form),  getPage('page_detalle_update') );
                        $resultado = str_replace("{cabecera}", "Actualizar Industria", $resultado);
                        $resultado = str_replace("{boton}", generadorBoton($boton), $resultado);

                        echo $resultado;
                    }
                    exit();
               }
                   break;
            case 'KEY_GUARDAR':///////////////////////////////////////////////////////////         
                if(!empty($_POST['_industria']) && !empty($_POST['key_operacion'] ) ){ 

                    $objIndustrias= new Industria();
                    $comp= $objIndustrias->setGrabar($_POST['_industria'], $_SESSION['user_id_ben'],$_POST['_seccion']);  
                    if($comp == "OK"){
                         if($_POST['key_operacion']=='gn'){
                           $data = array("success" => "true_gn", "priority"=>'success',"msg" => 'La Industria se creo correctamente!');  
                           echo json_encode($data);              
                        }  else {
                           $data = array("success" => "true_g", "priority"=>'success',"msg" => 'La Industria se creo correctamente!');  
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
                 if(!empty($_POST['_estado']) && !empty($_POST['_industria']) && !empty($_POST['_id'] ) ){ 

                    $objIndustrias= new Industria();
                    $comp= $objIndustrias->setActualizar($_POST['_id'],$_POST['_industria'], $_POST['_estado'], $_SESSION['user_id_ben'],$_POST['_seccion']);  
                    //setActualizar($id, $industria,$estado, $user)
                    if($comp == "OK"){
                         $data = array("success" => "true", "priority"=>'success',"msg" => 'La Industria se actualizó correctamente!');  
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

$objIndustrias= new Industria();
$cuerpo='';
$cont=1;
$resultset= $objIndustrias->getIndustrias("A");
 while($row = $resultset->fetch_assoc()) { 
     $cuerpo.= generadorTablaFilas(array(
         "<center>".$cont."</center>",
         generadorLink($row['ind_descripcion'],'getDetalle('.$row['ind_id'].')'))); 
     $cont=$cont + 1;   
 }
$boton['boton_1'] = array("color" => "btn-info" ,"click" => "getCrear()" ,"titulo" => "","icono" => "fa-plus");
$boton['boton_2'] = array("color" => "btn-info" ,"click" => "goToImprimir()" ,"titulo" => "","icono" => "fa-print");
 $t= generadorTablaConBotones(1, "Industrias",'getCrear()', array("N°", "Descripción"), $cuerpo, $boton);