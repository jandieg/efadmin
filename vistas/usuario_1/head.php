<?php 
require_once MODELO.'Sede.php';
require_once MODELO.'Perfil.php';
require_once MODELO.'Usuario.php';
require_once MODELO.'Correo.php';
require_once MODELO.'Telefono.php';
include(HTML."/html.php");
include(HTML."/html_combos.php");
require_once(LENGUAJE."/lenguaje_1.php");
$objPerfil;
$objCorreo;
$objTelefono;
$objUsuario;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    try{
        switch ($_POST['KEY']):   
            case 'KEY_SHOW_FORM_ACTUALIZAR':///////////////////////////////////////////////////////////             
                    if(isset($_POST['id'])){ 
    
                        $objUsuario= new Usuario();
                        $cuerpo='';
                        $resultset= $objUsuario->getUser($_POST['id'], 'A');
                         if($row = $resultset->fetch_assoc()) {
                             
                            $idpersona= $row['per_id'];
                            
                            $objPerfil= new Perfil();
                            $listaPerfil= $objPerfil->getListaPerfiles($row['perfil_per_id'],NULL,NULL);

                            $objCorreo= new Correo();
                            $correo_1= $objCorreo->getCorreoPersonalSecundario($idpersona, 'Personal');
                            //$correo_2= $objCorreo->getCorreoPersonalSecundario($idpersona, NULL);

                            $objTelefono= new Telefono();
                            $t_fijo= $objTelefono->getTelefonoTipo($idpersona, 'C');
                            $t_movil= $objTelefono->getTelefonoTipo($idpersona, 'M');
                            
//                            $objSede= new Sede();
//                            $objSede->setIdCiudad('');
//                            $lista["0"]= array("value" => "x",  "select" => "" ,"texto" => "Seleccione...");
//                            $listaSedes= $objSede->getLista($row['sede_id'],$lista);
     
                            
                            $boton['boton_1'] = array("click" => "setActualizarDatos(".$row['usu_id'].")" ,"modal" => ""  ,"color" => "btn-info","titulo" => "Guardar" ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                            $boton['boton_2'] = array("elemento" => "boton" ,"modal" => "#modal_getCrearUserClave" ,"color" => "btn-info" ,"click" => "getAsignarUserClave(".$idpersona.",'".$row['usu_user']."')" ,"titulo" => "Actualizar User" ,"lado" => "pull-right" ,"icono" => "");
                            //$boton['boton_3'] = array("elemento" => "boton" ,"modal" => "#modal_eliminar_Perfil" ,"color" => "btn-info" ,"click" => "getEliminar(".$_POST['id'].")" ,"titulo" => "Inactivar" ,"lado" => "pull-right" ,"icono" => "");
                            $boton['boton_4'] = array("click" => "getRecargar()" ,"modal" => ""  ,"color" => "btn-info","titulo" => "Regresar" ,"lado" => "" ,"icono" => "fa-mail-reply");
                           
                            //Formularios
                            $form['form_1'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblNombre, "id" => "_nombre" ,"reemplazo" => $row['per_nombre']);
                            $form['form_2'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblApellido, "id" => "_apellido" ,"reemplazo" => $row['per_apellido']);
                            $form['form_4'] = array("elemento" => "combo","change" => "", "titulo" => $lblTipoPersona, "id" => "_tipo_p", "option" => generadorComboTipoPersona(($row['per_tipo']=="N" ? "Natural" : "Jurídica")));                
                            $form['form_5'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblIdentificacion, "id" => "_identificacion" ,"reemplazo" => $row['per_identificacion']);         
                            $form['form_6'] = array("elemento" => "caja" ,"tipo" => "date" , "titulo" => $lblFNacimiento, "id" => "_fn", "reemplazo" => $row['per_fechanacimiento']); 
                            $form['form_7'] = array("elemento" => "combo","change" => "",  "titulo" => $lblGenero, "id" => "_genero", "option" => generadorComboGenero($row['per_genero']));
                            $form['form_8'] = array("elemento" => "combo","change" => "","titulo" => $lblPerfil, "id" => "_perfil", "option" => $listaPerfil);  
//                            $form['form_9'] = array("elemento" => "combo", "change" => "",                  "titulo" => "Sede", "id" => "_sede", "option" => $listaSedes);
                            $form['form_15'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblCorreo, "id" => "_correo" ,"reemplazo" => $correo_1);
                            $form['form_16'] = array("elemento" => "caja" ,"tipo" => "number" , "titulo" => $lblTF, "id" => "_telefono" ,"reemplazo" => $t_fijo);
                            $form['form_17'] = array("elemento" => "caja" ,"tipo" => "number" , "titulo" => $lblTM, "id" => "_celular" ,"reemplazo" => $t_movil);
                            
                            
                            $form['form_11'] = array("elemento" => "combo","change" => "","titulo" => $lblEstado, "id" => "_estado", "option" => generadorComboEstado(($row['usu_estado']=="A" ? "Activo" : "Inactivo")));                

                           
                           $resultado = str_replace("{contenedor_1}", generadorEtiqueta($form),  getPage('page_detalle_update') );//generadorContMultipleRow($colum));      
                           $resultado = str_replace("{boton}", generadorBoton($boton), $resultado);  
                           $resultado = str_replace("{cabecera}", "Actualizar Usuario", $resultado);
                           
                                                                                          
                         }
                           
                    
                      echo  $resultado ;
                    }
                    break;
            case 'KEY_SHOW_FORM_GUARDAR'://///////////////////////////////////////////////////////// 
                $objPerfil= new Perfil();
                $listaPerfil= $objPerfil->getListaPerfiles(NULL,NULL,'1');
                
//                $objSede= new Sede();
//                $objSede->setIdCiudad('');
//                $lista["0"]= array("value" => "x",  "select" => "" ,"texto" => "Seleccione...");
//                $listaSedes= $objSede->getLista(NULL,$lista);

                $boton['boton_1'] = array("click" => "setUserCrear('g')" ,"modal" => ""  ,"color" => "btn-info" ,"titulo" => "Guardar" ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                $boton['boton_2'] = array("click" => "setUserCrear('gn')" ,"modal" => ""  ,"color" => "btn-info" ,"titulo" => "Guardar y Nuevo" ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                $boton['boton_3'] = array("click" => "getRecargar()" ,"modal" => ""  ,"color" => "btn-info" ,"titulo" => "Regresar" ,"lado" => "" ,"icono" => "fa-mail-reply");
                
                //Formularios
                $form['form_1'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblNombre, "id" => "_nombre" ,"reemplazo" => "");
                $form['form_2'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblApellido, "id" => "_apellido" ,"reemplazo" => "");
                $form['form_4'] = array("elemento" => "combo","change" => "","titulo" => $lblTipoPersona, "id" => "_tipo_p", "option" => generadorComboTipoPersona('Natural'));                
                $form['form_5'] = array("elemento" => "caja" ,"tipo" => "number" , "titulo" => $lblIdentificacion, "id" => "_identificacion" ,"reemplazo" => "");         
                $form['form_6'] = array("elemento" => "caja" ,"tipo" => "date" , "titulo" => $lblFNacimiento, "id" => "_fn", "reemplazo" => ""); 
                $form['form_7'] = array("elemento" => "combo", "change" => "",   "titulo" => $lblGenero, "id" => "_genero", "option" => generadorComboGenero('MASCULINO'));
                $form['form_8'] = array("elemento" => "combo","change" => "","titulo" => $lblPerfil, "id" => "_perfil", "option" => $listaPerfil);               
//                $form['form_9'] = array("elemento" => "combo", "change" => "",                  "titulo" => "Sede", "id" => "_sede", "option" => $listaSedes);

                $form['form_15'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblCorreo, "id" => "_correo" ,"reemplazo" => "");
                $form['form_16'] = array("elemento" => "caja" ,"tipo" => "number" , "titulo" => $lblTF, "id" => "_telefono" ,"reemplazo" => "");
                $form['form_17'] = array("elemento" => "caja" ,"tipo" => "number" , "titulo" => $lblTM, "id" => "_celular" ,"reemplazo" => "");
                $form2['form_12'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "User", "id" => "_user" ,"reemplazo" => '');
                $form2['form_13'] = array("elemento" => "caja" ,"tipo" => "Password" , "titulo" => "Contraseña", "id" => "_contraseña" ,"reemplazo" =>'');
                $form2['form_14'] = array("elemento" => "caja" ,"tipo" => "Password" , "titulo" => "Confirmar", "id" => "_confirmar" ,"reemplazo" => ''); 
                $form['form_11'] = array("elemento" => "combo","change" => "","titulo" => $lblEstado, "id" => "_estado", "option" => generadorComboEstado('Activo'));   
                
                //echo $formDatosPersonales= generadorFormularios(NULL,NULL,$form, $boton,$cabecera);
                
                $resultado = str_replace("{contenedor_1}", generadorEtiqueta($form),  getPage('page_detalle_crear') );//generadorContMultipleRow($colum));      
                $resultado = str_replace("{boton}", generadorBoton($boton), $resultado);  
                $resultado = str_replace("{cabecera}", "Crear Usuario", $resultado);
                $resultado = str_replace("{contenedor_2}", generadorEtiqueta($form2), $resultado );//generadorContMultipleRow($colum));      
            
                echo $resultado;
                
            break;
            case 'KEY_ACTUALIZAR':///////////////////////////////////////////////////////////             
                   if(!empty($_POST['_id']) && !empty($_POST['_nombre']) && !empty($_POST['_apellido'])  
                            && !empty($_POST['_tipo_p'] )&& !empty($_POST['_identificacion'] )
                            && !empty($_POST['_genero'] )&& !empty($_POST['_perfil'] )&&  !empty($_POST['_estado'] )
                           && !empty($_POST['_correo'] )&& !empty($_POST['_telefono'] )&&  !empty($_POST['_celular'] )){ 
                       
//                        if($_POST['_sede'] == 'x'){
//                            $data = array("success" => "false", "priority"=>'warning', "msg" => 'Debes seleccionar una Sede!');  
//                            echo json_encode($data); 
//                            exit();
//                        }   
                          
                        $objUsuario= new Usuario();
                        $comp= $objUsuario->setActualizarUsuario($_POST['_id'] ,$_POST['_nombre'], $_POST['_apellido'], $_POST['_tipo_p'] ,
                                $_POST['_identificacion'], $_POST['_fn'], $_POST['_genero'], $_POST['_perfil'], $_POST['_estado'], $_SESSION['user_id_ben'], $_POST['_correo']
                                ,$_POST['_telefono'], $_POST['_celular'], '1'); 
                        
                        if($comp == "OK"){
                            $data = array("success" => "true", "priority"=>'success',"msg" => 'El usuario se actualizó correctamente!');  
                            echo json_encode($data);
                            
                        }else{
                            $data = array("success" => "false", "priority"=>'info',"msg" => $comp); 
                            echo json_encode($data);
                        }
                       
                    }  else {
                        $data = array("success" => "false", "priority"=>'info',"msg" => 'Faltan campos por llenar!');  
                        echo json_encode($data);
                    }
                     exit();
                    break;
            case 'KEY_ACTUALIZAR_CREDENCIALES':///////////////////////////////////////////////////////////       
                
           
                     if(!empty($_POST['_id']) && !empty($_POST['_user']) && !empty($_POST['_contraseña']) && !empty($_POST['_confirmar'])){ 
                         if(isset($_POST['_contraseña'])){
                                if($_POST['_contraseña'] != $_POST['_confirmar'] ){
                                   $data = array("success" => "false", "priority"=>'info',"msg" => 'El user no coincide con la confirmación!');  
                                   echo json_encode($data); 
                                   exit();
                               }
                         }
                        $salt = generateSalt();
                        $hash = hash_hmac("sha256", trim($_POST['_contraseña']), $salt);

                            
                        $objUsuario= new Usuario();
                        $comp= $objUsuario->setActualizarUserPassUsuario($_POST['_id'] ,$_POST['_user'], $hash, $_SESSION['user_id_ben'],$salt);     
                         if($comp == "OK"){
                            //correo
                            $data = array("success" => "true", "priority"=>'success',"msg" => 'El usuario se actualizó correctamente!');  
                            echo json_encode($data);
                            
                        }else{
                            $msg='El user ya existe, por favor cambialo!';
                            $data = array("success" => "false", "priority"=>'info',"msg" => $msg); 
                            echo json_encode($data);
                        }
                    }  else {
                        $data = array("success" => "false", "priority"=>'info',"msg" => 'Faltan campos por llenar!');  
                        echo json_encode($data);
                    }
                     
                   
                    break;

            case 'KEY_GUARDAR':///////////////////////////////////////////////////////////        
                    if(!empty($_POST['_nombre']) && !empty($_POST['_apellido']) && !empty($_POST['key_operacion'] ) 
                            && !empty($_POST['_tipo_p'] )&& !empty($_POST['_identificacion'] )
                            && !empty($_POST['_genero'] )&& !empty($_POST['_perfil'] )&& !empty($_POST['_user'] )
                            && !empty($_POST['_contraseña'] )&& !empty($_POST['_confirmar'] )&& !empty($_POST['_estado'] )
                            && !empty($_POST['_correo'] )&& !empty($_POST['_telefono'] )&& !empty($_POST['_celular'] )){ 
//                        if($_POST['_sede'] == 'x'){
//                            $data = array("success" => "false", "priority"=>'warning', "msg" => 'Debes seleccionar una Sede!');  
//                            echo json_encode($data); 
//                            exit();
//                        }

                        if($_POST['_contraseña'] != $_POST['_confirmar'] ){
                            $data = array("success" => "false", "priority"=>'success',"msg" => 'La contraseña no coincide con la confirmación!');  
                            echo json_encode($data); 
                            exit();
                        }
                        
                        $objUsuario= new Usuario();
                        $bandera= $objUsuario->getExisteUsuario_($_POST['_user']);
                        if($bandera=="SI"){
                            $data = array("success" => "false", "priority"=>'info',"msg" => 'El user ya existe, por favor cambialo!');  
                            echo json_encode($data); 
                            exit();
                        }else{
                            ////////////////////////////////////////////////////
                            $salt = generateSalt();
                            $hash = hash_hmac("sha256", trim($_POST['_contraseña']), $salt);
                            ////////////////////////////////////////////////////
                            $objUsuario= new Usuario();
                            $comp= $objUsuario->setGrabarUsuario($_POST['_nombre'], $_POST['_apellido'], $_POST['_tipo_p'],$_POST['_identificacion'], $_POST['_fn'], 
                                $_POST['_genero'], $_POST['_user'] , $hash, $_POST['_perfil'],$_POST['_estado'],  $_SESSION['user_id_ben'],$_POST['_correo']
                                ,$_POST['_telefono'],$_POST['_celular'],$salt,'1');  
                            
                            if($comp=="OK"){
                                //Correo
                                if($_POST['key_operacion']=='gn'){
                                    $data = array("success" => "true_gn", "priority"=>'success',"msg" => 'El Usuario se creo correctamente!');  
                                    echo json_encode($data);              
                                 }  else {
                                    $data = array("success" => "true_g", "priority"=>'success',"msg" => 'El Usuario se creo correctamente!');  
                                    echo json_encode($data); 
                                 }  
                            }else{
                                $msg='El user ya existe, por favor cambialo!';
                                $data = array("success" => "false", "priority"=>'danger',"msg" => $msg);  
                                echo json_encode($data);  
                            }
                        
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



////////////////////////////////////////////////////////////////////////////////
$objUsuario= new Usuario();
$cuerpo='';
$cont=1;
$resultset= $objUsuario->getUsuarios();
 while($row = $resultset->fetch_assoc()) { 
  
     $cuerpo.= generadorTablaFilas(array(
          "<center>".$cont."</center>",
         generadorLink($row['per_nombre'].' '.$row['per_apellido'],'getActualizar('.$row['usu_id'].')'),
         $row['perfil_des'],
         $row['movil'],
         $row['correo'],
         $row['usu_estado']));  
     $cont=$cont + 1; 
 }    
 $t= generadorTabla_(1, "Usuarios",'getCrear()', array("N°", "Nombre","Perfil","Móvil","Correo","Estado"), $cuerpo);



     
