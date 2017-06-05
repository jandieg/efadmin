<?php 
require_once MODELO.'Provincia.php';
require_once MODELO.'Pais.php';

include(HTML."/html.php");
include(HTML."/html_combos.php");
//require_once 'public/phpmailer/correo.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    try{
        switch ($_POST['KEY']):  
            case 'KEY_SHOW_FORM_GUARDAR'://///////////////////////////////////////////////////////// 

                $objPais= new Pais();
                $listapais= $objPais->getListaPais(NUll,NULL);
                
                    
                $boton['boton_2'] = array("click" => "setCrear('g')" ,"id" => "btnGuardar","modal" => "" ,"color" => "btn-info" ,"titulo" => "Guardar" ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                $boton['boton_3'] = array("click" => "setCrear('gn')" ,"id" => "btnGuardarNuevo","modal" => "" ,"color" => "btn-info" ,"titulo" => "Guardar y Nuevo" ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                $boton['boton_4'] = array("click" => "getRecargar()" ,"id" => "","modal" => "" ,"color" => "btn-info" ,"titulo" => "Regresar" ,"lado" => "" ,"icono" => "fa-mail-reply");

                //Formularios
                $form['form_9'] = array("elemento" => "combo","change" => "","titulo" => "País", "id" => "_pais", "option" => $listapais);
                $form['form_1'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Provincia", "id" => "_provincia" ,"reemplazo" => "");

                $resultado = str_replace("{contenedor_1}", generadorEtiqueta($form),  getPage('page_detalle_update'));//generadorContMultipleRow($colum)); 
                $resultado = str_replace("{cabecera}", "Crear Estado / Provincia", $resultado);
                $resultado = str_replace("{boton}", generadorBoton2($boton), $resultado);

                echo $resultado;
                exit();

               break;
            case 'KEY_SHOW_FORM_ACTUALIZAR'://///////////////////////////////////////////////////////// 
               if(!empty($_POST['id']) ){    //`est_id`, `est_nombre`, `pais_pai_id`, `est_fechamodificacion`, `est_fecharegistro`, `est_usu_id`, `est_estado`  
                    $objProvincia= new Provincia();
                    $resultset= $objProvincia->getProvincia($_POST['id']); 
                    if ($row = $resultset->fetch_assoc()) {
                        $objPais= new Pais();
                        $listapais= $objPais->getListaPais(NULL, $row['pais_pai_id']);
  
                        $boton['boton_2'] = array("click" => "setActualizar(".$_POST['id'].")" ,"modal" => "" ,"color" => "btn-info" ,"titulo" => "Guardar" ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                        $boton['boton_3'] = array("click" => "getRecargar()" ,"modal" => "" ,"color" => "btn-info" ,"titulo" => "Regresar" ,"lado" => "" ,"icono" => "fa-mail-reply");

                        //Formularios
                        $form['form_9'] = array("elemento" => "combo","change" => "","titulo" => "País", "id" => "_pais", "option" => $listapais);
                        $form['form_1'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Provincia", "id" => "_provincia" ,"reemplazo" => $row['est_nombre']);
                        $form['form_3'] = array("elemento" => "combo","change" => "",  "titulo" => "Estado", "id" => "_estado", "option" => generadorComboEstado(($row['est_estado'] == "A") ? "ACTIVO":"INACTIVO"));
                        $resultado = str_replace("{contenedor_1}", generadorEtiqueta($form),  getPage('page_detalle_update') );
                        $resultado = str_replace("{cabecera}", "Actualizar Estado / Provincia", $resultado);
                        $resultado = str_replace("{boton}", generadorBoton($boton), $resultado);

                        echo $resultado;
                    }
                    exit();
               }
                   break;
            case 'KEY_GUARDAR':///////////////////////////////////////////////////////////         
                if(!empty($_POST['_provincia']) && !empty($_POST['_pais']) && !empty($_POST['key_operacion'] ) ){ 

                   $objProvincia= new Provincia();
                    $comp= $objProvincia->setGrabar($_POST['_pais'], $_POST['_provincia'], $_SESSION['user_id_ben']);  
                    if($comp == "OK"){
                         if($_POST['key_operacion']=='gn'){
                           $data = array("success" => "true_gn", "priority"=>'success',"msg" => 'El Estado / Provincia se creo correctamente!');  
                           echo json_encode($data);              
                        }  else {
                           $data = array("success" => "true_g", "priority"=>'success',"msg" => 'El Estado / Provincia se creo correctamente!');  
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
                 if(!empty($_POST['_provincia']) && !empty($_POST['_estado']) && !empty($_POST['_pais']) && !empty($_POST['_id'] ) ){ 
                   $objProvincia= new Provincia();
                    $comp= $objProvincia->setActualizar($_POST['_id'],$_POST['_pais'],$_POST['_provincia'], $_SESSION['user_id_ben'], $_POST['_estado']);  
                    if($comp == "OK"){
                         $data = array("success" => "true", "priority"=>'success',"msg" => 'El Estado / Provincia se actualizó correctamente!');  
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

$objProvincia= new Provincia();
$cuerpo='';
$cont=1;
$resultset= $objProvincia->get("A");
 while($row = $resultset->fetch_assoc()) { 
     $cuerpo.= generadorTablaFilas(array(
         "<center>".$cont."</center>",  
         generadorLink($row['est_nombre'],'getDetalle('.$row['est_id'].')'),
         $row['pais'],
         date_format(date_create($row['est_fecharegistro']), 'd/m/Y H:i:s'),
         date_format(date_create($row['est_fechamodificacion']), 'd/m/Y H:i:s'))); 
     $cont=$cont + 1;   
 }
$boton['boton_1'] = array("color" => "btn-info" ,"click" => "getCrear()" ,"titulo" => "","icono" => "fa-plus");
$t= generadorTablaConBotones(1, "Estado / Provincia",'getCrear()', array("N°","Provincia", "País","Fecha de Registro", "Última Modificación"), $cuerpo, $boton);
 
 //SELECT `est_id`, `est_nombre`, `pais_pai_id`, `est_fechamodificacion`, `est_fecharegistro`, `est_usu_id`, `est_estado` FROM `estado` WHERE binary est_estado = _estado; 