<?php 
require_once MODELO.'Grupo.php';
require_once MODELO.'ForumLeader.php';
require_once MODELO.'Industria.php';
require_once MODELO.'Miembro.php';
require_once MODELO.'EmpresaLocal.php';
require_once MODELO.'Miembro.php';
include(HTML."/html.php");
include(HTML."/html_filtros.php");
require_once E_LIB.'Mail.php';
include(HTML."/html_2.php");
$objGrupo;
$objForum;
$listaGrupos= array();
$idPrimerGrupo='';
$tabla_miembros;
$tabla_grupos;
$lista_miembro= array();
function getTablaGrupos() {
    $objGrupo = new Grupo();
    $resultset = $objGrupo->getListaGrupos3();
    $cont = 1;
    $cuerpo = "";
    $datos = array();
    while ($row = $resultset->fetch_assoc()) {
        $verDetalle = "getDetalleFiltroGrupo(".$row['gru_id'].")";
        $cuerpo.= generadorTablaFilas(
            array(
                "<center>" . $cont . "</center>",
                generadorLink($row['gru_descripcion'], $verDetalle)
            )
        );
        $cont = $cont + 1;         
        
    }
    $tabla_grupos= generadorTablaConBotones_Grupos(1,"Grupos ",'', array( "N°", "Grupo"), $cuerpo, $datos);      
    return $tabla_grupos;
}

function getTablaGruposByEmpresa($idEmpresa) {
    $objGrupo = new Grupo();
    $resultset = $objGrupo->getGrupoByEmpresa($idEmpresa);
    $cont = 1;
    $cuerpo = "";
    $datos = array();
    while ($row = $resultset->fetch_assoc()) {
        $verDetalle = "getDetalleFiltroGrupo(".$row['gru_id'].")";
        $cuerpo.= generadorTablaFilas(
            array(
                "<center>" . $cont . "</center>",
                generadorLink($row['gru_descripcion'], $verDetalle)
            )
        );
        $cont = $cont + 1;         
        
    }
    $tabla_grupos= generadorTablaConBotones_Grupos(1,"Grupos ",'', array( "N°", "Grupo"), $cuerpo, $datos);      
    return $tabla_grupos;
}

function getTablaGruposByIndustria($idIndustria) {
    $objGrupo = new Grupo();
    $resultset = $objGrupo->getGrupoByIndustria($idIndustria);
    $cont = 1;
    $cuerpo = "";
    $datos = array();
    while ($row = $resultset->fetch_assoc()) {
        $verDetalle = "getDetalleFiltroGrupo(".$row['gru_id'].")";
        $cuerpo.= generadorTablaFilas(
            array(
                "<center>" . $cont . "</center>",
                generadorLink($row['gru_descripcion'], $verDetalle)
            )
        );
        $cont = $cont + 1;                 
    }

    $tabla_grupos= generadorTablaConBotones_Grupos(1,"Grupos ",'', array( "N°", "Grupo"), $cuerpo, $datos);      
    return $tabla_grupos;
}

function getTablaGruposByForumLeader($idForumLeader) {
    $objGrupo = new Grupo();
    $resultset = $objGrupo->getGrupoByForumLeader($idForumLeader);
    $cont = 1;
    $cuerpo = "";
    $datos = array();
    while ($row = $resultset->fetch_assoc()) {
        $verDetalle = "getDetalleFiltroGrupo(".$row['gru_id'].")";
        $cuerpo.= generadorTablaFilas(
            array(
                "<center>" . $cont . "</center>",
                generadorLink($row['gru_descripcion'], $verDetalle)
            )
        );
        $cont = $cont + 1;                 
    }

    $tabla_grupos= generadorTablaConBotones_Grupos(1,"Grupos ",'', array( "N°", "Grupo"), $cuerpo, $datos);      
    return $tabla_grupos;
}

