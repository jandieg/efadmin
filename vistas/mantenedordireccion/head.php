<?php 
require_once MODELO.'Direccion.php';
require_once MODELO.'Ciudad.php';
require_once MODELO.'Pais.php';
require_once MODELO.'Provincia.php';
require_once MODELO.'Sede.php';
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
                
                $objCiudad= new Ciudad();
                $objCiudad->setIdProvincia($objProvincia->getIdProvincia());
                $listaciudad=$objCiudad->getListaCiudad();
   
                $boton['boton_2'] = array("click" => "setCrear('g')" ,"id" => "btnGuardar","modal" => "" ,"color" => "btn-info" ,"titulo" => "Guardar" ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                $boton['boton_3'] = array("click" => "setCrear('gn')" ,"id" => "btnGuardarNuevo","modal" => "" ,"color" => "btn-info" ,"titulo" => "Guardar y Nuevo" ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                $boton['boton_4'] = array("click" => "getRecargar()" ,"id" => "","modal" => "" ,"color" => "btn-info" ,"titulo" => "Regresar" ,"lado" => "" ,"icono" => "fa-mail-reply");

                //Formularios
                $form['form_1'] = array("elemento" => "combo","change" => "getCargarPaises()","titulo" => $lblPais, "id" => "_pais", "option" => $listapais);
                $form['form_2'] = array("elemento" => "combo", "change" => "getCargarProvincias()","titulo" => $lblProvincia, "id" => "_provincia", "option" => $listaprov);
                $form['form_3'] = array("elemento" => "combo", "change" => "",                  "titulo" => $lblCiudad, "id" => "_ciudad", "option" => $listaciudad);
                $form['form_5'] = array("elemento" => "combo", "change" => "",                  "titulo" => "Tipo", "id" => "_tipo", "option" => generadorComboTipoDireccion());
                $form['form_6'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Dirección", "id" => "_direccion" ,"reemplazo" => "");

                $resultado = str_replace("{contenedor_1}", generadorEtiqueta($form),  getPage('page_detalle_update'));//generadorContMultipleRow($colum)); 
                $resultado = str_replace("{cabecera}", "Crear Dirección", $resultado);
                $resultado = str_replace("{boton}", generadorBoton2($boton), $resultado);

                echo $resultado;
                exit();

               break;
            case 'KEY_SHOW_FORM_ACTUALIZAR':
           
               if(!empty($_POST['id']) ){ 
                    $objDireccion= new Direccion();
                    $resultset= $objDireccion->get($_POST['id']); 
                    if ($row = $resultset->fetch_assoc()) {
                        $objPais= new Pais();
                        $listapais= $objPais->getListaPais($row['pai_id'], NULL);

                        $objProvincia=new Provincia();
                        $objProvincia->setIdPais($objPais->getIdPais());
                        $listaprov=  $objProvincia->getListaProvincia($row['est_id']);
                        
                        $objCiudad= new Ciudad();
                        $objCiudad->setIdProvincia($objProvincia->getIdProvincia());
                        $listaciudad=$objCiudad->getListaCiudad($row['ciu_id']);
                        
                      
                        
                        
                        $boton['boton_2'] = array("click" => "setActualizar(".$_POST['id'].")" ,"modal" => "" ,"color" => "btn-info" ,"titulo" => "Guardar" ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                        $boton['boton_3'] = array("click" => "getRecargar()" ,"modal" => "" ,"color" => "btn-info" ,"titulo" => "Regresar" ,"lado" => "" ,"icono" => "fa-mail-reply");

                        //Formularios
                        $form['form_1'] = array("elemento" => "combo","change" => "getCargarPaises()","titulo" => $lblPais, "id" => "_pais", "option" => $listapais);
                        $form['form_2'] = array("elemento" => "combo", "change" => "getCargarProvincias()","titulo" => $lblProvincia, "id" => "_provincia", "option" => $listaprov);
                        $form['form_3'] = array("elemento" => "combo", "change" => "",                  "titulo" => $lblCiudad, "id" => "_ciudad", "option" => $listaciudad);
                        $form['form_5'] = array("elemento" => "combo", "change" => "",                  "titulo" => "Tipo", "id" => "_tipo", "option" => generadorComboTipoDireccion($row['dir_identificador']));
                        $form['form_6'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Dirección", "id" => "_direccion" ,"reemplazo" => $row['dir_calleprincipal']);
                        $form['form_7'] = array("elemento" => "combo","change" => "",  "titulo" => "Estado", "id" => "_estado", "option" => generadorComboEstado(($row['dir_estado'] == "A") ? "ACTIVO":"INACTIVO"));
                        $resultado = str_replace("{contenedor_1}", generadorEtiqueta($form),  getPage('page_detalle_update') );
                        $resultado = str_replace("{cabecera}", "Actualizar Dirección", $resultado);
                        $resultado = str_replace("{boton}", generadorBoton($boton), $resultado);

                        echo $resultado;
                    }
                    exit();
               }
                   break;
            case 'KEY_GUARDAR':       
                if(!empty($_POST['_ciudad']) && !empty($_POST['_tipo']) && !empty($_POST['key_operacion'] ) && !empty($_POST['_direccion']) ){ 
                   
                   $objDireccion= new Direccion();
                    $comp= $objDireccion->setGrabar($_POST['_ciudad'],$_POST['_direccion'], $_POST['_tipo'], $_SESSION['user_id_ben']);  
                    if($comp == "OK"){
                         if($_POST['key_operacion']=='gn'){
                           $data = array("success" => "true_gn", "priority"=>'success',"msg" => 'La Dirección se creo correctamente!');  
                           echo json_encode($data);              
                        }  else {
                           $data = array("success" => "true_g", "priority"=>'success',"msg" => 'La Dirección se creo correctamente!');  
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
                 if(!empty($_POST['_direccion']) && !empty($_POST['_estado']) && !empty($_POST['_ciudad']) && !empty($_POST['_id'] ) && !empty($_POST['_tipo']) ){ 
                    $objDireccion= new Direccion();
                    $comp= $objDireccion->setActualizar($_POST['_id'],$_POST['_ciudad'], $_POST['_direccion'],$_POST['_tipo'], $_SESSION['user_id_ben'], $_POST['_estado']);  
                    if($comp == "OK"){
                         $data = array("success" => "true", "priority"=>'success',"msg" => 'El Dirección se actualizó correctamente!');  
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
            case 'KEY_SHOW_COMBO_PAIS':
                if(!empty($_POST['_id_pais'])){    
                    
                    $objPais= new Pais();
                    $listapais= $objPais->getListaPais($_POST['_id_pais'], NULL);
                    $prefijoPais= $objPais->getPrefijoPais();
                    
                    $objProvincia=new Provincia();
                    $objProvincia->setIdPais($objPais->getIdPais());
                    $listaprov=  $objProvincia->getListaProvincia(NULL);
                    
                    $provincias= generadorComboSelectOption("_provincia", "getCargarProvincias()",$listaprov);
                    
                    $objCiudad= new Ciudad();
                    $objCiudad->setIdProvincia($objProvincia->getIdProvincia());
                    $listaciudad=$objCiudad->getListaCiudad();
  
                    $ciudades= generadorComboSelectOption("_ciudad", "",$listaciudad);
                    
                    $objSede= new Sede();
                    $objSede->setIdCiudad($objCiudad->getIdCiudad());
                    $lista["0"]= array("value" => "x",  "select" => "selected" ,"texto" => "Seleccione...");
                    $listaSedes= $objSede->getLista(NULL,$lista);
                    
                    $sedes= generadorComboSelectOption("_sede", "",$listaSedes);
                    
                    
                    
                    
                    $data = array("success" => "true", 
                        "provincia"=>$provincias,
                        "ciudad" => $ciudades,
                        "prefijo" => $prefijoPais,
                        "sede" => $sedes);  
                    echo json_encode($data); 
                
                }  else {
                    $data = array("success" => "false", "priority"=>'info', "msg" => 'El combo no tiene datos!');  
                    echo json_encode($data); 
                }

            break;
            case 'KEY_SHOW_COMBO_PROVINCIA':
                if(!empty($_POST['_id_provincia'])){        
                    $objCiudad= new Ciudad();
                    $objCiudad->setIdProvincia($_POST['_id_provincia']);
                    $listaciudad=$objCiudad->getListaCiudad();
                    
                    $ciudades= generadorComboSelectOption("_ciudad", "",$listaciudad);
                    
                    $objSede= new Sede();
                    $objSede->setIdCiudad($objCiudad->getIdCiudad());
                    $lista["0"]= array("value" => "x",  "select" => "selected" ,"texto" => "Seleccione...");
                    $listaSedes= $objSede->getLista(NULL, $lista);
                    $sedes= generadorComboSelectOption("_sede", "",$listaSedes);
                    
                    $data = array("success" => "true", 
                        "ciudad" => $ciudades,
                        "sede" => $sedes); 
                    echo json_encode($data); 
                
                }  else {
                    $data = array("success" => "false", "priority"=>'info', "msg" => 'El combo no tiene datos!');  
                    echo json_encode($data); 
                }

            break;
            
            case 'KEY_SHOW_COMBO_CIUDAD':

                if(!empty($_POST['_id_ciudad'])){  
                    
                    $objSede= new Sede();
                    $objSede->setIdCiudad($_POST['_id_ciudad']);
                    $lista["0"]= array("value" => "x",  "select" => "selected" ,"texto" => "Seleccione...");
                    $listaSedes= $objSede->getLista(NULL, $lista);
                    $sedes= generadorComboSelectOption("_sede", "",$listaSedes);
                    
                    $data = array("success" => "true", 
                        "sede" => $sedes); 
                    echo json_encode($data); 
                
                }  else {
                    $data = array("success" => "false", "priority"=>'info', "msg" => 'El combo no tiene datos!');  
                    echo json_encode($data); 
                }

            break;
     
        endswitch;    
    } catch (Exception $exc) { echo getError($exc);}    
    exit(); 
}

$objDireccion= new Direccion();
$cuerpo='';
$cont=1;
$resultset= $objDireccion->getDirecciones("A");
 while($row = $resultset->fetch_assoc()) { 
     $cuerpo.= generadorTablaFilas(array(
         "<center>".$cont."</center>",  
         generadorLink($row['dir_calleprincipal'],'getDetalle('.$row['dir_id'].')'),
         $row['ciu_nombre'],
         $row['dir_identificador'],
         date_format(date_create($row['dir_fecharegistro']),'d/m/Y H:i:s'),
//         $row['dir_fechamodificacion']
             )); 
     $cont=$cont + 1;   
 }
$boton['boton_1'] = array("color" => "btn-info" ,"click" => "getCrear()" ,"titulo" => "","icono" => "fa-plus");
$t= generadorTablaConBotones(1, "Direcciones",'getCrear()', array("N°","Dirección", "Ciudad","Tipo","Fecha de Registro"), $cuerpo, $boton);

 