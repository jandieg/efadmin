<?php 
require_once MODELO2.'GlobalSede.php';
require_once MODELO.'Sede.php';
require_once MODELO.'Direccion.php';
require_once MODELO.'Ciudad.php';
require_once MODELO.'Pais.php';
require_once MODELO.'Provincia.php';
include(LENGUAJE."/lenguaje_1.php");
include(HTML."/html.php");
include(HTML."/html_combos.php");
include(LENGUAJE."/lenguaje_1.php");

$prefijoPais='';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    try{
        switch ($_POST['KEY']):  
            case 'KEY_SHOW_FORM_DETALLE':
                if(!empty($_POST['id']) ){ 


                    setDatosConexion($_POST['base']);               
                    $objSede= new Sede();
                    $resultset= $objSede->get($_SESSION['sede_id']);
                    if($row = $resultset->fetch_assoc()) {
                                        
                        $tabla1['t_1'] = array("t_1" => generadorNegritas($lblRazonSocial), "t_2" => $row['sede_razonsocial']);
                        $tabla1['t_2'] = array("t_1" => generadorNegritas("RUC"), "t_2" => $row['sede_correo_secundario']);
                        $tabla1['t_3'] = array("t_1" => generadorNegritas($lblTF), "t_2" => "(".$row['pai_prefijo'].") ". $row['sede_telefono']);
                        $tabla1['t_4'] = array("t_1" => generadorNegritas($lblTM), "t_2" => "(".$row['pai_prefijo'].") ". $row['sede_movil']);
                        $tabla1['t_5'] = array("t_1" => generadorNegritas($lblCorreo), "t_2" => $row['sede_correo_principal']);
                       
                        $tabla1['t_6'] = array("t_1" => generadorNegritas($lblNEmpleados), "t_2" => $row['sede_empleados']);
                        
                        $tabla2['t_7'] = array("t_1" => generadorNegritas($lblFax), "t_2" => $row['sede_fax']);
                        $tabla2['t_8'] = array("t_1" => generadorNegritas($lblSitioWeb), "t_2" => $row['sede_sitioweb']);
                        $tabla2['t_9'] = array("t_1" => generadorNegritas($lblDescripcion), "t_2" => $row['sede_descripcion']);
                        $tabla2['t_10'] = array("t_1" => generadorNegritas($lblAdministrador), "t_2" => $row['sede_administrador']);
                        $tabla2['t_11'] = array("t_1" => generadorNegritas($lblCodigoPostal), "t_2" => $row['sede_codigopostal']);
                        
                        $tabla3['t_12'] = array("t_1" => generadorNegritas($lblPais), "t_2" => $row['pai_nombre']);
                        $tabla3['t_13'] = array("t_1" => generadorNegritas($lblProvincia), "t_2" => $row['est_nombre']);
                        $tabla3['t_14'] = array("t_1" => generadorNegritas($lblCiudad), "t_2" => $row['ciu_nombre']);
                        $tabla3['t_15'] = array("t_1" => generadorNegritas($lblDireccion), "t_2" => $row['sede_direccion']);
            
                        $tabla4['t_16'] = array("t_1" => generadorNegritas($lblFRegistro), "t_2" => getFormatoFechadmyhis($row['sede_fecharegistro']));
                        $tabla4['t_17'] = array("t_1" => generadorNegritas($lblFModificacion), "t_2" => getFormatoFechadmyhis($row['sede_fechamodificacion']));
                        $tabla4['t_18'] = array("t_1" => generadorNegritas($lblUModificar), "t_2" => $row['modificador']);
                     }
                    if($_SESSION['user_subasedatos'] == $_POST['base']){
                        $boton['boton_1'] = array("elemento" => "boton" ,"modal" => "" ,"color" => "btn-info" ,"click" => "getActualizar(".$_POST['id'].")" ,"titulo" => $lblbtnEditar ,"lado" => "pull-right" ,"icono" => "fa-pencil"); 
                    }
                    $boton['boton_2'] = array("elemento" => "boton" ,"modal" => "" ,"color" => "btn-info" ,"click" => "getRecargar()" ,"titulo" => $lblbtnRegresar ,"lado" => "" ,"icono" => "fa-mail-reply");

                    $resultado = str_replace("{contenedor_1}", generadorTabla_2($tabla1, "table-striped"), getPage('page_detalle'));//generadorContMultipleRow($colum)); 
                    $resultado = str_replace("{contenedor_2}", generadorTabla_2($tabla2, "table-striped"), $resultado); 
                    $resultado = str_replace("{contenedor_3}", generadorTabla_2($tabla3, "table-striped"), $resultado); 
                    $resultado = str_replace("{contenedor_4}",generadorTabla_2($tabla4, "table-striped"), $resultado); 
                    $resultado = str_replace("{boton}", generadorBoton($boton), $resultado); 
                                        
                    setDatosConexion($_SESSION['user_subasedatos']);
                    echo $resultado;
                }
             break;
            case 'KEY_SHOW_FORM_GUARDAR'://///////////////////////////////////////////////////////// 

                $objPais= new Pais();
                $listapais= $objPais->getListaPais(NUll,NULL);
                $prefijoPais= $objPais->getPrefijoPais();
                $objProvincia=new Provincia();
                $objProvincia->setIdPais($objPais->getIdPais());
                $listaprov=  $objProvincia->getListaProvincia();
                
                $objCiudad= new Ciudad();
                $objCiudad->setIdProvincia($objProvincia->getIdProvincia());
                $listaciudad=$objCiudad->getListaCiudad();
                
                    
                $boton['boton_2'] = array("click" => "setCrear('g')" ,"id" => "btnGuardar","modal" => "" ,"color" => "btn-info" ,"titulo" => $lblbtnGuardar ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                $boton['boton_3'] = array("click" => "setCrear('gn')" ,"id" => "btnGuardarNuevo","modal" => "" ,"color" => "btn-info" ,"titulo" => $lblbtnGuardarNuevo ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                $boton['boton_4'] = array("click" => "getRecargar()" ,"id" => "","modal" => "" ,"color" => "btn-info" ,"titulo" => $lblbtnRegresar ,"lado" => "" ,"icono" => "fa-mail-reply");

                //Formularios
                $form['form_1'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblRazonSocial, "id" => "_razon_social" ,"reemplazo" => "");
                $form['form_2'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblNEmpleados, "id" => "_num_empleados" ,"reemplazo" => "");
                $form['form_5'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblCorreo, "id" => "_correo" ,"reemplazo" => "");
                $form['form_6'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblCorreoSecundario, "id" => "_correo_2" ,"reemplazo" => "");
                $form['form_7'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblFax, "id" => "_fax" ,"reemplazo" => "");
                $form['form_8'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblSitioWeb, "id" => "_sitio_web" ,"reemplazo" => "");
                $form['form_9'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblDescripcion, "id" => "_descripcion" ,"reemplazo" => "");
                $form['form_10'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblAdministrador, "id" => "_administrador" ,"reemplazo" => "");
                $form['form_11'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblCodigoPostal, "id" => "_cp" ,"reemplazo" => "");
				//Nuevos Permisos de admin y NO pais
if (($_SESSION['user_user']=='admin')||($_SESSION['user_country']=='*')) {
$form['form_12'] = array("elemento" => "combo","change" => "getCargarPaises()","titulo" => $lblPais, "id" => "_pais", "option" => $listapais);
}else{
$form['form_12'] = array("t_1" => generadorNegritas($lblPais), "t_2" => $row['pai_nombre']);	
}


                $form['form_13'] = array("elemento" => "combo", "change" => "getCargarProvincias()","titulo" => $lblProvincia, "id" => "_provincia", "option" => $listaprov);
                $form['form_14'] = array("elemento" => "combo", "change" => "",                  "titulo" => $lblCiudad, "id" => "_ciudad", "option" => $listaciudad);
                $form['form_15'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblDireccion, "id" => "_direccion" ,"reemplazo" => "");
                
                $form['form_16'] = array("elemento" => "caja pequeña + caja" ,"titulo" => $lblTF
                                                       ,"disabled_1" => "disabled","tipo_1" => "number" , "titulo_1" => "Prefijo", "id_1" => "_prefijo_telefono" ,"reemplazo_1" => $prefijoPais
                                                       ,"disabled_2" => "","tipo_2" => "number" , "titulo_2" => $lblTF, "id_2" => "_telefono" ,"reemplazo_2" => "");
                    
                $form['form_17'] = array("elemento" => "caja pequeña + caja" ,"titulo" => $lblTM
                                                       ,"disabled_1" => "disabled","tipo_1" => "number" , "titulo_1" => "Prefijo", "id_1" => "_prefijo_celular" ,"reemplazo_1" => $prefijoPais
                                                       ,"disabled_2" => "","tipo_2" => "number" , "titulo_2" => $lblTM, "id_2" => "_celular" ,"reemplazo_2" => "");
                

                $resultado = str_replace("{contenedor_1}", generadorEtiqueta($form),  getPage('page_detalle_update'));
                $resultado = str_replace("{cabecera}", $lblCrearSede, $resultado);
                $resultado = str_replace("{boton}", generadorBoton2($boton), $resultado);

                echo $resultado;
                exit();

               break;
            case 'KEY_SHOW_FORM_ACTUALIZAR':
           
               if(!empty($_POST['id']) ){ 
                    $objSede= new Sede();
                    $resultset= $objSede->get($_POST['id']);
                    if($row = $resultset->fetch_assoc()) {
                        $objPais= new Pais();
                        $listapais= $objPais->getListaPais($row['pai_id'],NULL);
                        $prefijoPais= $objPais->getPrefijoPais();
                        $objProvincia=new Provincia();
                        $objProvincia->setIdPais($objPais->getIdPais());
                        $listaprov=  $objProvincia->getListaProvincia($row['est_id']);

                        $objCiudad= new Ciudad();
                        $objCiudad->setIdProvincia($objProvincia->getIdProvincia());
                        $listaciudad=$objCiudad->getListaCiudad($row['ciu_id']);


                        $boton['boton_2'] = array("click" => "setActualizar(".$_POST['id'].")" ,"modal" => "" ,"color" => "btn-info" ,"titulo" => "Guardar" ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                        $boton['boton_3'] = array("click" => "getDetalle(".$_POST['id'].",'".$_SESSION['user_subasedatos']."')" ,"modal" => "" ,"color" => "btn-info" ,"titulo" => "Regresar" ,"lado" => "" ,"icono" => "fa-mail-reply");

                        //Formularios
                        $form['form_1'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblRazonSocial, "id" => "_razon_social" ,"reemplazo" => $row['sede_razonsocial']);
                        $form['form_2'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "RUC", "id" => "_correo_2" ,"reemplazo" => $row['sede_correo_secundario']);
                        $form['form_3'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblNEmpleados, "id" => "_num_empleados" ,"reemplazo" => $row['sede_empleados']);
                        $form['form_4'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblCorreo, "id" => "_correo" ,"reemplazo" => $row['sede_correo_principal']);
                        //$form['form_6'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "RUC", "id" => "_correo_2" ,"reemplazo" => $row['sede_correo_secundario']);
                        $form['form_7'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblFax, "id" => "_fax" ,"reemplazo" => $row['sede_fax']);
                        $form['form_8'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblSitioWeb, "id" => "_sitio_web" ,"reemplazo" => $row['sede_sitioweb']);
                        $form['form_9'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblDescripcion, "id" => "_descripcion" ,"reemplazo" => $row['sede_descripcion']);
                        $form['form_10'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblAdministrador, "id" => "_administrador" ,"reemplazo" => $row['sede_administrador']);
                        $form['form_11'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblCodigoPostal, "id" => "_cp" ,"reemplazo" => $row['sede_codigopostal']);
               
			   //Nuevos Permisos de admin y NO pais
if (($_SESSION['user_user']=='admin')||($_SESSION['user_country']=='*')) {
$form['form_12'] = array("elemento" => "combo","change" => "getCargarPaises()","titulo" => $lblPais, "id" => "_pais", "option" => $listapais);
}else{
//$form['form_12'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblPais, "disabled_1" => "disabled", "id" => "_pais" ,"reemplazo" => $row['pai_nombre']);
//$form['form_12'] = array("t_1" => generadorNegritas($lblPais), "t_2" => $row['pai_nombre']);	
  $form['form_12'] = array("elemento" => "caja" ,"tipo" => "hidden", "id" => "_pais" ,"reemplazo" => $row['pais_pai_id']);
}
			   
                        $form['form_13'] = array("elemento" => "combo", "change" => "getCargarProvincias()","titulo" => $lblProvincia, "id" => "_provincia", "option" => $listaprov);
                        $form['form_14'] = array("elemento" => "combo", "change" => "",                  "titulo" => $lblCiudad, "id" => "_ciudad", "option" => $listaciudad);
                        $form['form_15'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblDireccion, "id" => "_direccion" ,"reemplazo" => $row['sede_direccion']);

                        $form['form_16'] = array("elemento" => "caja pequeña + caja" ,"titulo" => $lblTF
                                                               ,"disabled_1" => "disabled","tipo_1" => "number" , "titulo_1" => "Prefijo", "id_1" => "_prefijo_telefono" ,"reemplazo_1" => $prefijoPais
                                                               ,"disabled_2" => "","tipo_2" => "number" , "titulo_2" => $lblTF, "id_2" => "_telefono" ,"reemplazo_2" => $row['sede_telefono']);

                        $form['form_17'] = array("elemento" => "caja pequeña + caja" ,"titulo" => $lblTM
                                                               ,"disabled_1" => "disabled","tipo_1" => "number" , "titulo_1" => "Prefijo", "id_1" => "_prefijo_celular" ,"reemplazo_1" => $prefijoPais
                                                               ,"disabled_2" => "","tipo_2" => "number" , "titulo_2" => $lblTM, "id_2" => "_celular" ,"reemplazo_2" => $row['sede_movil']);
                        $form['form_18'] = array("elemento" => "combo","change" => "",  "titulo" => "Estado", "id" => "_estado", "option" => generadorComboEstado(($row['sede_estado'] == "A") ? "ACTIVO":"INACTIVO"));

                        $resultado = str_replace("{contenedor_1}", generadorEtiqueta($form),  getPage('page_detalle_update'));
                        $resultado = str_replace("{cabecera}", 'Información del IBP', $resultado);
                        $resultado = str_replace("{boton}", generadorBoton($boton), $resultado);

                        echo $resultado;
                        exit();

                    }
                    
               }
                   break;
            case 'KEY_GUARDAR':                
                if(!empty($_POST['_razon_social']) && !empty($_POST['_num_empleados']) && !empty($_POST['key_operacion'] ) && !empty($_POST['_correo']) 
                        && !empty($_POST['_correo_2'])  && !empty($_POST['_sitio_web'])  && !empty($_POST['_administrador'])
                        && !empty($_POST['_pais']) && !empty($_POST['_ciudad']) && !empty($_POST['_telefono']) && !empty($_POST['_celular'])
                        && !empty($_POST['_direccion'])){ 
                    
                    
                    $objSede= new Sede();
                    $comp= $objSede->setGrabar($_POST['_razon_social'],$_POST['_num_empleados'], $_POST['_telefono'], $_POST['_celular'],$_POST['_fax'],
                            $_POST['_sitio_web'],$_POST['_descripcion'],$_POST['_correo'],$_POST['_correo_2'],$_POST['_pais'],$_POST['_direccion'],
                            $_POST['_cp'],$_POST['_ciudad'],$_POST['_administrador'],$_SESSION['user_id_ben']);  
                    if($comp == "OK"){
                         if($_POST['key_operacion']=='gn'){
                           $data = array("success" => "true_gn", "priority"=>'success',"msg" => 'La Sede se creo correctamente!');  
                           echo json_encode($data);              
                        }  else {
                           $data = array("success" => "true_g", "priority"=>'success',"msg" => 'La Sede se creo correctamente!');  
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
                 if(!empty($_POST['_id']) && !empty($_POST['_estado']) && !empty($_POST['_razon_social']) &&  !empty($_POST['_correo']) 
                        && !empty($_POST['_correo_2'])){ 
                     
                    $objSede= new Sede();
                    $comp= $objSede->setActualizar($_POST['_id'],$_POST['_estado'], $_POST['_razon_social'],$_POST['_num_empleados'], $_POST['_telefono'], $_POST['_celular'],$_POST['_fax'],
                            $_POST['_sitio_web'],$_POST['_descripcion'],$_POST['_correo'],$_POST['_correo_2'],$_POST['_pais'],$_POST['_direccion'],
                            $_POST['_cp'],$_POST['_ciudad'],$_POST['_administrador'],$_SESSION['user_id_ben']);   
                    if($comp == "OK"){
                         $data = array("success" => "true", "priority"=>'success',"msg" => 'La sede se actualizó correctamente!');  
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
 if (in_array($perConfiguracionesGeneralesOp5, $_SESSION['usu_permiso'])){
    if (in_array($perPrivilegioLiderRegionalOp1, $_SESSION['usu_permiso'])) {
        $objSede= new GlobalSede();
        $cuerpo='';
        $cont=1;
        $resultset= $objSede->getGlobalTodasSedes("A");
         while($row = $resultset->fetch_assoc()) { 
             $funcion= "getDetalle(".$row['sede_id'].",'".$row['base']."')";
             $cuerpo.= generadorTablaFilas(array(
                 "<center>".$cont."</center>",  
                 generadorLink($row['sede_razonsocial'],$funcion),
                 $row['sede_administrador'],
                 $row['sede_fecharegistro'])); 
             $cont=$cont + 1;   
         }
        $boton['boton_1'] = array("color" => "btn-info" ,"click" => "getCrear()" ,"titulo" => "","icono" => "fa-plus");
        $t= generadorTablaConBotones(1, $lblSede,'getCrear()', array("N°",$lblRazonSocial,$lblAdministrador,$lblFRegistro), $cuerpo, $boton);
        
         
    }else{
        $objSede= new Sede();
        $resultset= $objSede->get($_SESSION['sede_id']);
        if($row = $resultset->fetch_assoc()) {

            $tabla1['t_1'] = array("t_1" => generadorNegritas($lblRazonSocial), "t_2" => $row['sede_razonsocial']);
            $tabla1['t_2'] = array("t_1" => generadorNegritas("RUC"), "t_2" => $row['sede_correo_secundario']);
            $tabla1['t_3'] = array("t_1" => generadorNegritas($lblTF), "t_2" => "(".$row['pai_prefijo'].") ". $row['sede_telefono']);
            $tabla1['t_4'] = array("t_1" => generadorNegritas($lblTM), "t_2" => "(".$row['pai_prefijo'].") ". $row['sede_movil']);
            $tabla1['t_5'] = array("t_1" => generadorNegritas($lblCorreo), "t_2" => $row['sede_correo_principal']);
            
            $tabla1['t_6'] = array("t_1" => generadorNegritas($lblNEmpleados), "t_2" => $row['sede_empleados']);

            $tabla2['t_7'] = array("t_1" => generadorNegritas($lblFax), "t_2" => $row['sede_fax']);
            $tabla2['t_8'] = array("t_1" => generadorNegritas($lblSitioWeb), "t_2" => $row['sede_sitioweb']);
            $tabla2['t_9'] = array("t_1" => generadorNegritas($lblDescripcion), "t_2" => $row['sede_descripcion']);
            $tabla2['t_10'] = array("t_1" => generadorNegritas($lblAdministrador), "t_2" => $row['sede_administrador']);
            $tabla2['t_11'] = array("t_1" => generadorNegritas($lblCodigoPostal), "t_2" => $row['sede_codigopostal']);

            $tabla3['t_12'] = array("t_1" => generadorNegritas($lblPais), "t_2" => $row['pai_nombre']);
            //$tabla3['t_13'] = array("t_1" => generadorNegritas($lblProvincia), "t_2" => $row['est_nombre']);
            $tabla3['t_14'] = array("t_1" => generadorNegritas($lblCiudad), "t_2" => $row['ciu_nombre']);
            $tabla3['t_15'] = array("t_1" => generadorNegritas($lblDireccion), "t_2" => $row['sede_direccion']);

            $tabla4['t_16'] = array("t_1" => generadorNegritas($lblFRegistro), "t_2" => getFormatoFechadmyhis($row['sede_fecharegistro']));
            $tabla4['t_17'] = array("t_1" => generadorNegritas($lblFModificacion), "t_2" => getFormatoFechadmyhis($row['sede_fechamodificacion']));
            $tabla4['t_18'] = array("t_1" => generadorNegritas($lblUModificar), "t_2" => $row['modificador']);
         }

        $boton['boton_1'] = array("elemento" => "boton" ,"modal" => "" ,"color" => "btn-info" ,"click" => "getActualizar(".$_SESSION['sede_id'].")" ,"titulo" => $lblbtnEditar ,"lado" => "pull-right" ,"icono" => "fa-pencil"); 
        //$boton['boton_2'] = array("elemento" => "boton" ,"modal" => "" ,"color" => "btn-info" ,"click" => "getRecargar()" ,"titulo" => $lblbtnRegresar ,"lado" => "" ,"icono" => "fa-mail-reply");

        $resultado = str_replace("{contenedor_1}", generadorTabla_2($tabla1, "table-striped"), getPage('page_detalle'));//generadorContMultipleRow($colum)); 
        $resultado = str_replace("{contenedor_2}", generadorTabla_2($tabla2, "table-striped"), $resultado); 
        $resultado = str_replace("{contenedor_3}", generadorTabla_2($tabla3, "table-striped"), $resultado); 
        $resultado = str_replace("{contenedor_4}",generadorTabla_2($tabla4, "table-striped"), $resultado); 
        $resultado = str_replace("{boton}", generadorBoton($boton), $resultado); 
        $t= $resultado;       
    }


 





}elseif (in_array($perVerPerfilMiembroOp12, $_SESSION['usu_permiso'])) {    
    redirect("miembroperfil");
}elseif (in_array($perConfiguracionesOp5, $_SESSION['usu_permiso'])) {    
    redirect("controlseguridad");
}else{
    redirect("perfil");
}