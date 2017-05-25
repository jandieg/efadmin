<?php 
require_once MODELO.'Correo.php';
require_once MODELO.'Telefono.php';
require_once MODELO.'RedSocialMiembro.php';
require_once MODELO.'Direccion.php';
require_once MODELO.'EmpresaLocal.php';
require_once(LENGUAJE."/lenguaje_1.php");
require_once MODELO.'Grupo.php';
require_once MODELO.'Miembro.php';
include(HTML."/html.php");
include(HTML."/html_2.php");
require_once E_LIB.'Mail.php';


function getCorreoMiGrupo($asunto, $mensaje) {
        $destinatarios=array();
        $cont=0;
        $objMiembro= new Miembro();
        $resultset= $objMiembro->getCorreosMiGrupo($_SESSION['user_id_ben']);
        while($row = $resultset->fetch_assoc()) {
            $destinatarios[$cont]= $row['correo'];  
            $cont= $cont + 1;

        }
        $mail= new Mail(); 
        $comp= $mail->enviarMultiple($_SESSION['user_name'],$_SESSION['user_correo'], $asunto, $mensaje, FALSE, $destinatarios);

        return $comp;
    
    
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    try{
        switch ($_POST['KEY']):  
            case 'KEY_ENVIAR_CORREO_INDIVIDUAL':
                 
                if(!empty($_POST['_correo_receptor']) && !empty($_POST['_email_asunto']) 
                        && !empty($_POST['_email_mensaje'])  && !empty($_POST['_email_key'])) {
                    if($_POST['_email_key'] == '1'){
                        $mail= new Mail();
                        $msg= $mail->enviar($_SESSION['user_name'],$_SESSION['user_correo'],$_POST['_email_asunto'],$_POST['_email_mensaje'], $_POST['_correo_receptor'], FALSE); 
                        $data = array("success" => "true", "priority"=>'success', "msg" => $msg);  
                        echo json_encode($data);
                    }else{
                        $msg = getCorreoMiGrupo($_POST['_email_asunto'], $_POST['_email_mensaje']) ;
                        $data = array("success" => "true", "priority"=>'success', "msg" => $msg);  
                        echo json_encode($data);
                    }
                }else{
                    $data = array("success" => "false", "priority"=>'info', "msg" => 'Faltan campos por llenar!');  
                    echo json_encode($data);
                }      

                break; 
            
            case 'KEY_ENVIAR_CORREO_ADJUNTO':
                 
                if(!empty($_POST['_correo_receptor']) && !empty($_POST['_email_asunto']) 
                        && !empty($_POST['_email_mensaje'])  && !empty($_POST['_email_key'])) {
                        $mail= new Mail();
                        $msg= $mail->enviar($_SESSION['user_name'],$_SESSION['user_correo'],$_POST['_email_asunto'],$_POST['_email_mensaje'], $_POST['_correo_receptor'], FALSE); 
                        $data = array("success" => "true", "priority"=>'success', "msg" => $msg);  
                        echo json_encode($data);
                   
                }else{
                    $data = array("success" => "false", "priority"=>'info', "msg" => 'Faltan campos por llenar!');  
                    echo json_encode($data);
                }      

                break;
                
                
            case 'KEY_ADD_DATOS_MIEMBRO'://///////////////////////////////////////////////////////// 
                
                if( !empty($_POST['_key'])){ 
                    if($_POST['_key'] == '1'){
                        $objMiembro= new Miembro();
                        $resultset= $objMiembro->getSmAgregarDatos($_SESSION['user_id_ben'],'1');
                        if($row = $resultset->fetch_assoc()) {
                            $html ='Miembro: '.$row['nombre'].'</br>';
                            $html .='Empresa: '.$row['nombre_empresa'].'</br>';
                            $html .='Móvil: '.$row['movil'].'</br></br>';
                        }
                        echo $html;
                    }elseif ($_POST['_key'] == '2') {
                        $objMiembro= new Miembro();
                        $resultset= $objMiembro->getSmAgregarDatos($_POST['_id'],'2');
                        if($row = $resultset->fetch_assoc()) {
                            $html ='Miembro: '.$row['nombre'].'</br>';
                            $html .='Empresa: '.$row['nombre_empresa'].'</br>';
                            $html .='Móvil: '.$row['movil'].'</br></br>';
                        }
                        echo $html;
                    }elseif ($_POST['_key'] == '3') {
                        $objMiembro= new Miembro();
                        $resultset= $objMiembro->getSmAgregarDatos($_POST['_id'],'3');
                        if($row = $resultset->fetch_assoc()) {
                            $html ='Contacto: '.$row['nombre'].'</br>';
                            $html .='Cargo: '.$row['cargo'].'</br>';
                            $html .='Empresa: '.$row['nombre_empresa'].'</br>';
                            $html .='Móvil: '.$row['movil'].'</br></br>';
                        }
                        echo $html;
                    }

               }
                  break;
              case 'KEY_SHOW_FORM_DETALLE'://///////////////////////////////////////////////////////// 
                 if( !empty($_POST['id_miembro'])){ 
                    $objMiembro= new Miembro();
                    $resultset= $objMiembro->getMiembro1($_POST['id_miembro']);  
                    if($row = $resultset->fetch_assoc()) {  
                        $prefijoPais='';        
                        $idpersona=$row['per_id'];
                        $titulo=$row['per_nombre'].' '.$row['per_apellido'];
                        $empresa=$row['emp_nombre'];
                        $direcionsql= new Direccion();
                        $resultset_direcionsql= $direcionsql->getDireccion($row['per_id']); 
    
                        if ($row_direcionsql = $resultset_direcionsql->fetch_assoc()) {
                            $prefijoPais=$row_direcionsql['pai_prefijo'];
                        }
        
        
                        $objCorreo= new Correo();
                        $correo_1= $objCorreo->getCorreoPersonalSecundario($idpersona, 'Personal');
                        $correo_2= $objCorreo->getCorreoPersonalSecundario($idpersona, NULL);

                        $objTelefono= new Telefono();
                        $t_fijo= $objTelefono->getTelefonoTipo($idpersona, 'C');
                        $t_movil= $objTelefono->getTelefonoTipo($idpersona, 'M');

                        $objRedSocial= new RedSocialMiembro();
                        $redSkype=$objRedSocial->getNombreRedSocial($row['mie_id'], "skype");
                        $redTwitter=$objRedSocial->getNombreRedSocial($row['mie_id'], "twitter");


                        $tabla['t_0'] = array("t_1" => generadorNegritas("Grupo ID"), "t_2" => $row['gru_descripcion']);
						$tabla['t_1'] = array("t_1" => generadorNegritas("Código"), "t_2" => $row['mie_codigo']);
                        $tabla['t_2'] = array("t_1" => generadorNegritas($lblNombre), "t_2" => $titulo);
                        $tabla['t_3'] = array("t_1" => generadorNegritas($lblFNacimiento), "t_2" => $row['per_fechanacimiento']);
                        $tabla['t_4'] = array("t_1" => generadorNegritas($lblTitulo), "t_2" => $row['prof_descripcion']);
                        $tabla['t_8'] = array("t_1" => generadorNegritas($lblCorreo), "t_2" => $correo_1);
                        $tabla['t_9'] = array("t_1" => generadorNegritas($lblCorreoSecundario), "t_2" => $correo_2);
                        $tabla['t_11'] = array("t_1" => generadorNegritas($lblTF), "t_2" => "(". $prefijoPais.") ".$t_fijo);
                        $tabla['t_12'] = array("t_1" => generadorNegritas($lblTM), "t_2" => "(". $prefijoPais.") ".$t_movil);
                        $tabla['t_13'] = array("t_1" => generadorNegritas($lblSkype), "t_2" => $redSkype);
                        $tabla['t_14'] = array("t_1" => generadorNegritas($lblTwitter), "t_2" => $redTwitter);


                        $tabla2['t_4'] = array("t_1" => generadorNegritas($lblEmpresa), "t_2" => $row['emp_nombre']);
                        $tabla2['t_5'] = array("t_1" => generadorNegritas($lblCategoría), "t_2" => $row['cat_descripcion']);
                        $tabla2['t_6'] = array("t_1" => generadorNegritas($lblSitioWeb), "t_2" => $row['emp_sitio_web']);
                        $tabla2['t_7'] = array("t_1" => generadorNegritas($lblNEmpleados), "t_2" => $row['emp_num_empleados']);
                        $tabla2['t_8'] = array("t_1" =>generadorNegritas($lblIngresosAnuales), "t_2" => $row['emp_imgresos']);
                        $tabla2['t_9'] = array("t_1" => generadorNegritas($lblFax), "t_2" => $row['emp_fax']);
                        
                        $objEmpresaLocal= new EmpresaLocal();
                        $resultset2= $objEmpresaLocal->getEmpresaLocalIndustrias($row['emp_id']);              
                        $con=1;
                        while ($row2 = $resultset2->fetch_assoc()) { 
                            if($con == 1){
                                $tabla2['t_10'.$con] = array("t_1" => generadorNegritas($lblSectores), "t_2" => $row2['ind_descripcion']);
                            }else{
                                $tabla2['t_10'.$con] = array("t_1" => "", "t_2" => $row2['ind_descripcion']);
                            }     
                          $con=$con+1;
                        }   


                      
                        $boton['boton_5'] = array("elemento" => "boton" ,"modal" => "" ,"color" => "btn-info" ,"click" => "getRecargar()" ,"titulo" => $lblbtnRegresar ,"lado" => "" ,"icono" => "fa-mail-reply");

                        $resultado = str_replace("{contenedor_3}", generadorTabla_2($tabla, "table-striped"), getPage('page_detalle') ); 
                        $resultado = str_replace("{contenedor_4}", generadorTabla_2($tabla2, "table-striped"), $resultado); 
                        $resultado = str_replace("{boton}", generadorBoton($boton), $resultado);
                        
                        echo  $resultado;

                    } 
                    exit();
                }
                break;   

        endswitch;    
    } catch (Exception $exc) { echo getError($exc);}  
    
     exit(); 
}


