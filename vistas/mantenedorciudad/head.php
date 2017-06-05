<?php 
require_once MODELO.'Ciudad.php';
require_once MODELO.'Pais.php';
require_once MODELO.'Provincia.php';
include(LENGUAJE."/lenguaje_1.php");
include(HTML."/html.php");
include(HTML."/html_combos.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    try{
        switch ($_POST['KEY']):  
            case 'KEY_SHOW_FORM_GUARDAR'://///////////////////////////////////////////////////////// 

                $objPais= new Pais();
                $listapais= $objPais->getListaPais(NUll,NULL);

                $objProvincia=new Provincia();
                $objProvincia->setIdPais($objPais->getIdPais());
                $listaprov=  $objProvincia->getListaProvincia();
                
                    
                $boton['boton_2'] = array("click" => "setCrear('g')" ,"id" => "btnGuardar","modal" => "" ,"color" => "btn-info" ,"titulo" => "Guardar" ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                $boton['boton_3'] = array("click" => "setCrear('gn')" ,"id" => "btnGuardarNuevo","modal" => "" ,"color" => "btn-info" ,"titulo" => "Guardar y Nuevo" ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                $boton['boton_4'] = array("click" => "getRecargar()" ,"id" => "","modal" => "" ,"color" => "btn-info" ,"titulo" => "Regresar" ,"lado" => "" ,"icono" => "fa-mail-reply");

                //Formularios
                $form['form_1'] = array("elemento" => "combo","change" => "getCargarPaises()","titulo" => $lblPais, "id" => "_pais", "option" => $listapais);
                $form['form_2'] = array("elemento" => "combo", "change" => "getCargarProvincias()","titulo" => $lblProvincia, "id" => "_provincia", "option" => $listaprov);
                $form['form_3'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Ciudad", "id" => "_ciudad" ,"reemplazo" => "");

                $resultado = str_replace("{contenedor_1}", generadorEtiqueta($form),  getPage('page_detalle_update'));//generadorContMultipleRow($colum)); 
                $resultado = str_replace("{cabecera}", "Crear Ciudad", $resultado);
                $resultado = str_replace("{boton}", generadorBoton2($boton), $resultado);

                echo $resultado;
                exit();

               break;
            case 'KEY_SHOW_FORM_ACTUALIZAR'://///////////////////////////////////////////////////////// 
               if(!empty($_POST['id']) ){ 
                    $objCiudad= new Ciudad();
                    $resultset= $objCiudad->get($_POST['id']); 
                    if ($row = $resultset->fetch_assoc()) {
                        $objPais= new Pais();
                        $listapais= $objPais->getListaPais($row['pai_id'], NULL);

                        $objProvincia=new Provincia();
                        $objProvincia->setIdPais($row['pai_id']);
                        $listaprov=  $objProvincia->getListaProvincia();
  
                        $boton['boton_2'] = array("click" => "setActualizar(".$_POST['id'].")" ,"modal" => "" ,"color" => "btn-info" ,"titulo" => "Guardar" ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                        $boton['boton_3'] = array("click" => "getRecargar()" ,"modal" => "" ,"color" => "btn-info" ,"titulo" => "Regresar" ,"lado" => "" ,"icono" => "fa-mail-reply");

                        //Formularios
                        $form['form_1'] = array("elemento" => "combo","change" => "getCargarPaises()","titulo" => $lblPais, "id" => "_pais", "option" => $listapais);
                        $form['form_2'] = array("elemento" => "combo", "change" => "getCargarProvincias()","titulo" => $lblProvincia, "id" => "_provincia", "option" => $listaprov);
                        $form['form_3'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Ciudad", "id" => "_ciudad" ,"reemplazo" => $row['ciu_nombre']);
                        $form['form_4'] = array("elemento" => "combo","change" => "",  "titulo" => "Estado", "id" => "_estado", "option" => generadorComboEstado(($row['ciu_estado'] == "A") ? "ACTIVO":"INACTIVO"));
                        $resultado = str_replace("{contenedor_1}", generadorEtiqueta($form),  getPage('page_detalle_update') );
                        $resultado = str_replace("{cabecera}", "Actualizar Ciudad", $resultado);
                        $resultado = str_replace("{boton}", generadorBoton($boton), $resultado);

                        echo $resultado;
                    }
                    exit();
               }
                   break;
            case 'KEY_GUARDAR':       
                if(!empty($_POST['_provincia']) && !empty($_POST['_ciudad']) && !empty($_POST['key_operacion'] ) ){ 
                   $objCiudad= new Ciudad();
                    $comp= $objCiudad->setGrabar($_POST['_ciudad'], $_POST['_provincia'], $_SESSION['user_id_ben']);  
                    if($comp == "OK"){
                         if($_POST['key_operacion']=='gn'){
                           $data = array("success" => "true_gn", "priority"=>'success',"msg" => 'La Ciudad se creo correctamente!');  
                           echo json_encode($data);              
                        }  else {
                           $data = array("success" => "true_g", "priority"=>'success',"msg" => 'La Ciudad se creo correctamente!');  
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
            case 'KEY_ACTUALIZAR':   
                 if(!empty($_POST['_provincia']) && !empty($_POST['_estado']) && !empty($_POST['_ciudad']) && !empty($_POST['_id'] ) ){ 
                   $objCiudad= new Ciudad();
                    $comp= $objCiudad->setActualizar($_POST['_id'],$_POST['_ciudad'], $_POST['_provincia'], $_SESSION['user_id_ben'], $_POST['_estado']);  
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

$objCiudad= new Ciudad();
$cuerpo='';
$cont=1;
$resultset= $objCiudad->getCiudades("A");
 while($row = $resultset->fetch_assoc()) { 
     $cuerpo.= generadorTablaFilas(array(
         "<center>".$cont."</center>",  
         generadorLink($row['ciu_nombre'],'getDetalle('.$row['ciu_id'].')'),
         $row['est_nombre'],
         date_format(date_create($row['ciu_fecharegistro']), 'd/m/Y H:i:s'),
         date_format(date_create($row['ciu_fechamodificacion']), 'd/m/Y H:i:s') )); 
     $cont=$cont + 1;   
 }
$boton['boton_1'] = array("color" => "btn-info" ,"click" => "getCrear()" ,"titulo" => "","icono" => "fa-plus");
$t= generadorTablaConBotones(1, "Ciudades",'getCrear()', array("N°","Ciudad", "Estado / Provincia","Fecha de Registro", "Última Modificación"), $cuerpo, $boton);
 