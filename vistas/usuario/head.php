<?php 
require_once MODELO.'Sede.php';
require_once MODELO.'Perfil.php';
require_once MODELO.'Usuario.php';
require_once MODELO.'Correo.php';
require_once MODELO.'Telefono.php';
require_once MODELO.'ForumLeader.php';
require_once MODELO.'EmpresaLocal.php';
require_once MODELO.'Miembro.php';
require_once MODELO.'Pais.php';
require_once MODELO.'Sede.php';
include(HTML."/html.php");
include(HTML."/html_combos.php");
include(HTML."/html_2.php");
require_once(LENGUAJE."/lenguaje_1.php");
require_once E_LIB.'Mail.php';
$objPerfil;
$objCorreo;
$objTelefono;
$objUsuario;
function enviarCorreoForumLeader( $asunto,  $mensaje) {
    $cont=0;
    $destinatarios=array();
    $objForumLeader= new ForumLeader();
    $resultset= $objForumLeader->getForumLeader('');
    while($row = $resultset->fetch_assoc()) { 
         $destinatarios[$cont]= $row['correo'];
         $cont= $cont + 1;
    } 
    $mail= new Mail(); 
    $msg= $mail->enviarMultiple($_SESSION['user_name'],$_SESSION['user_correo'], $asunto, $mensaje, FALSE, $destinatarios);
    return $msg;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    try{
        switch ($_POST['KEY']):   

            case 'KEY_ARCHIVO':             
                if(is_array($_FILES)) {
                if(is_uploaded_file($_FILES['archivo']['tmp_name'])) {
                $sourcePath = $_FILES['archivo']['tmp_name'];                
                $targetPath = "../../public_html/i/".$_POST['codigo'].".jpg";
                move_uploaded_file($sourcePath,$targetPath);
                }}               
            break;
            case 'KEY_SHOW_FORM_ACTUALIZAR':///////////////////////////////////////////////////////////             
                    if(isset($_POST['id'])){ 
                        $objUsuario= new Usuario();
                        $resultset= $objUsuario->getUser($_POST['id'], '');
                        if($row = $resultset->fetch_assoc()) {                             
                            $idpersona= $row['per_id'];                            
                            $objPerfil= new Perfil();
                            $listaPerfil= $objPerfil->getListaPerfiles($row['perfil_per_id'], NULL, $_SESSION['_tipo_usuario']);
							
												$objPais= new Pais();
    $listapais= $objPais->getListaPais($row['pais_id'],$listap); 
	
	$objSede= new Sede();
    $listaSedes= $objSede->getLista($row['pais_id'],$listap); 

							
							
                            
                            $boton['boton_1'] = array("click" => "setActualizarDatos(".$row['usu_id'].")" ,"modal" => ""  ,"color" => "btn-info","titulo" => "Guardar" ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                            $boton['boton_2'] = array("elemento" => "boton" ,"modal" => "#modal_getCrearUserClave" ,"color" => "btn-info" ,"click" => "getAsignarUserClave(".$idpersona.",'".$row['usu_user']."')" ,"titulo" => "Actualizar User" ,"lado" => "pull-right" ,"icono" => "");
                            //$boton['boton_3'] = array("elemento" => "boton" ,"modal" => "#modal_eliminar_Perfil" ,"color" => "btn-info" ,"click" => "getEliminar(".$_POST['id'].")" ,"titulo" => "Inactivar" ,"lado" => "pull-right" ,"icono" => "");
                            $boton['boton_4'] = array("click" => "getRecargar()" ,"modal" => ""  ,"color" => "btn-info","titulo" => "Regresar" ,"lado" => "" ,"icono" => "fa-mail-reply");
                           
                            //Formularios
                            $form['form_1'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => generadorAsterisco($lblNombre), "id" => "_nombre" ,"reemplazo" => $row['per_nombre']);
                            $form['form_2'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => generadorAsterisco($lblApellido), "id" => "_apellido" ,"reemplazo" => $row['per_apellido']);
                            
                            $form['form_6'] = array("elemento" => "caja" ,"tipo" => "date" , "titulo" => $lblFNacimiento, "id" => "_fn", "reemplazo" => $row['per_fechanacimiento']); 
                            $form['form_7'] = array("elemento" => "combo","change" => "",  "titulo" => $lblGenero, "id" => "_genero", "option" => generadorComboGenero($row['per_genero']));
                            $form['form_8'] = array("elemento" => "combo","change" => "cambioPerfil()","titulo" => generadorAsterisco($lblPerfil), "id" => "_perfil", "option" => $listaPerfil);  
                            $form['form_15'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" =>generadorAsterisco( $lblCorreo), "id" => "_correo" ,"reemplazo" => $row['correo']);
                            $form['form_16'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => $lblTF, "id" => "_telefono" ,"reemplazo" => $row['fijo']);
                            $form['form_17'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => generadorAsterisco($lblTM), "id" => "_celular" ,"reemplazo" => $row['movil']);     
                            $form['form_11'] = array("elemento" => "combo","change" => "","titulo" => $lblEstado, "id" => "_estado", "option" => generadorComboEstado(($row['usu_estado']=="A" ? "Activo" : "Inactivo")));  
						//   $form['form_12'] = array("elemento" => "combo", "change" => "",                  "titulo" => "Sede", "id" => "_sede", "option" => $listaSedes);
						   $form['form_12'] =  array("elemento" => "combo","change" => "","titulo" => $lblPais, "id" => "_pais", "option" => $listapais);
                           $form['form_13'] = array("elemento" => "cajaoc" ,"tipo" => "text" , "titulo" => "Esposa", "id" => "_esposa" ,"reemplazo" => $row['per_esposa']);
                           $form['form_14'] = array("elemento" => "cajaoc" ,"tipo" => "text" , "titulo" => "Hijos", "id" => "_hijos" ,"reemplazo" => $row['per_hijos']);
                           $form['form_18'] = array("elemento" => "subir-imagen-oc", "valor" => $row['usu_id']);
                           $form['form_19'] = array("elemento" => "caja", "tipo" => "hidden", "id" => "_usu_id", "reemplazo" => $row['usu_id']);
                           $form['form_4'] = array("elemento" => "caja","tipo" => "hidden", "titulo" => "", "id" => "_tipo_p", "reemplazo" => "N");                
                            //$form['form_5'] = array("elemento" => "caja" ,"tipo" => "hidden" , "titulo" => "", "id" => "_identificacion" ,"reemplazo" => $row['per_identificacion']);         
                           $resultado = str_replace("{contenedor_1}", generadorEtiqueta($form),  getPage('page_detalle_update') );//generadorContMultipleRow($colum));      
                           $resultado = str_replace("{boton}", generadorBoton($boton), $resultado);  
                           $resultado = str_replace("{cabecera}", "Actualizar Usuario", $resultado);
                           
                                                                                          
                         }
                           
                    
                      echo  $resultado ;
                    }
                    break;
            case 'KEY_SHOW_FORM_GUARDAR'://///////////////////////////////////////////////////////// 
                $objPerfil= new Perfil();
                $listaPerfil= $objPerfil->getListaPerfiles(NULL,NULL,$_SESSION['_tipo_usuario']);
                
    $objPais= new Pais();
    $listapais= $objPais->getListaPais($_SESSION['global_pais_temporales'],$listap); 
	
	
                $boton['boton_1'] = array("click" => "setUserCrear('g')" ,"modal" => ""  ,"color" => "btn-info" ,"titulo" => "Guardar" ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                $boton['boton_2'] = array("click" => "setUserCrear('gn')" ,"modal" => ""  ,"color" => "btn-info" ,"titulo" => "Guardar y Nuevo" ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                $boton['boton_3'] = array("click" => "getRecargar()" ,"modal" => ""  ,"color" => "btn-info" ,"titulo" => "Regresar" ,"lado" => "" ,"icono" => "fa-mail-reply");
                
                //Formularios
                $form['form_1'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => generadorAsterisco($lblNombre), "id" => "_nombre" ,"reemplazo" => "");
                $form['form_2'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => generadorAsterisco($lblApellido), "id" => "_apellido" ,"reemplazo" => "");
                $form['form_4'] = array("elemento" => "combo","change" => "","titulo" => $lblTipoPersona, "id" => "_tipo_p", "option" => generadorComboTipoPersona('Natural'));                
                //$form['form_5'] = array("elemento" => "caja" ,"tipo" => "number" , "titulo" => $lblIdentificacion, "id" => "_identificacion" ,"reemplazo" => "");         
                $form['form_6'] = array("elemento" => "caja" ,"tipo" => "date" , "titulo" => $lblFNacimiento, "id" => "_fn", "reemplazo" => ""); 
                $form['form_7'] = array("elemento" => "combo", "change" => "",   "titulo" => $lblGenero, "id" => "_genero", "option" => generadorComboGenero('MASCULINO'));
                $form['form_8'] = array("elemento" => "combo","change" => "","titulo" => generadorAsterisco($lblPerfil), "id" => "_perfil", "option" => $listaPerfil);               
//                $form['form_9'] = array("elemento" => "combo", "change" => "",                  "titulo" => "Sede", "id" => "_sede", "option" => $listaSedes);

                $form['form_15'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => generadorAsterisco($lblCorreo), "id" => "_correo" ,"reemplazo" => "");
                $form['form_16'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => generadorAsterisco($lblTF), "id" => "_telefono" ,"reemplazo" => "");
                $form['form_17'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => generadorAsterisco($lblTM), "id" => "_celular" ,"reemplazo" => "");
                $form2['form_12'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => generadorAsterisco("User"), "id" => "_user" ,"reemplazo" => '');
                $form2['form_13'] = array("elemento" => "caja" ,"tipo" => "Password" , "titulo" => generadorAsterisco("Contraseña"), "id" => "_contraseña" ,"reemplazo" =>'');
                $form2['form_14'] = array("elemento" => "caja" ,"tipo" => "Password" , "titulo" => generadorAsterisco("Confirmar"), "id" => "_confirmar" ,"reemplazo" => ''); 
                $form['form_11'] = array("elemento" => "combo","change" => "","titulo" => $lblEstado, "id" => "_estado", "option" => generadorComboEstado('Activo'));   
                $form['form_12'] =  array("elemento" => "combo","change" => "","titulo" => $lblPais, "id" => "_pais", "option" => $listapais);
                $form['form_18'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => generadorAsterisco("Esposa"), "id" => "_esposa" ,"reemplazo" => '');
                $form['form_19'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => generadorAsterisco("Hijos"), "id" => "_hijos" ,"reemplazo" => '');
                //echo $formDatosPersonales= generadorFormularios(NULL,NULL,$form, $boton,$cabecera);
                
                $resultado = str_replace("{contenedor_1}", generadorEtiqueta($form),  getPage('page_detalle_crear') );//generadorContMultipleRow($colum));      
                $resultado = str_replace("{boton}", generadorBoton($boton), $resultado);  
                $resultado = str_replace("{cabecera}", "Crear Usuario", $resultado);
                $resultado = str_replace("{contenedor_2}", generadorEtiqueta($form2), $resultado );//generadorContMultipleRow($colum));      
            
                echo $resultado;
                
            break;
            case 'KEY_ACTUALIZAR':///////////////////////////////////////////////////////////             
                   if(!empty($_POST['_id']) && !empty($_POST['_nombre']) && !empty($_POST['_apellido'])  
                        && !empty($_POST['_perfil'] ) && !empty($_POST['_correo'] ) &&  !empty($_POST['_celular'] )&&  !empty($_POST['_pais'] )){ 
                       
//                        if($_POST['_sede'] == 'x'){
//                            $data = array("success" => "false", "priority"=>'warning', "msg" => 'Debes seleccionar una Sede!');  
//                            echo json_encode($data); 
//                            exit();
//                        }   
                          
                        $objUsuario= new Usuario();
                        $comp= $objUsuario->setActualizarUsuario2($_POST['_id'] ,$_POST['_nombre'], $_POST['_apellido'], $_POST['_tipo_p'] ,
                                'a', $_POST['_fn'], $_POST['_genero'], $_POST['_perfil'], $_POST['_estado'], $_SESSION['user_id_ben'], $_POST['_correo']
                                ,$_POST['_telefono'], $_POST['_celular'], '1', $_POST['_pais'], $_POST['_esposa'], $_POST['_hijos']); 
                        
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
                           && !empty($_POST['_perfil'] )&& !empty($_POST['_user'] )
                            && !empty($_POST['_contraseña'] )&& !empty($_POST['_confirmar'] )
                            && !empty($_POST['_correo'] )&& !empty($_POST['_telefono'] )&& !empty($_POST['_celular'] )&& !empty($_POST['_pais'] )){ 
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
                            $comp= $objUsuario->setGrabarUsuario($_POST['_nombre'], $_POST['_apellido'], $_POST['_tipo_p'],'a', $_POST['_fn'], 
                                $_POST['_genero'], $_POST['_user'] , $hash, $_POST['_perfil'],$_POST['_estado'],  $_SESSION['user_id_ben'],$_POST['_correo']
                                ,$_POST['_telefono'],$_POST['_celular'],$salt,'1',$_POST['_pais']);  
                            
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
            case 'KEY_SHOW_FORM_DETALLE':
                if(!empty($_POST['id']) ){ 

                    $objUsuario= new Usuario();
                    $resultset= $objUsuario->getUser($_POST['id'], '');
                    if($row = $resultset->fetch_assoc()) { 
                        if (file_exists("../../public_html/i/".$_POST['id'].".jpg")) {
                            $tabla1['t_0'] = array("t_1" => cargarImagen("../../i/".$_POST['id'].".jpg"), "t_2" => "");                            
                        } else {
                            $tabla1['t_0'] = array("t_1" => cargarImagen(""), "t_2" => "");
                            
                        }
                        $tabla1['t_1'] = array("t_1" => generadorNegritas($lblNombre), "t_2" => $row['per_nombre']);
                        $tabla1['t_2'] = array("t_1" => generadorNegritas($lblApellido), "t_2" => $row['per_apellido']);
                        $tabla1['t_3'] = array("t_1" => generadorNegritas($lblPerfil), "t_2" => $row['perfil_des']);
                        $tabla1['t_4'] = array("t_1" => generadorNegritas($lblEstado), "t_2" => ($row['usu_estado'] == 'A') ? 'ACTIVO' : 'INACTIVO');
                        
                        
                       
                        //$tabla2['t_1'] = array("t_1" => generadorNegritas($lblIdentificacion), "t_2" => $row['per_identificacion']);
                        if($row['per_tipo']=='J'){$tabla2['t_2'] = array("t_1" => generadorNegritas($lblTipoPersona), "t_2" => "Jurídica");} 
                        if($row['per_tipo']=='N'){$tabla2['t_2'] = array("t_1" => generadorNegritas($lblTipoPersona), "t_2" => "Natural");} 
                        $tabla2['t_3'] = array("t_1" => generadorNegritas($lblFNacimiento), "t_2" => getFormatoFechadmy($row['per_fechanacimiento']));
                        $tabla2['t_4'] = array("t_1" => generadorNegritas($lblGenero), "t_2" => $row['per_genero']);
                        
                        
                        $tabla3['t_3'] = array("t_1" => generadorNegritas($lblTF), "t_2" =>  $row['fijo']);
                        $tabla3['t_4'] = array("t_1" => generadorNegritas($lblTM), "t_2" =>  $row['movil']);
                        $tabla3['t_5'] = array("t_1" => generadorNegritas($lblCorreo), "t_2" => $row['correo']);
            
                        $tabla4['t_16'] = array("t_1" => generadorNegritas($lblFRegistro), "t_2" => getFormatoFechadmyhis($row['usu_fecharegistro']));
                        $tabla4['t_17'] = array("t_1" => generadorNegritas($lblFModificacion), "t_2" => getFormatoFechadmyhis($row['usu_fechamodificacion']));
                        $tabla4['t_18'] = array("t_1" => generadorNegritas($lblUModificar), "t_2" => $row['modificador']);
                    }
                     
                    $boton['boton_1'] = array("elemento" => "boton" ,"modal" => "" ,"color" => "btn-info" ,"click" => "getActualizar(".$_POST['id'].")" ,"titulo" => $lblbtnEditar ,"lado" => "pull-right" ,"icono" => "fa-pencil"); 
                    $boton['boton_2'] = array("elemento" => "boton" ,"modal" => "" ,"color" => "btn-info" ,"click" => "getRecargar()" ,"titulo" => $lblbtnRegresar ,"lado" => "" ,"icono" => "fa-mail-reply");

                    $resultado = str_replace("{contenedor_1}", generadorTabla_2($tabla1, "table-striped"), getPage('page_detalle'));
                    $resultado = str_replace("{contenedor_2}", generadorTabla_2($tabla2, "table-striped"), $resultado); 
                    $resultado = str_replace("{contenedor_3}", generadorTabla_2($tabla3, "table-striped"), $resultado); 
                    $resultado = str_replace("{contenedor_4}",generadorTabla_2($tabla4, "table-striped"), $resultado); 
                    $resultado = str_replace("{boton}", generadorBoton($boton), $resultado); 
                                        
                    //setDatosConexion($_SESSION['user_subasedatos']);
                    echo $resultado;
                }
             break;
            case 'KEY_ENVIAR_CORREO_INDIVIDUAL':
                 
                if( !empty($_POST['_email_asunto'])  
                        && !empty($_POST['_email_mensaje'])  && !empty($_POST['_email_key'])) {
                    if($_POST['_email_key'] == '1'){
                        $mail= new Mail();
                        $msg= $mail->enviar($_SESSION['user_name'],$_SESSION['user_correo'],$_POST['_email_asunto'],$_POST['_email_mensaje'], $_POST['_correo_receptor'], FALSE); 
                        $data = array("success" => "true", "priority"=>'success', "msg" => $msg);  
                        echo json_encode($data);
                        
                    }elseif($_POST['_email_key'] == '2'){
                        $msg = enviarCorreoForumLeader($_POST['_email_asunto'], $_POST['_email_mensaje']) ;
                        $data = array("success" => "true", "priority"=>'success', "msg" => $msg);  
                        echo json_encode($data);
                        
                    }
                }else{
                    $data = array("success" => "false", "priority"=>'info', "msg" => 'Faltan campos por llenar!');  
                    echo json_encode($data);
                }      

                break; 
            
        endswitch;    
    } catch (Exception $exc) { echo getError($exc);}  
    
     exit(); 
}



////////////////////////////////////////////////////////////////////////////////

 
$t='';
if(isset($_GET['_tipo_usuario'])){
    if($_GET['_tipo_usuario'] == '1' || $_GET['_tipo_usuario'] == '3'){
        $_SESSION['_tipo_usuario']= $_GET['_tipo_usuario'];
        $titulo= '';
        $cuerpo='';
        $cont=1;
        $objSede = new Sede();
        $datasede = $objSede->getSedeByUser($_SESSION['user_id_ben']);
        if ($row = $datasede->fetch_assoc()) {
            $lasede = $row['sede_id'];
        }
        if($_GET['_tipo_usuario'] == '1'){
            $objUsuario= new Usuario();
            if ($_SESSION['user_user']=='admin') {
                $resultset= $objUsuario->getUsuarios();
            } else {
                $resultset= $objUsuario->getUsuariosBySede($lasede);
            }
            
            $titulo= 'Usuarios';
            while($row = $resultset->fetch_assoc()) { 
                $cuerpo.= generadorTablaFilas(array(
                     "<center>".$cont."</center>",
                    generadorLink($row['per_nombre'].' '.$row['per_apellido'],'getActualizar('.$row['usu_id'].')'),
                    $row['perfil_des'],
                    $row['movil'],
                    $row['correo'],
					$row['usu_user'],
                    $row['usu_estado']));  
                $cont=$cont + 1; 
             }  
         $t= generadorTabla_(1, $titulo,'getCrear()', array("N°", "Nombre","Perfil","Móvil","Correo","Alias","Estado"), $cuerpo);
         
        }elseif ($_GET['_tipo_usuario'] == '3') {
            $objForumLeader= new ForumLeader();
            $resultset= $objForumLeader->getForumLeader2('', '');
            $titulo= 'Forum Leader';
            while($row = $resultset->fetch_assoc()) { 
                $nombre= $row['per_nombre'].' '.$row['per_apellido'];
                $funcion_1= "getEnviarCorreoIndividual('".$row['correo']."','". $nombre ."',1)";
                $funcion_3= "getEnviarCorreoWithAdjunto('".$row['correo']."','". $nombre ."',1)";
                $cuerpo.= generadorTablaFilas(array(
                     "<center>".$cont."</center>",
                    generadorLink($row['per_nombre'].' '.$row['per_apellido'],'getDetalle('.$row['usu_id'].')'),
                    $row['perfil_des'],
                    $row['correo'],
                    $row['usu_estado'],
                    "<center>".getAccionesParametrizadas($funcion_1,"modal_enviarCorreo","Enviar Correo" , "fa fa-envelope-o").
                    '&nbsp;&nbsp;'.getAccionesParametrizadas($funcion_3,"modal_enviarContacto","Enviar Correo + Contacto" , "fa fa-user")."</center>"));  
                $cont=$cont + 1; 
             }
               $funcion_2= "getEnviarCorreoIndividual('','Forum Leader',2)";
                $boton['boton_1'] = array("elemento" => "boton" ,"modal" => "#modal_enviarCorreo"  ,"color" => "btn-info" ,"click" => $funcion_2 ,"titulo" => "Forum Leader" ,"lado" => "pull-right" ,"icono" => "fa-envelope");
                $boton['boton_2'] = array("elemento" => "boton" ,"modal" => ""  ,"color" => "btn-info" ,"click" => 'getCrear()' ,"titulo" => "" ,"lado" => "pull-right" ,"icono" => "fa-plus");
                //
                $t= generadorTablaConBotones_(1,$titulo,'_', array( "N°", "Nombre","Perfil","Correo","Estado", "Acción"), $cuerpo, $boton);   
        }
      

         
    }else{
        $t= getAlertNoPage();
    }

} else {
    $t= getAlertNoPage();
}


//Para los correos con adjuntos
$objMiembro = new Miembro();
$lista_miembro = $objMiembro->getListaMiembros(NULL, NULL,NULL, FALSE);

$form4['form_2'] = array("elemento" => "combo","change" => "", "titulo" => "Miembros", "id" => "_lista_miembros", "option" => $lista_miembro);
$html_lista_miembros= generadorEtiquetaVVertical($form4);
 
$lista['lista']= array("value" => 'x',  "select" => "Selected" ,"texto" => 'Seleccione...');
$objEmpresaLocal= new EmpresaLocal();
$lista = $objEmpresaLocal->getListaContacto(NULL,$lista);
$form['form_2'] = array("elemento" => "combo", "change" => "", "titulo" => "Contactos", "id" => "_lista_contacto", "option" => $lista);
$html_lista_contacto= generadorEtiquetaVVertical($form);