function getDetalleGruposConMiembros($idGrupo) {
    global $lista_miembro, $perEnviarCorreoMisGruposOp7,$perEnviarCorreoTodosGruposOp7,$perEnviarCorreoGrupoMemoriaOp7 ;
    $cont=1;
	$nombre= '';
    $funcion_1= "";
    $funcion_2= "";
    $funcion_3= "";
    $funcion_4= "";
    $funcion_5= "";
        $cuerpo='';
        $objGrupo= new Grupo();
        $resultset= $objGrupo->getMiembrosActivosPorGrupo($idGrupo,'1');
         while($row = $resultset->fetch_assoc()) { 
            $nombre= $row['per_nombre'].' '.$row['per_apellido'];
            $funcion_1= "getEnviarCorreoIndividual('".$row['correo']."','".$nombre."',1)";
            $funcion_2= "getEnviarCorreoIndividual('".$row['correo']."','Grupo',2)";
            $funcion_3= "getEnviarCorreoWithAdjunto('".$row['correo']."','".$nombre."',1)";
            $funcion_4= "getEnviarCorreoIndividual('".$row['correo']."','Mis Grupos',3)";
            $funcion_5= "getEnviarCorreoIndividual('".$row['correo']."','Todos los Grupos',4)";
            $funcion_6= "getRecargar2()";
$verDetalle="getDetalle(".$row['mie_id'].",'')";
             $cuerpo.= generadorTablaFilas(array(
                 "<center>".$cont."</center>",
             //    generadorLink($row['per_nombre'].' '.$row['per_apellido'],'getDetalle_('.$row['mie_id'].')'),
				 generadorLink($row['per_nombre'].' '.$row['per_apellido'],$verDetalle),
               //  $row['per_nombre'].' '.$row['per_apellido'],
				 $row['correo'],
                 $row['movil'],
                 $row['nombre_empresa'],
                 "<center>".getAccionesParametrizadas($funcion_1,"modal_enviarCorreo","Enviar Correo" , "fa fa-envelope-o").
                            '&nbsp;&nbsp;'.getAccionesParametrizadas($funcion_3,"modal_enviarContacto","Enviar Correo + Contacto" , "fa fa-user")."</center>"));       //($funcion,$modal,$title,$icono)                                                                                   
            $lista_miembro['lista_'.$row['mie_id']] = array("value" => $row['mie_id'],  "select" => "" ,"texto" => $row['per_nombre']." ".$row['per_apellido']);
             $cont=$cont + 1;   
         }   
        $objGrupo= new Grupo();
        $boton= array();
		/*
		if (in_array($perEnviarCorreoTodosGruposOp7, $_SESSION['usu_permiso'])) {
            $boton['boton_1'] = array("elemento" => "boton" ,"modal" => "#modal_enviarCorreo"  ,"color" => "btn-info" ,"click" => $funcion_5 ,"titulo" => "Todos los Grupos" ,"lado" => "pull-right" ,"icono" => "fa-envelope");
        }
		*/
		if (($_SESSION['user_user']=='admin')||($_SESSION['user_country']=='*')) {
            $boton['boton_1'] = array("elemento" => "boton" ,"modal" => "#modal_enviarCorreo"  ,"color" => "btn-info" ,"click" => $funcion_5 ,"titulo" => "Todos los Grupos" ,"lado" => "pull-right" ,"icono" => "fa-envelope");
        }
        
        if (in_array($perEnviarCorreoMisGruposOp7, $_SESSION['usu_permiso'])) {
            $boton['boton_2'] = array("elemento" => "boton" ,"modal" => "#modal_enviarCorreo"  ,"color" => "btn-info" ,"click" => $funcion_4 ,"titulo" => "Enviar a mis Grupos" ,"lado" => "pull-right" ,"icono" => "fa-envelope");
        }
        if (in_array($perEnviarCorreoGrupoMemoriaOp7, $_SESSION['usu_permiso'])) {
            $boton['boton_3'] = array("elemento" => "boton" ,"modal" => "#modal_enviarCorreo"  ,"color" => "btn-info" ,"click" => $funcion_2 ,"titulo" => "Enviar a este grupo" ,"lado" => "pull-right" ,"icono" => "fa-envelope");
        }            

        $boton['boton_4'] = array("elemento" => "boton", "color" => "btn-info", "click" => $funcion_6, "titulo" => "Regresar" ,"lado" => "pull-right" ,"icono" => "fa-mail-reply");
        $tabla_miembros= generadorTablaConBotones_(1,"Forum Leader: ". $objGrupo->getNombreForum_($idGrupo),'getCrear_()', array( "N°", "Nombre","Correo", "Teléfono","Empresa" , "Acción"), $cuerpo, $boton);      

        return $tabla_miembros;
}
function enviarCorreoGrupo($idGrupo, $asunto,  $mensaje, $key) {
    $cont=0;
    $destinatarios=array();
    $objGrupos= new Grupo();
    $resultset= $objGrupos->getMiembrosActivosPorGrupo($idGrupo,$key);
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
            case 'KEY_DETALLE_FILTRO_GRUPO'://///////////////////////////////////////////////////////// 
                if(!empty($_POST['idGrupo']) ){         
                    echo getDetalleGruposConMiembros($_POST['idGrupo']);
                    exit();            
                }
                break;
            case 'KEY_FILTRO_EMPRESA':
                if (! empty($_POST['_id'])) {
                    echo getTablaGruposByEmpresa($_POST['_id']);                    
                }
                break;
            case 'KEY_FILTRO_FORUM_LEADER':
                if (! empty($_POST['_id'])) {
                    echo getTablaGruposByForumLeader($_POST['_id']);
                }
                break;
            case 'KEY_FILTRO_INDUSTRIA':
                if (! empty($_POST['_id'])) {
                    echo getTablaGruposByIndustria($_POST['_id']);
                }                
                break;
            case 'KEY_ENVIAR_CORREO_INDIVIDUAL':
                 //!empty($_POST['_correo_receptor']) &&
                if( !empty($_POST['_email_asunto']) && !empty($_POST['_grupo']) 
                        && !empty($_POST['_email_mensaje'])  && !empty($_POST['_email_key'])) {
                    if($_POST['_email_key'] == '1'){
                        $mail= new Mail();
                        $msg= $mail->enviar($_SESSION['user_name'],$_SESSION['user_correo'],$_POST['_email_asunto'],$_POST['_email_mensaje'], $_POST['_correo_receptor'], FALSE); 
                        $data = array("success" => "true", "priority"=>'success', "msg" => $msg);  
                        echo json_encode($data);
                        
                    }elseif($_POST['_email_key'] == '2'){
                        $msg = enviarCorreoGrupo($_POST['_grupo'],$_POST['_email_asunto'], $_POST['_email_mensaje'], '1') ;
                        $data = array("success" => "true", "priority"=>'success', "msg" => $msg);  
                        echo json_encode($data);
                        
                    }elseif($_POST['_email_key'] == '3'){
                        $msg = enviarCorreoGrupo($_SESSION['user_id_ben'],$_POST['_email_asunto'], $_POST['_email_mensaje'], '2') ;
                        $data = array("success" => "true", "priority"=>'success', "msg" => $msg);  
                        echo json_encode($data);
                        
                    }elseif($_POST['_email_key'] == '4'){
                        $msg = enviarCorreoGrupo($_SESSION['user_id_ben'],$_POST['_email_asunto'], $_POST['_email_mensaje'], '3') ;
                        $data = array("success" => "true", "priority"=>'success', "msg" => $msg);  
                        echo json_encode($data);
                        
                    }
                }else{
                    $data = array("success" => "false", "priority"=>'info', "msg" => 'Faltan campos por llenar!');  
                    echo json_encode($data);
                }      

                break; 
                
                case 'KEY_ADD_DATOS_MIEMBRO'://///////////////////////////////////////////////////////// 
                
                if( !empty($_POST['_key'])){ 
                    if($_POST['_key'] == '1'){
                        $objMiembro= new Miembro();
                        $resultset= $objMiembro->getSmAgregarDatos($_SESSION['user_id_ben'],'4');
                        if($row = $resultset->fetch_assoc()) {
                            $html ='Miembro: '.$row['nombre'].'</br>';
                            //$html .='Empresa: '.$row['nombre_empresa'].'</br>';
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

    
        endswitch;    
    } catch (Exception $exc) { echo getError($exc);}  
    
     exit(); 
}




$t= '';
if (in_array($perVertodoslosGruposOp7, $_SESSION['usu_permiso'])) {
    
    $objGrupo= new Grupo();
    $listaGrupos= $objGrupo->getListaGrupos(NULL);
    $tabla_grupos = getTablaGrupos();
    //$tabla_miembros= getDetalleGruposConMiembros($objGrupo->getPrimerGrupo()); 
    $t=getTablaFiltro($listaGrupos,$tabla_grupos );
    
 }  elseif (in_array($perVerGruposIDForumOp7, $_SESSION['usu_permiso'])) {
     
    $objForum = new ForumLeader();
    $idPrimerGrupo= $objForum->getIdPrimerGruposDePrivilegioForumLeader($_SESSION['user_id_ben']);
    //$tabla_miembros= getDetalleGruposConMiembros($idPrimerGrupo);      
    
    $objGrupo= new Grupo();
    $listaGrupos= $objGrupo->getListaGruposForum($_SESSION['user_id_ben'], NULL, NULL); 
    $t=getTablaFiltro($listaGrupos,$tabla_grupos );
}




function getTablaFiltro($listaGrupos= array(),$tabla_grupos='' ) {
    $lista['lista_']= array("value" => "x",  "select" => "" ,"texto" => "Seleccione..."); 
    $objEmpresaLocal = new EmpresaLocal();
    $listaEmpresas = $objEmpresaLocal->getListaEmpresa2("", $lista);
    $objForumLeader = new ForumLeader();
    $listaForumLeaders = $objForumLeader->getListaForumLeaders2("", $lista);
    $objIndustria = new Industria();
    $listaIndustrias = $objIndustria->getListaIndustrias2("", $lista);
    $form['form_2'] = array("elemento" => "combo","change" => "getFiltroEmpresa()", "titulo" => "Empresas", "id" => "_empresa", "option" => $listaEmpresas);   
    $form['form_3'] = array("elemento" => "combo","change" => "getFiltroForumLeader()", "titulo" => "Forum Leader", "id" => "_forum_leader", "option" => $listaForumLeaders);   
    $form['form_4'] = array("elemento" => "combo","change" => "getFiltroIndustria()", "titulo" => "Industria", "id" => "_industria", "option" => $listaIndustrias);   
    $resultado = str_replace("{fitros}", generadorEtiquetasFiltro($form), generadorFiltro('Filtros','ben_contenedor')); 
    $resultado = str_replace("{cuerpo}", $tabla_grupos, $resultado); 
    $resultado = str_replace("{contenedor_4}",'', $resultado);   
    return $resultado;


}

 $form4['form_2'] = array("elemento" => "combo","change" => "", "titulo" => "Miembros", "id" => "_lista_miembros", "option" => $lista_miembro);
 $html_lista_miembros= generadorEtiquetaVVertical($form4);
 
$lista['lista']= array("value" => 'x',  "select" => "Selected" ,"texto" => 'Seleccione...');
$objEmpresaLocal= new EmpresaLocal();
$lista = $objEmpresaLocal->getListaContacto(NULL,$lista);
$form['form_2'] = array("elemento" => "combo", "change" => "", "titulo" => "Contactos", "id" => "_lista_contacto", "option" => $lista);
$html_lista_contacto= generadorEtiquetaVVertical($form);
              