$lista_miembro= array();
$grupo= new Grupo();
$cuerpo='';
$idForum='';
$cont=1;
$resultset= $grupo->getMiembroxGruposAllMiembros($_SESSION['user_id_ben']);
 while($row = $resultset->fetch_assoc()) { 
     if($idForum==''){ $idForum=$row['forum_usu_id']; }  
     $nombre= $row['per_nombre'].' '.$row['per_apellido'];
     $funcion_1= "getEnviarCorreoIndividual('".$row['correo']."','".$nombre."',1)";
     $funcion_2= "getEnviarCorreoIndividual('".$row['correo']."','Mi Grupo',2)";
     $funcion_3= "getEnviarCorreoWithAdjunto('".$row['correo']."','".$nombre."',1)";
     
     $cuerpo.= generadorTablaFilas(array(
        "<center>".$cont."</center>",
         generadorLink($nombre,'getDetalle('.$row['mie_id'].')'),
         $row['correo'],
         $row['movil'],
         $row['nombre_empresa'],
         "<center>".getAccionesParametrizadas($funcion_1,"modal_enviarCorreo","Enviar Correo" , "fa fa-envelope-o").
                    '&nbsp;&nbsp;'.getAccionesParametrizadas($funcion_3,"modal_enviarContacto","Enviar Correo + Contacto" , "fa fa-user")."</center>"));       //($funcion,$modal,$title,$icono)                                                                                   
     $lista_miembro['lista_'.$row['mie_id']] = array("value" => $row['mie_id'],  "select" => "" ,"texto" => $row['per_nombre']." ".$row['per_apellido']);
     $cont=$cont + 1;  
     
}   
 $boton['boton_1'] = array("elemento" => "boton" ,"modal" => "#modal_enviarCorreo"  ,"color" => "btn-info" ,"click" => $funcion_2 ,"titulo" => "Enviar Correo Grupo" ,"lado" => "pull-right" ,"icono" => "fa-users");
 $grupo= new Grupo();
 $tabla_miembros= generadorTablaConBotones_(1, $grupo->getNombre($idForum),'getCrear_()', array("N°", "Nombre","Correo", "Teléfono","Empresa",  "Acción"), $cuerpo, $boton);      
 $t= $tabla_miembros;

 $form4['form_2'] = array("elemento" => "combo","change" => "", "titulo" => "Miembros", "id" => "_lista_miembros", "option" => $lista_miembro);
 $html_lista_miembros= generadorEtiquetaVVertical($form4);
 
$lista['lista']= array("value" => 'x',  "select" => "Selected" ,"texto" => 'Seleccione...');
$objEmpresaLocal= new EmpresaLocal();
$lista = $objEmpresaLocal->getListaContacto(NULL,$lista);
$form['form_2'] = array("elemento" => "combo","change" => "", "titulo" => "Contactos", "id" => "_lista_contacto", "option" => $lista);
$html_lista_contacto= generadorEtiquetaVVertical($form);