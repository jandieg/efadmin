<?php 
require_once MODELO.'TipoEvento.php';
require_once MODELO.'Miembro.php';
require_once MODELO.'Grupo.php';
require_once MODELO.'Participante.php';
require_once MODELO.'Evento.php';
require_once MODELO.'Direccion.php';
require_once MODELO.'Aconpanamiento.php';
require_once MODELO.'EmpresariosMes.php';
require_once MODELO.'TipoEvento.php';
require_once MODELO.'GeneradorID.php';
require_once MODELO.'ForumLeader.php';

require_once MODELO.'Pais.php';
require_once MODELO.'Provincia.php';
require_once MODELO.'Ciudad.php';
require_once MODELO.'Asistencia.php';

require_once E_LIB.'Mail.php';
include(HTML."/html_2.php");
include(HTML."/html.php");
include(HTML."/html_combos.php");
include(HTML."/html_filtros.php");
include(LENGUAJE."/lenguaje_1.php");
$settings = parse_ini_file(E_LIB."settings.ini.php");
$asunto= "";$tabla= "";$correo= "";

function getCheckEventos($id,$nombre, $checked) {
    $msg='';
    $msg='<center><input  type="checkbox" '.$checked.' onclick="getAddListaEvento(\''.$id.'\',\''.$nombre.'\')"/></center>'; 
    return $msg;
}
function getFiltroGruposEvento() {
    global $perVerFiltrosIDForumOp10,$perVerFiltrosIDIBPLimitadoOp10;
    $cuerpo='';
    
    //Para que aparezcan los grupos, perfil de cobranza
    if (!in_array($perVerFiltrosIDIBPLimitadoOp10, $_SESSION['usu_permiso'])) { 
        if (!in_array($perVerFiltrosIDForumOp10, $_SESSION['usu_permiso'])) {
            
            $cuerpo.= generadorTablaFilas(array(
                   getCheckEventos("T", "Todos los Grupos",""),
                   "Todos los Grupos",
                   ""));  
        }
        
        $cuerpo.= generadorTablaFilas(array(
               getCheckEventos("M", "Mis Grupos",""),
               "Mis Grupos",
               ""));  
    }  
    if (in_array($perVerFiltrosIDForumOp10, $_SESSION['usu_permiso'])) {  
        
        $objGrupos= new Grupo();
        $resultset= $objGrupos->getGruposForum($_SESSION['user_id_ben']);
         while($row = $resultset->fetch_assoc()) { 

             $cuerpo.= generadorTablaFilas(array(
                getCheckEventos($row['gru_id']."G", $row['gru_descripcion'],""),
                $row['gru_descripcion'],
                ""));                                                                            
        } 
    }else{//en caso que sea total el permiso
        $objGrupos= new Grupo();
        $resultset= $objGrupos->getGrupos();        
         while($row = $resultset->fetch_assoc()) { 

             $cuerpo.= generadorTablaFilas(array(
                getCheckEventos($row['gru_id']."G", $row['gru_descripcion'],""),
                $row['gru_descripcion'],
                $row['per_nombre'].' '.$row['per_apellido'])); 
         }
    }

    
    $miembro= new Miembro();
    $resultset= $miembro->getMiembros1();
     while($row = $resultset->fetch_assoc()) { 
         $nombre=$row['per_nombre']." ".$row['per_apellido'];
         $cuerpo.= generadorTablaFilas(array(
             getCheckEventos($row['mie_id']."-".$row['grupo_id']."M", $nombre,"")
             ,$row['per_nombre'].' '.$row['per_apellido'],
             $row['nombre_empresa']));                                                                            
    } 
  
    $t= generadorTablaModal(1, "Grupos y Miembros",'getCrear()', array( "Acción","Grupo / Miembros","Empresas / Forum Leader" ), $cuerpo);
    return $t;
}
function getFiltroGruposEvento2($misGruposChecked="",$todosGruposChecked="",$listaGrupo=  array(),$listaMiembros=  array() ) {//$checked
    global $perVerFiltrosIDForumOp10, $perVerFiltrosIDIBPLimitadoOp10;
    $cuerpo='';
     //Para que aparezcan los grupos, perfil de cobranza
    if (!in_array($perVerFiltrosIDIBPLimitadoOp10, $_SESSION['usu_permiso'])) { 
        if (!in_array($perVerFiltrosIDForumOp10, $_SESSION['usu_permiso'])) {
            $cuerpo.= generadorTablaFilas(array(
                   getCheckEventos("T", "Todos los Grupos",$todosGruposChecked),
                   "Todos los Grupos",
                   ""));  
        }
        $cuerpo.= generadorTablaFilas(array(
               getCheckEventos("M", "Mis Grupos",$misGruposChecked),
               "Mis Grupos",
               "")); 
    }
    
    if (in_array($perVerFiltrosIDForumOp10, $_SESSION['usu_permiso'])) {  
        $objGrupos= new Grupo();
        $resultset= $objGrupos->getGruposForum($_SESSION['user_id_ben']);
         while($row = $resultset->fetch_assoc()) { 
             $checked="";
              if (in_array($row['gru_id'], $listaGrupo)) {
                  $checked="checked";
              }

             $cuerpo.= generadorTablaFilas(array(
                getCheckEventos($row['gru_id']."G", $row['gru_descripcion'], $checked),
                $row['gru_descripcion'],
                ""));                                                                            
        }
    }else{//en caso que sea total el permiso
        $objGrupos= new Grupo();
        $resultset= $objGrupos->getGrupos();
         while($row = $resultset->fetch_assoc()) { 
             $checked="";
              if (in_array($row['gru_id'], $listaGrupo)) {
                  $checked="checked";
              }

             $cuerpo.= generadorTablaFilas(array(
                getCheckEventos($row['gru_id']."G", $row['gru_descripcion'], $checked),
                $row['gru_descripcion'],
                $row['per_nombre'].' '.$row['per_apellido']));                                                                            
        } 
    }

    
    $miembro= new Miembro();
    $resultset= $miembro->getMiembros1();
     while($row = $resultset->fetch_assoc()) { 
          $checked="";
          if (in_array($row['mie_id'], $listaMiembros)) {
              $checked="checked";
          }
          
         $nombre=$row['per_nombre']." ".$row['per_apellido'];
         $cuerpo.= generadorTablaFilas(array(
             getCheckEventos($row['mie_id']."-".$row['grupo_id']."M", $nombre,$checked)
             ,$row['per_nombre'].' '.$row['per_apellido'],
             $row['nombre_empresa']));                                                                            
    } 
  
    $t= generadorTablaModal(1, "Grupos y Miembros",'getCrear()', array( "Acción","Grupo / Miembros","Empresas / Forum Leader" ), $cuerpo);
    return $t;
}
//function getParticipantes($identificador, $tipo) {
//    $listaParticipantes= array();
//    $objParticipante= new Participante();
//    $id= "";
//    $id=$objParticipante->getUltimoParticipante_($identificador);
//    
//    //$objParticipante= new Participante();
//    $listaParticipantes= $objParticipante->getListaParticipantes($id,$identificador);
//    //'<option value="' + id + tipo + '" selected>' + nombre + '</option>'
//    $lista= generadorMultiListSelectOption($tipo, "",$listaParticipantes);
//    return $lista; 
//}
function getRecordarEvento($idEvento, $doAsistencia= false) {
    $_SESSION['evento_destinatarios']='';
    $objEvento= new Evento();
    $resultset= $objEvento->getEventosDetalle($idEvento);
    if($row = $resultset->fetch_assoc()) {

        $asunto="Recordatorio ". $row['eve_nombre']. " Executive Forums";         
        $mensaje  ="<br><b>Renaissance Executive Forums</b>"."<br>";
        $mensaje .="Evento: ". $row['eve_nombre']."<br> ";
        // .="Forum Leader: ". $row['eve_responsable']."<br> ";
        $mensaje .="Ubicación: ". $row['direccion']."<br>";
        $mensaje .="Inicio: ".getFormatoFechadmyhis($row['eve_fechainicio'])."<br> ";
        $mensaje .="Fin: ". getFormatoFechadmyhis($row['eve_fechafin'])."<br> ";
        $mensaje .="Descripción: ". $row['eve_descripcion']."<br> ";
        if($row['tip_eve_opcion_acompanado'] == '1'){
            $mensaje .="Acompañado por: ". $row['acompanado']."<br> ";
        }


        $banderaMigrupo= $row['eve_mis_grupos'];
        
        $msg_misgrupos="";//mis-grupos-miembros
        $msg_todosgrupos="";//todos-grupos-miembros
        $msg_todosgrupos_forum="";//todos-grupos-forum
        $msg_grupos_miembros="";//grupos-miembros
        $msg_miembros_adicionales="";//miembros
        $msg_grupos_forum="";//grupos-forum
        $msg_empresarios="";//empresarios
        $msg_invitados="";//invitado
        $msg_contacto="";//contacto

        ////////////////////////////////////////////////////////////////////////
        //Asistencia
        $listaGruposMiembros='';
        $listaMiembrosInvitados='';
        ////////////////////////////////////////////////////////////////////////

        $destinatarios=array();
        $cont=0;
        $objEvento= new Evento();
        $resultset= $objEvento->getEventoRecordarNotificar($idEvento);
        while($row = $resultset->fetch_assoc()) {
            
            ////////////////////////////////////////////////////////////////////////
            //Asistencia
            if($doAsistencia){
                if($row['key'] == "mis-grupos-miembros" || $row['key'] == "todos-grupos-miembros" || $row['key'] == "grupos-miembros"){    
                   $listaGruposMiembros .=$row['id'].",";

                }
//                elseif ($row['key'] == "miembros") {
//                    $listaMiembrosInvitados .= $row['id'].",";
//
//                }
            }
            ////////////////////////////////////////////////////////////////////////
            if($row['key']=="mis-grupos-miembros"){
                $msg_misgrupos .= $row['per_apellido']." ".$row['per_nombre'] . ", ";
				$destinatarios[$cont]= $row['correo'];

            }elseif($row['key']=="todos-grupos-miembros"){ 
                $msg_todosgrupos .= $row['per_apellido']." ".$row['per_nombre'] . ", ";
				$destinatarios[$cont]= $row['correo'];

            }elseif($row['key']=="todos-grupos-forum"){
                $msg_todosgrupos_forum .= $row['per_apellido']." ".$row['per_nombre'] . ", ";
				$destinatarios[$cont]= $row['correo'];

            }elseif($row['key']=="grupos-miembros"){ 
                $msg_grupos_miembros .= $row['per_apellido']." ".$row['per_nombre'] . ", ";
				$destinatarios[$cont]= $row['correo'];

            }elseif($row['key']=="miembros"){
                $msg_miembros_adicionales .= $row['per_apellido']." ".$row['per_nombre'] . ", ";

            }elseif($row['key']=="grupos-forum"){
                $msg_grupos_forum .= $row['per_apellido']." ".$row['per_nombre'] . ", ";
				$destinatarios[$cont]= $row['correo'];

            }elseif($row['key']=="empresarios"){ 
                $msg_empresarios .= $row['per_apellido']." ".$row['per_nombre'] . ", ";

            }elseif($row['key']=="invitado"){ 
                $msg_invitados .= $row['per_apellido']." ".$row['per_nombre'] . ", ";

            }elseif($row['key']=="contacto"){
                $msg_contacto .= $row['per_apellido']." ".$row['per_nombre'] . "<br>&nbsp;&nbsp;&nbsp; - Correo: ".$row['correo'] . "<br>&nbsp;&nbsp;&nbsp;  - Móvil: ".$row['movil']." <br>" ;

            }

            //$destinatarios[$cont]= $row['correo'];  
            $cont= $cont + 1;

        }

//        if($banderaMigrupo == "0"){
//            $mensaje .="<b>Forum Leader</b>"."<br>";
//            $mensaje .=substr($msg_todosgrupos_forum.$msg_grupos_forum, 0, -2);  
//        }
//         $mensaje .="<br><br><b>Miembros</b><br>";
//         $mensaje .=substr( $msg_misgrupos.$msg_todosgrupos.$msg_grupos_miembros, 0, -2);  
         $receptores= substr( $msg_misgrupos.$msg_todosgrupos.$msg_grupos_miembros, 0, -2); 


         if($msg_miembros_adicionales != ''){
            $mensaje .="<br><br><b>Miembros Adicionales</b><br>";
            $mensaje .=substr($msg_miembros_adicionales, 0, -2);  
         }

         if($msg_empresarios != ''){
            $mensaje .="<br><br><b>Caso del Mes</b><br>";
            $mensaje .=substr($msg_empresarios, 0, -2); 
         }
         if($msg_invitados != ''){
            $mensaje .="<br><br><b>Invitados</b><br>";
            $mensaje .=substr($msg_invitados, 0, -2); 
         }
         if($msg_contacto != ''){
            $mensaje .="<br><br><b>Contactos</b><br>";
            $mensaje .=$msg_contacto;
         }

        ////////////////////////////////////////////////////////
        //Asistencia
        if($doAsistencia){
            $objAsistencia= new Asistencia();  
            $comp= $objAsistencia->setCrearAsistencia2($idEvento,$_SESSION['user_id_ben'],$listaGruposMiembros,'');
        }
        ////////////////////////////////////////////////////////    
       
        if($doAsistencia == FALSE){
            //$comp=$mensaje;
            $data = array("success" => "true", 
                "msg"=>$mensaje,
                "asunto" => $asunto,
                "receptores" => $receptores);  
            $comp=  json_encode($data);
            $_SESSION['evento_destinatarios']= $destinatarios;
//            $mail= new Mail(); 
//            $comp= $mail->enviarMultiple($_SESSION['user_name'],$_SESSION['user_correo'], $asunto, $mensaje, FALSE, $destinatarios);
        }
        return $comp;
    }
    
}
//Respuestas AJAX
if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    try{
        switch ($_POST['KEY']):
            case 'KEY_ENVIAR_CORREO_INDIVIDUAL':
                 
                if( !empty($_POST['_email_asunto'])  && !empty($_POST['_email_mensaje'])) {
                   $mail= new Mail(); 
                   $comp= $mail->enviarMultiple($_SESSION['user_name'],$_SESSION['user_correo'], $_POST['_email_asunto'], $_POST['_email_mensaje'], FALSE, $_SESSION['evento_destinatarios']);
                   $data = array("success" => "true", "priority"=>'success', "msg" => $comp);  
                    echo json_encode($data);
                }else{
                    $data = array("success" => "false", "priority"=>'info', "msg" => 'Faltan campos por llenar!');  
                    echo json_encode($data);
                }      

                break; 
            case 'KEY_DATA_CALENDARIO'://///////////////////////////////////////////////////////// 
                $objEvento= new Evento();
                if (in_array($perVerFiltrosIDForumOp10, $_SESSION['usu_permiso'])) { 
                    echo $objEvento->getJSONEventosCalendar($_SESSION['user_id_ben']); 
                }else{
                    echo $objEvento->getJSONEventosCalendar(""); 
                }
   
                break;
            case 'KEY_ULTIMA_FECHA':///////////////////////////////////////////////////////////
                $fecha= date("Y-m-d");
                if(isset($_SESSION['_ultima_fecha_evento'])){
                    $fecha= $_SESSION['_ultima_fecha_evento'];
                }
                echo $fecha; 
                
   
                break;
            
            case 'KEY_SHOW_FORM_GUARDAR_EVENTO':///////////////////////////////////////////////////////////                
                $objTipoEvento= new TipoEvento();
                $resultset= $objTipoEvento->getTipoEvento($_POST['_id_te']);
                if($row = $resultset->fetch_assoc()) {
                    //tip_eve_dia_rango_fin
                    $objDireccion= new Direccion();
                    $lista= $objDireccion->getListaDireccion($row['tip_eve_opcion_direccion'], NULL);
					
					
                  $objForum= new ForumLeader();
                  $listaPerfil= $objForum->getListaForumLeadersEVENTOS(NULL);
					
					
                    $boton['boton_2'] = array("click" => "setCrearEvento('g',".$_POST['_id_te'].",".$row['tip_eve_opcion_contacto'].",".$row['tip_eve_opcion_acompanado'].",".$row['tip_eve_opcion_invitado'].",".$row['tip_eve_opcion_empresario_mes'].")" ,"modal" => "" ,"id" => "btnGuardar"  ,"color" => "btn-info" ,"titulo" => "Guardar" ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                    $boton['boton_3'] = array("click" => "setCrearEvento('gn',".$_POST['_id_te'].",".$row['tip_eve_opcion_contacto'].",".$row['tip_eve_opcion_acompanado'].",".$row['tip_eve_opcion_invitado'].",".$row['tip_eve_opcion_empresario_mes'].")" ,"modal" => ""  ,"id" => "btnGuardarNuevo","color" => "btn-info" ,"titulo" => "Guardar y Nuevo" ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                    $boton['boton_4'] = array("click" => "getRecargar()" ,"modal" => ""  ,"id" => "","color" => "btn-info" ,"titulo" => "Regresar" ,"lado" => "" ,"icono" => "fa-mail-reply");

                    //$form['form_1'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Forum Leader", "id" => "_titular" ,"reemplazo" => $_SESSION['user_name']);
					if($_SESSION['user_id_perfil']==3){
$form['form_1'] = array("elemento" => "disabled" ,"tipo" => "text" , "titulo" => "Forum Leader", "id" => "_titular_1" ,"reemplazo" => $_SESSION['user_name']);
$form['form_0'] = array("elemento" => "caja" ,"tipo" => "hidden", "id" => "_titular" ,"reemplazo" => $_SESSION['user_id_ben']);
					}else{

$form['form_1'] = array("elemento" => "combo","change" => "loadgroups();","titulo" => $lblForumLeader, "id" => "_titular", "option" => $listaPerfil);
	
					}
					echo '<script>loadgroups();</script>';
					
                    $form['form_2'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Nombre del Evento", "id" => "_nombre" ,"reemplazo" => $row['tip_eve_descripcion']);
                    $listaGrupoMiembros=array();
                  //  $listaGrupoMiembros['lista_'] = array("value_list" => "",  "select_list" => "" ,"texto_list" => "");

                   /* $form['form_3'] = array("elemento" => "combo + caja + boton" ,"tipo" => "text" , "titulo" => "Miembros", 
                                                    "id" => "" ,"reemplazo" => '',"boton_tipo" => "btn-info",
                                                    "modal" => "#modal_get_busqueda","boton_click" => "",
                                                    "boton_icono" => "fa fa-search-plus","boton_nombre" => "","boton_title" =>"Buscar","change" => "getEliminarNoSeleccionados()",
                                                    "id_list" => "_miembros_grupos","disabled" => "disabled", "option_list" => $listaGrupoMiembros);
				   */
				   
				   
				   
				   
		
		
		/*
		 $objGrupo= new Grupo();
        $listaGrupos= $objGrupo->getListaGruposForum($row['forum_usu_id'], $row['grupo_id'], NULL);
		*/
		
		
        //$form['form_2'] = array("elemento" => "combo","change" => "getFiltro('1')", "titulo" => "Grupos", "id" => "_grupo", "option" => $listaGrupos);
		
				  
		$listaGrupoMiembros['lista_'] = array( "value" => "x",  "select" => "selected" ,"texto" => "Seleccione...");
	    $objGrupo= new Grupo();
        $listaGrupos= $objGrupo->getListaGrupos2(NULL,$listaGrupoMiembros);
		
				   $form['form_3'] = array("elemento" => "combo", "titulo" => "Grupos", "id" => "_miembrosGrupos", "option" => $listaGrupos);
                   
                    
					
					
                  
                    

                    $form['form_4'] = array("elemento" => "combo + boton","change" => "",                   "titulo" => "Ubicación", "id" => "_ubicacion", "option" => $lista, 
                                            "modal" => "#modal_getCrearDireccion","boton_click" => "getTipoDireccion('".$row['tip_eve_opcion_direccion']."')", "boton_icono" => "fa fa-map","boton_nombre" => "", "boton_title" =>"Crear Dirección"
                                            ,"boton_tipo" => "btn-info");
					
					
					
			//		$form['form_4'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Ubicación", "id" => "_ubicacion" ,"reemplazo" => "");
                    
              
                    
                    //$form['form_4'] = array("elemento" => "combo","change" => "",                   "titulo" => "Ubicación", "id" => "_ubicacion", "option" => $lista);
                    
                    
                    
                    if($row['tip_eve_tododia'] =='1'){
                        $form['form_5'] = array("elemento" => "Checkbox-color" ,"chec" => "checked" ,"tipo" => "" , "titulo" => "Todo el día", "id" => "_all_day" ,"reemplazo" => ""); 
                    }  else {
                        $form['form_5'] = array("elemento" => "Checkbox-color" ,"chec" => "" ,"tipo" => "" , "titulo" => "Todo el día", "id" => "_all_day" ,"reemplazo" => ""); 
                    }

//Fechas//

if($_POST['_id_te']=='3'){
$form['form_6'] = array("elemento" => "fecha + tiempo" ,"tipo_date" => "date" , "titulo_date" => "Fecha de Inicio", "id_date" => "_f_inicio" ,"reemplazo_date" => date("Y-m-d")
,"tipo_time" => "time" , "titulo_time" => "Fecha de Inicio", "id_time" => "_time_inicio" ,"reemplazo_time" => date('H:i',strtotime($row['tip_eve_hora_rango_inicio']))); 

$form['form_7'] = array("elemento" => "fecha + tiempo" ,"tipo_date" => "date" , "titulo_date" => "Fecha de Fin", "id_date" => "_f_fin" ,"reemplazo_date" => date("Y-m-d")
,"tipo_time" => "time" , "titulo_time" => "Fecha de Fin", "id_time" => "_time_fin" ,"reemplazo_time" => date('H:i',strtotime($row['tip_eve_hora_rango_fin'])));	
}else{
	
$form['form_6'] = array("elemento" => "fecha + tiempo" ,"tipo_date" => "date" , "titulo_date" => "Fecha de Inicio", "id_date" => "_f_inicio" ,"reemplazo_date" => date("Y-m-d")
,"tipo_time" => "time" , "titulo_time" => "Fecha de Inicio", "id_time" => "_time_inicio" ,"reemplazo_time" => date('H:i',strtotime($row['tip_eve_hora_rango_inicio']))); 

$form['form_7'] = array("elemento" => "fecha + tiempo" ,"tipo_date" => "hidden" ,"id_date" => "_f_fin" ,"reemplazo_date" => date("Y-m-d")
,"tipo_time" => "time" , "titulo_time" => "Fecha de Fin", "id_time" => "_time_fin" ,"reemplazo_time" => date('H:i',strtotime($row['tip_eve_hora_rango_fin'])));	

}


                   

                    $objMiembro= new Miembro();
                        $listaMiembros= $objMiembro->getListaMiembros(Null, NULL,"",FALSE);
						if(($_POST['_id_te']==1)||($_POST['_id_te']==2)){
							$form['form_8'] = array("elemento" => "lista-multiple",  "titulo" => "Caso del Mes", "id" => "_empresarios_mes", "option" => $listaMiembros); 
						}else{
							$form['form_8'] = array("elemento" => "caja" ,"tipo" => "hidden" , "id" => "_empresarios_mes", "option" => $listaMiembros); 
						}
                    if($row['tip_eve_opcion_acompanado'] == "1"){
                        $objAcompanamiento= new Aconpanamiento();
                        $lista= $objAcompanamiento->getListaAconpanamiento();
                        $form['form_9'] = array("elemento" => "combo","change" => "",                    "titulo" => "Acompañado por", "id" => "_acompanado", "option" => $lista);       
                    }
                    if($row['tip_eve_opcion_contacto'] == "1"){
                        $listaParticipantes= array();
                        $objParticipante= new Participante();
                        $listaParticipantes= $objParticipante->getListaParticipantes(NULL,'Contacto');
                      /*
					  $form['form_10'] = array("elemento" => "combo + caja + boton" ,"tipo" => "text" , "titulo" => "Contactos", 
                                                        "id" => "" ,"reemplazo" => '',"boton_tipo" => "btn-info",
                                                        "modal" => "#modal_getCrearParticipante","boton_click" => "getTipoParticipante('Contacto')",
                                                        "boton_icono" => "fa fa-user","boton_nombre" => "", "boton_title" =>"Crear","change" => "",
                                                        "id_list" => "_contacto","disabled" => "", "option_list" => $listaParticipantes);
					  */
						
					//	$form['form_10'] = array("elemento" => "caja" ,"tipo" => "hidden" , "id" => "_participantes" ,"reemplazo" => "");
                   }

                    if($row['tip_eve_opcion_invitado'] == "1"){
                        $listaParticipantes= array();
                        $objParticipante= new Participante();
                        $listaParticipantes= $objParticipante->getListaParticipantes(NULL,'Invitado');
						/*
                        $form['form_11'] = array("elemento" => "combo + caja + boton" ,"tipo" => "text" , "titulo" => "Invitados", 
                                                        "id" => "" ,"reemplazo" => '',"boton_tipo" => "btn-info",
                                                        "modal" => "#modal_getCrearParticipante","boton_click" => "getTipoParticipante('Invitado')",
                                                        "boton_icono" => "fa fa-user","boton_nombre" => "", "boton_title" =>"Crear","change" => "",
                                                        "id_list" => "_participantes","disabled" => "", "option_list" => $listaParticipantes);
						*/
						if($_POST['_id_te']=='1'){
						$form['form_11'] = array("elemento" => "caja" ,"tipo" => "hidden" , "id" => "_descripcion" ,"reemplazo" => $row['eve_descripcion']);
					}else
					if($_POST['_id_te']=='3'){
						$form['form_11'] = array("elemento" => "caja" ,"tipo" => "hidden" , "id" => "_descripcion" ,"reemplazo" => $row['eve_descripcion']);
					}else
					if($_POST['_id_te']=='4'){
					$form['form_11'] = array("elemento" => "caja" ,"tipo" => "hidden" , "id" => "_descripcion" ,"reemplazo" => $row['eve_descripcion']);
					}else{
					$form['form_11'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Expositor", "id" => "_descripcion" ,"reemplazo" => $row['eve_descripcion']);	
					}
						//$form['form_11'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Expositor", "id" => "_descripcion" ,"reemplazo" => $row['eve_descripcion']);
                    }

                 //   $form['form_12'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Descripción", "id" => "_descripcion" ,"reemplazo" => "");
				    $form['form_12'] = array("elemento" => "caja" ,"tipo" => "hidden" , "id" => "_participantes" ,"reemplazo" => "");

                    $resultado = str_replace("{contenedor_1}", generadorEtiqueta($form),  getPage('page_detalle_update_evento') );//generadorContMultipleRow($colum)); 
                    $resultado = str_replace("{contenedor_2}", '',  $resultado);
                    $resultado = str_replace("{titulo}", "Crear Evento",  $resultado);
                    $resultado = str_replace("{boton}", generadorBoton2($boton), $resultado);             
                    echo $resultado; 
                }
                break;
                
            case 'KEY_SHOW_MODAL_FILTRO_EVENTO':                      
                echo getFiltroGruposEvento();
            break;     
            
            case 'KEY_GUARDAR_EVENTO':///////////////////////////////////////////////////////////   
                        
                if(!empty($_POST['key_operacion'] ) && !empty($_POST['_titular']) && !empty($_POST['_nombre']) 
                         && !empty($_POST['_fi']) && !empty($_POST['_ff']) && !empty($_POST['_ubicacion']) 
                                 && !empty($_POST['_miembrosGrupos']) && !empty($_POST['_id_ubicacion']) && !empty($_POST['_id_tipo_evento'])){ 

                    //Obtengo todos los grupos
                    $misGrupos="0";
                    $todosGrupos="0";
                    
                    $arrayGrupo=array();
                    $listaGrupos="";
                    $cont=0;
                    foreach($_POST['_miembrosGrupos'] as $valor){
                        if($valor == "T"){
                          $todosGrupos="1";
                        }
                        if($valor == "M"){
                          $misGrupos="1";
                        }
                        if(substr($valor, -1) == "G"){
                           $arrayGrupo[$cont]= substr($valor, 0, -1);
                           $listaGrupos.= substr($valor, 0, -1).",";
                        }
                        $cont= $cont + 1;
                    }            
                    //Obtengo todos los miembros, menos los que estan en los grupos seleccionados
                    $arrayMiembros=array();
                    $listaMiembros="";
                    $cont=0;
                    foreach($_POST['_miembrosGrupos'] as $valor){
			$pos = strpos($valor, "-");
                        if(substr($valor, -1) == "M"){   
                           $idMiembros= substr($valor, 0, $pos);
                           $idGrupoMiembros= substr($valor, $pos + 1, -1);
                            if (!in_array($idGrupoMiembros, $arrayGrupo)) {
                                $listaMiembros.= $idMiembros.",";
                                $arrayMiembros[$cont]=$idMiembros;
                                $cont= $cont + 1;
                            }
                        }      
                    }
         
                    $listaAdicionales="";
                    if(isset($_POST['_participantes_adicionales'])){
                        foreach($_POST['_participantes_adicionales'] as $valor){
                            $listaAdicionales.= $valor.",";
                        }                    
                    }
                    
                    $listaEmpresario="";
                    if(isset($_POST['_empresariosMes'])){
                        foreach($_POST['_empresariosMes'] as $valor){
                            $listaEmpresario.= $valor.",";
                        }                    
                    }
                    
                    $listaContactos="";
                    if(isset($_POST['_contactos'])){
                        foreach($_POST['_contactos'] as $valor){
                            $listaContactos.= $valor.",";
                        }                    
                    }                 
                    
                    
                    
                   if($misGrupos == "1"){
                       $todosGrupos= "0";
                       $listaMiembros="";
                       $listaGrupos="";
                   }elseif ($todosGrupos == "1") {
                       $misGrupos == "0";
                       $listaMiembros="";
                       $listaGrupos="";
                   }  
                   $idGenerado="";
                   $objGenerador= new GeneradorID();
                   $idGenerado= $objGenerador->getGenerar();
                   
                    $objEvento= new Evento();         
                    $comp= $objEvento->setGrabarEvento($idGenerado, $_POST['_nombre'],   $_POST['_titular'],$_POST['_all_day'], $_POST['_fi'],$_POST['_ff'],
                            $_POST['_descripcion'],57,$listaAdicionales,$_POST['_miembrosGrupos'],$listaMiembros,
                            $misGrupos,$todosGrupos,$_POST['_id_tipo_evento'],$_POST['_id_ubicacion'],$_POST['_acompanado'],$listaContactos,$listaEmpresario);

                    if($comp > 0){                        
                        getRecordarEvento($comp, TRUE);
                        if($_POST['key_operacion']=='gn'){
                            $data = array("success" => "true_gn", "priority"=>'success',"msg" => 'El Evento se creo correctamente!');  
                            echo json_encode($data);              
                         }  else {
                            $data = array("success" => "true_g", "priority"=>'success',"msg" => 'El Evento se creo correctamente!');  
                            echo json_encode($data); 
                         }

                    }else{
                        $data = array("success" => "false", "priority"=>'info',"msg" => $comp); 
                        echo json_encode($data);
                    }
                }  else {
                    $data = array("success" => "false", "priority"=>'info', "msg" => 'Faltan campos por llenar!');  
                    echo json_encode($data); 
                }
  
               break;
                      
            case 'KEY_GUARDAR_PARTICIPANTE':///////////////////////////////////////////////////////////   

                 if(!empty($_POST['_nombre_participante']) && !empty($_POST['_apellido_participante']) ){ 
//                    $data = array("success" => "false", "priority"=>'info', "msg" => $_POST['_tipo']);  
//                    echo json_encode($data); 
//                    exit();
                    $objParticipante= new Participante();
                    $comp= $objParticipante->setGrabar(  $_POST['_nombre_participante'], $_POST['_apellido_participante'],
                            $_SESSION['user_id_ben'],$_POST['_correo_participante'],$_POST['_movil_participante'],$_POST['_tipo']); 
                    
                    

                        if($comp != "0"){
                            $tipo= '_contacto';
                            if($_POST['_tipo'] == "Invitado"){
                                $tipo= '_participantes';
                            }
                            $listaParticipantes= array();
                            $objParticipante= new Participante();
                            $listaParticipantes= $objParticipante->getListaParticipantes($comp,$_POST['_tipo']);
                            
                            $data = array("success" => "true", "lista_participantes"=> generadorMultiListSelectOption($tipo, "",$listaParticipantes));  
                            echo json_encode($data); 

                        }else{
                            $data = array("success" => "false", "priority"=>'info',"msg" => $comp); 
                            echo json_encode($data);
                        }
                }  else {
                    $data = array("success" => "false", "priority"=>'info', "msg" => 'Faltan campos por llenar!');  
                    echo json_encode($data); 
                }
  
               break;
               
            case 'KEY_SHOW_FORM_ACTUALIZAR_EVENTO'://///////////////////////////////////////////////////////// 
               
                if(!empty($_POST['id'])){    
                    
                     //Formularios
                    $objEvento= new Evento();
                    $resultset= $objEvento->getEventosDetalle($_POST['id']);
                    if($row = $resultset->fetch_assoc()) {
                        

                        
                        $boton['boton_1'] = array("elemento" => "boton" ,"modal" => "" ,"color" => "btn-info" ,"click" => "setActualizarEvento(".$_POST['id'].",".$row['tip_eve_opcion_contacto'].",".$row['tip_eve_opcion_acompanado'].",".$row['tip_eve_opcion_invitado'].",".$row['tip_eve_opcion_empresario_mes'].")"  ,"titulo" => "Guardar" ,"lado" => "pull-right" ,"icono" => "fa-pencil");
                        $boton['boton_2'] = array("click" => "getRecargar()" ,"modal" => ""  ,"color" => "btn-info" ,"titulo" => "Regresar" ,"lado" => "" ,"icono" => "fa-mail-reply");
                        
                        $misGrupos=""; 
                        $todosGrupos="";
                        $listaMTGrupo=array();
                        if($row['eve_mis_grupos'] == "1"){
                            $misGrupos="checked";
                            $listaMTGrupo['lista_'] = array("value_list" => "M",  "select_list" => "selected" ,"texto_list" => "Mis Grupos");
                        }  else {
                            $listaMTGrupo['lista_'] = array("value_list" => "M",  "select_list" => "" ,"texto_list" => "Mis Grupos");
                        }
                        if($row['eve_todos_grupos'] == "1"){
                            $todosGrupos="checked";
                            $listaMTGrupo['lista'] = array("value_list" => "T",  "select_list" => "selected" ,"texto_list" => "Todos los Grupos");
                        }  else {
                            $listaMTGrupo['lista'] = array("value_list" => "T",  "select_list" => "" ,"texto_list" => "Todos los Grupos");
                        }     
                        $listaGrupo=array();
                        $listaMiembros=array();
                        $objEvento= new Evento();
                        $listaGrupo= $objEvento->getMultiListaEventosGrupos($_POST['id'],$listaMTGrupo);

                        $objEvento= new Evento();
                        $listaMiembros= $objEvento->getMultiListaEventosMiembros($_POST['id'],$listaGrupo);

                        $objDireccion= new Direccion();
                        $lista= $objDireccion->getListaDireccion($row['tip_eve_opcion_direccion'], $row['direccion_id']);
						
						
						
        $objForum= new ForumLeader();
        $listaForumLeader= $objForum->getListaForumLeadersEVENTOS($row['eve_responsable']);
                        
                       // $form['form_1'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Forum Leader", "id" => "_titular" ,"reemplazo" => $row['eve_responsable']); 
					   $form['form_1'] = array("elemento" => "combo","change" => "","titulo" => $lblForumLeader, "id" => "_titular", "option" => $listaForumLeader);
                        $form['form_2'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Nombre del Evento", "id" => "_nombre" ,"reemplazo" => $row['eve_nombre']);
         
                   /*     $form['form_3'] = array("elemento" => "combo + caja + boton" ,"tipo" => "text" , "titulo" => "Miembros", 
                                                       "id" => "" ,"reemplazo" => '',"boton_tipo" => "btn-info",
                                                       "modal" => "#modal_get_busqueda","boton_click" => "",
                                                       "boton_icono" => "fa fa-search-plus","boton_nombre" => "","boton_title" =>"Buscar","change" => "getEliminarNoSeleccionados()",
                                                       "id_list" => "_miembros_grupos","disabled" => "disabled", "option_list" => $listaMiembros);
				   */
				   
		$listaGrupoMiembros['lista_'] = array( "value" => "x",  "select" => "selected" ,"texto" => "Seleccione...");
	    $objGrupo= new Grupo();
        $listaGrupos= $objGrupo->getListaGruposForum($row['eve_id_usuario'], $row['eve_mis_grupos'], NULL);
		$form['form_3'] = array("elemento" => "combo", "titulo" => "Grupos", "id" => "_miembrosGrupos", "option" => $listaGrupos);
		

                        
						$form['form_4'] = array("elemento" => "combo + boton","change" => "",                   "titulo" => "Ubicación", "id" => "_ubicacion", "option" => $lista, 
                                            "modal" => "#modal_getCrearDireccion","boton_click" => "getTipoDireccion('".$row['tip_eve_opcion_direccion']."')", "boton_icono" => "fa fa-map","boton_nombre" => "", "boton_title" =>"Crear Dirección"
                                            ,"boton_tipo" => "btn-info");
						
                        //$form['form_4'] = array("elemento" => "combo","change" => "",                   "titulo" => "Ubicación", "id" => "_ubicacion", "option" => $lista);
               
                        if($row['eve_todoeldia'] =='1'){
                            $form['form_5'] = array("elemento" => "Checkbox-color" ,"chec" => "checked" ,"tipo" => "" , "titulo" => "Todo el día", "id" => "_all_day" ,"reemplazo" => ""); 
                        }  else {
                            $form['form_5'] = array("elemento" => "Checkbox-color" ,"chec" => "" ,"tipo" => "" , "titulo" => "Todo el día", "id" => "_all_day" ,"reemplazo" => ""); 
                        }

                        $form['form_6'] = array("elemento" => "fecha + tiempo" ,"tipo_date" => "date" , "titulo_date" => "Fecha de Inicio", "id_date" => "_f_inicio" ,"reemplazo_date" => date('Y-m-d',strtotime($row['eve_fechainicio']))
                                                                               ,"tipo_time" => "time" , "titulo_time" => "Fecha de Inicio", "id_time" => "_time_inicio" ,"reemplazo_time" => date('H:i',strtotime($row['eve_fechainicio']))   ); 



if($row['tipo_evento_id']=='3'){
$form['form_6'] = array("elemento" => "fecha + tiempo" ,"tipo_date" => "date" , "titulo_date" => "Fecha de Inicio", "id_date" => "_f_inicio" ,"reemplazo_date" => date("Y-m-d")
,"tipo_time" => "time" , "titulo_time" => "Fecha de Inicio", "id_time" => "_time_inicio" ,"reemplazo_time" => date('H:i',strtotime($row['tip_eve_hora_rango_inicio']))); 

$form['form_7'] = array("elemento" => "fecha + tiempo" ,"tipo_date" => "date" , "titulo_date" => "Fecha de Fin", "id_date" => "_f_fin" ,"reemplazo_date" => date("Y-m-d")
,"tipo_time" => "time" , "titulo_time" => "Fecha de Fin", "id_time" => "_time_fin" ,"reemplazo_time" => date('H:i',strtotime($row['tip_eve_hora_rango_fin'])));	
}else{
	
$form['form_6'] = array("elemento" => "fecha + tiempo" ,"tipo_date" => "date" , "titulo_date" => "Fecha de Inicio", "id_date" => "_f_inicio" ,"reemplazo_date" => date("Y-m-d")
,"tipo_time" => "time" , "titulo_time" => "Fecha de Inicio", "id_time" => "_time_inicio" ,"reemplazo_time" => date('H:i',strtotime($row['tip_eve_hora_rango_inicio']))); 

$form['form_7'] = array("elemento" => "fecha + tiempo" ,"tipo_date" => "hidden" ,"id_date" => "_f_fin" ,"reemplazo_date" => date("Y-m-d")
,"tipo_time" => "time" , "titulo_time" => "Fecha de Fin", "id_time" => "_time_fin" ,"reemplazo_time" => date('H:i',strtotime($row['tip_eve_hora_rango_fin'])));	

}

                        if($row['tip_eve_opcion_empresario_mes'] == "1"){
                           
                        }
						
						 $objEvento= new Evento();
                            $listaMiembros= $objEvento->getMultiListaEventosEmpresariosMes($_POST['id']);
                            
							if($row['tipo_evento_id']=='1'){
							$form['form_8'] = array("elemento" => "lista-multiple",  "titulo" => "Caso del Mes", "id" => "_empresarios_mes", "option" => $listaMiembros); 
						}else if($row['tipo_evento_id']=='2'){
							$form['form_8'] = array("elemento" => "lista-multiple",  "titulo" => "Caso del Mes", "id" => "_empresarios_mes", "option" => $listaMiembros); 
						}else{
							$form['form_8'] = array("elemento" => "caja" ,"tipo" => "hidden" , "id" => "_empresarios_mes", "option" => $listaMiembros); 
						}
                        if($row['tip_eve_opcion_acompanado'] == "1"){
                            $objAcompanamiento= new Aconpanamiento();
                            $lista= $objAcompanamiento->getListaAconpanamiento($row['evento_acompanado']);
                            $form['form_9'] = array("elemento" => "combo","change" => "",                    "titulo" => "Acompañado por", "id" => "_acompanado", "option" => $lista);       
                        }

                        if($row['tip_eve_opcion_contacto'] == "1"){
                            $listaParticipantesSeleccionados= array();
                            $objEvento= new Evento();
                            $listaParticipantesSeleccionados= $objEvento->getMultiListaParticipantesAdicionales($_POST['id'],'Contacto');
							/*
                            $form['form_10'] = array("elemento" => "combo + caja + boton" ,"tipo" => "text" , "titulo" => "Contactos", 
                                                            "id" => "" ,"reemplazo" => '',"boton_tipo" => "btn-info",
                                                            "modal" => "#modal_getCrearParticipante","boton_click" => "getTipoParticipante('Contacto')",
                                                            "boton_icono" => "fa fa-user","boton_nombre" => "", "boton_title" =>"Crear","change" => "",
                                                            "id_list" => "_contacto","disabled" => "", "option_list" => $listaParticipantesSeleccionados);
							*/
                        
                        }
                        if($row['tip_eve_opcion_invitado'] == "1"){
                            $listaParticipantesSeleccionados= array();
                            $objEvento= new Evento();
                            $listaParticipantesSeleccionados= $objEvento->getMultiListaParticipantesAdicionales($_POST['id'],'Invitado');
                            /*$form['form_11'] = array("elemento" => "combo + caja + boton" ,"tipo" => "text" , "titulo" => "Invitados", 
                                                            "id" => "" ,"reemplazo" => '',"boton_tipo" => "btn-info",
                                                            "modal" => "#modal_getCrearParticipante","boton_click" => "getTipoParticipante('Invitado')",
                                                            "boton_icono" => "fa fa-user","boton_nombre" => "", "boton_title" =>"Crear","change" => "",
                                                            "id_list" => "_participantes","disabled" => "", "option_list" => $listaParticipantesSeleccionados);
                        
						*/
					
					if($row['tipo_evento_id']=='1'){
						$form['form_11'] = array("elemento" => "caja" ,"tipo" => "hidden" , "id" => "_descripcion" ,"reemplazo" => $row['eve_descripcion']);
					}else
					if($row['tipo_evento_id']=='3'){
						$form['form_11'] = array("elemento" => "caja" ,"tipo" => "hidden" , "id" => "_descripcion" ,"reemplazo" => $row['eve_descripcion']);
					}else
					if($row['tipo_evento_id']=='4'){
					$form['form_11'] = array("elemento" => "caja" ,"tipo" => "hidden" , "id" => "_descripcion" ,"reemplazo" => $row['eve_descripcion']);
					}else{
					$form['form_11'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Expositor", "id" => "_descripcion" ,"reemplazo" => $row['eve_descripcion']);	
					}
						
						
						
						
						}
                        //$form['form_12'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Descripción", "id" => "_descripcion" ,"reemplazo" => $row['eve_descripcion']);
						$form['form_12'] = array("elemento" => "caja" ,"tipo" => "hidden", "id" => "_participantes" ,"reemplazo" => $row['eve_descripcion']);
                        
                        

                       $resultado = str_replace("{contenedor_1}", generadorEtiqueta($form),  getPage('page_detalle_update_evento') );//generadorContMultipleRow($colum)); 
                       $resultado = str_replace("{contenedor_2}", '',  $resultado);
                       $resultado = str_replace("{titulo}", "Actualizar Evento", $resultado );
                       $resultado = str_replace("{boton}", generadorBoton($boton), $resultado); 


                       /////////////////////////////////////////////////////////////
                       $lista1= array();
                        $objEvento= new Evento();
                        $resultset= $objEvento->getEventoGrupos($_POST['id']);
                        while($row = $resultset->fetch_assoc()) { 
                            $lista1[$row['grupos_gru_id']] = $row['grupos_gru_id'];

                        } 

                        $lista2= array();
                        $objEvento= new Evento();
                        $resultset= $objEvento->getEventoMiembros($_POST['id']);
                         while($row = $resultset->fetch_assoc()) { 
                             $lista2[$row['miembro_mie_id']] = $row['miembro_mie_id'];

                        }

                      
                       $data = array("success" => "true", 
                            "form"=> $resultado,
                            "modal" => getFiltroGruposEvento2($misGrupos,$todosGrupos,$lista1, $lista2));  

                       echo json_encode($data);

                    }  else {
                        $data = array("success" => "false", "form"=> "<h1>No hay datos!</h1>");  
                        echo json_encode($data);
                    }
                }
                break;
            
            case 'KEY_ACTUALIZAR_EVENTO': 

                if(!empty($_POST['_id'] ) && !empty($_POST['_titular']) && !empty($_POST['_nombre']) 
                         && !empty($_POST['_fi']) && !empty($_POST['_ff']) && !empty($_POST['_ubicacion']) 
                                 && !empty($_POST['_miembrosGrupos']) && !empty($_POST['_id_ubicacion']) ){ 

                    //Obtengo todos los grupos
                    $misGrupos="0";
                    $todosGrupos="0";
                    
                    $arrayGrupo=array();
                    $listaGrupos="";
                    $cont=0;
                    foreach($_POST['_miembrosGrupos'] as $valor){
                        if($valor == "T"){
                          $todosGrupos="1";
                        }
                        if($valor == "M"){
                          $misGrupos="1";
                        }
                        if(substr($valor, -1) == "G"){
                           $arrayGrupo[$cont]= substr($valor, 0, -1);
                           $listaGrupos.= substr($valor, 0, -1).",";
                        }
                        $cont= $cont + 1;
                    }            
                    //Obtengo todos los miembros, menos los que estan en los grupos seleccionados
                    $arrayMiembros=array();
                    $listaMiembros="";
                    $cont=0;
                    foreach($_POST['_miembrosGrupos'] as $valor){
			$pos = strpos($valor, "-");
                        if(substr($valor, -1) == "M"){   
                           $idMiembros= substr($valor, 0, $pos);
                           $idGrupoMiembros= substr($valor, $pos + 1, -1);
                            if (!in_array($idGrupoMiembros, $arrayGrupo)) {
                                $listaMiembros.= $idMiembros.",";
                                $arrayMiembros[$cont]=$idMiembros;
                                $cont= $cont + 1;
                            }
                        }      
                    }
         
                    $listaAdicionales="";
                    if(isset($_POST['_participantes_adicionales'])){
                        foreach($_POST['_participantes_adicionales'] as $valor){
                            $listaAdicionales.= $valor.",";
                        }                    
                    }
                    
                    $listaEmpresario="";
                    if(isset($_POST['_empresariosMes'])){
                        foreach($_POST['_empresariosMes'] as $valor){
                            $listaEmpresario.= $valor.",";
                        }                    
                    }
                    
                    $listaContactos="";
                    if(isset($_POST['_contactos'])){
                        foreach($_POST['_contactos'] as $valor){
                            $listaContactos.= $valor.",";
                        }                    
                    }                 
     
                   if($misGrupos == "1"){
                       $todosGrupos= "0";
                       $listaMiembros="";
                       $listaGrupos="";
                   }elseif ($todosGrupos == "1") {
                       $misGrupos == "0";
                       $listaMiembros="";
                       $listaGrupos="";
                   }                   
                    $objEvento= new Evento();         
                    $comp= $objEvento->setActualizarEvento($_POST['_id'],$_POST['_nombre'],   $_POST['_titular'],$_POST['_all_day'], $_POST['_fi'],$_POST['_ff'],
                            $_POST['_descripcion'],57,$listaAdicionales,$_POST['_miembrosGrupos'],$listaMiembros,
                            $misGrupos,$todosGrupos,$_POST['_id_ubicacion'],$_POST['_acompanado'],$listaContactos,$listaEmpresario);

                    if($comp == "OK"){ 
                        ////////////////////////////////////////////////////////
                        //Asistencia
                        //$objAsistencia= new Asistencia();  
                        //$objAsistencia->setCrearAsistencia($_POST['_id'],$_SESSION['user_id_ben']);
                        
                        
                        getRecordarEvento($_POST['_id'],TRUE);
                        $data = array("success" => "true", "priority"=>'success',"msg" => 'El Evento se actualizó correctamente!');  
                        echo json_encode($data);              
                    }else{
                        $data = array("success" => "false", "priority"=>'info',"msg" => $comp); 
                        echo json_encode($data);
                    }
                }  else {
                    $data = array("success" => "false", "priority"=>'info', "msg" => 'Faltan campos por llenar!');  
                    echo json_encode($data); 
                }
               break;
               
            case 'KEY_DETALLE_EVENTO'://///////////////////////////////////////////////////////// 
                if(!empty($_POST['_id'])){    

                    $objEvento= new Evento();
                    $resultset= $objEvento->getEventosDetalle($_POST['_id']);
                    if($row = $resultset->fetch_assoc()) {
                                 
                        $tabla['t_1'] = array("t_1" => generadorNegritas("Forum Leader"), "t_2" => $row['eve_responsable']);
                        $tabla['t_2'] = array("t_1" => generadorNegritas("Evento"), "t_2" => $row['eve_nombre']);
                        $tabla['t_3'] = array("t_1" => generadorNegritas("Dirección"), "t_2" => $row['direccion']);
                        
                        $cont=10;
                        $objEvento = new Evento();
                        $resultset= $objEvento->getEventosDetalleGrupos($_POST['_id']);
                        while($row_g = $resultset->fetch_assoc()) {
                            if($cont == 10){
                                $tabla['t_'.$cont] = array("t_1" => generadorNegritas("Grupos"), "t_2" => $row_g['gru_descripcion']);
                            }else{
                                $tabla['t_'.$cont] = array("t_1" => "", "t_2" => $row_g['gru_descripcion']);
                            }
                            $cont=$cont + 1;
                        }
                        
                        if($row['eve_mis_grupos']== "1"){
                            $tabla['t_21'] = array("t_1" => generadorNegritas("Grupos"), "t_2" => "Mis Grupos");
                        }
                        if($row['eve_todos_grupos']== "1"){
                            $tabla['t_22'.$cont] = array("t_1" => generadorNegritas("Grupos"), "t_2" => "Todos los Grupos");
                        }
                        
                        $cont=30;
                        $objEvento = new Evento();
                        $resultset= $objEvento->getEventosDetalleMiembros($_POST['_id']);
                        while($row_m = $resultset->fetch_assoc()) {
                            if($cont == 30){
                                $tabla['t_'.$cont] = array("t_1" => generadorNegritas("Miembros"), "t_2" => $row_m['per_apellido']." ".$row_m['per_nombre']);
                            }else{
                                $tabla['t_'.$cont] = array("t_1" => "", "t_2" => $row_m['per_apellido']." ".$row_m['per_nombre']);
                            }
                            $cont=$cont + 1;
                        }
 
                        $tabla['t_41'] = array("t_1" => generadorNegritas("Fecha Inicio"), "t_2" => getFormatoFechadmyhis($row['eve_fechainicio']));
                        $tabla['t_42'] = array("t_1" => generadorNegritas("Fecha Fin"), "t_2" => getFormatoFechadmyhis($row['eve_fechafin'])); 
                        $_SESSION['_ultima_fecha_evento']= date('Y-m-d',strtotime($row['eve_fechainicio']));
                        
                        /*
						if($row['tip_eve_opcion_empresario_mes'] == "1"){
                            $cont=50;
                            $objEmpresariosMes = new EmpresariosMes();
                            $resultset= $objEmpresariosMes->getEventosEmpresariosMes($_POST['_id']);
                            while($row_em = $resultset->fetch_assoc()) {
                                if($cont == 50){
                                    $tabla['t_'.$cont] = array("t_1" => generadorNegritas("Caso Del Mes"), "t_2" => $row_em['per_apellido']." ".$row_em['per_nombre']);
                                }else{
                                    $tabla['t_'.$cont] = array("t_1" => "", "t_2" => $row_em['per_apellido']." ".$row_em['per_nombre']);
                                }
                                $cont=$cont + 1;
                            }
                        }
						*/
                        if($row['tip_eve_opcion_acompanado'] == "1"){
                            $tabla['t_20'] = array("t_1" => generadorNegritas("Acompañado por:"), "t_2" => $row['acompanado']);
                        }
                        
                        if($row['tip_eve_opcion_contacto'] == "1"){
                            $cont=60;
                            $objParticipante = new Evento();
                            $resultset= $objParticipante->getParticipantesEventoInvitadoOContacto($_POST['_id'] , "Contacto");
                            while($row_pc = $resultset->fetch_assoc()) {
                                if($cont == 60){
                                    $tabla['t_'.$cont] = array("t_1" => generadorNegritas("Contactos"), "t_2" => $row_pc['per_apellido']." ".$row_pc['per_nombre']);
                                }else{
                                    $tabla['t_'.$cont] = array("t_1" => "", "t_2" => $row_pc['per_apellido']." ".$row_pc['per_nombre']);
                                }
                                $cont=$cont + 1;
                            }
                        }
                        
                        
                        if($row['tip_eve_opcion_invitado'] == "1"){
                            $cont=70;

                            $objParticipante = new Evento();
                            $resultset= $objParticipante->getParticipantesEventoInvitadoOContacto($_POST['_id'] , "Invitado");
                            while($row_pi = $resultset->fetch_assoc()) {
                                if($cont == 70){
                                    $tabla['t_'.$cont] = array("t_1" => generadorNegritas("Invitados"), "t_2" => $row_pi['per_apellido']." ".$row_pi['per_nombre']);
                                }else{
                                    $tabla['t_'.$cont] = array("t_1" => "", "t_2" => $row_pi['per_apellido']." ".$row_pi['per_nombre']);
                                }
                                $cont=$cont + 1;
                            }
                        }
                      //  $tabla['t_81'] = array("t_1" => generadorNegritas("Descripción"), "t_2" => $row['eve_descripcion']);
                        
   
                         
                        $urlEvento = array(
                                            'titulo' => $row['eve_nombre'],
                                            'descripcion' => $row['eve_descripcion'],
                                            'localizacion' => $row['direccion'],
                                            'fecha_inicio' => date('Y-m-d',strtotime($row['eve_fechainicio'])) , // Fecha de inicio de evento en formato AAAA-MM-DD
                                            'hora_inicio'=> date('H:i',strtotime($row['eve_fechainicio']) ), // Hora Inicio del evento
                                            'fecha_fin'=> date('Y-m-d',strtotime($row['eve_fechafin'])), // Fecha de fin de evento en formato AAAA-MM-DD
                                            'hora_fin'=>date('H:i',strtotime($row['eve_fechafin']) ), // Hora final del evento
                                            'nombre'=> $settings["name"], // Nombre del sitio
                                            'url'=> $settings["sitio"] // Url de la página
                                        );
         
                        
                        $resultado = str_replace("{contenedor_1}", generadorTabla_2($tabla, "table-striped"), getPage('page_detalle_evento')); 
                        $data = array("success" => "true", 
                                        "contenido"=> $resultado,
                                        "urlGoogleCalendar" => getGCalendarUrl($urlEvento));  
                       echo json_encode($data);

                    }else{
                        $data = array("success" => "true", "contenido"=> "<h1>No hay datos!</h1>");  
                        echo json_encode($data);
                    }
                        
                }
                break;
            
            case 'KEY_RECORDAR_EVENTO'://///////////////////////////////////////////////////////// 
                if(!empty($_POST['id'])){                     
                    $comp= getRecordarEvento($_POST['id'],FALSE);
//                    $data = array("success" => "true", "priority"=>'success',"msg" => $comp);  
                    echo $comp; 

                }else{
                    $data = array("success" => "false", "priority"=>'info',"msg" => 'Error!');  
                    echo json_encode($data); 
                }
                        
               
                break;
                
            case 'KEY_ELIMINAR_EVENTO': 
                if(!empty($_POST['_id'] ) ){ 
                    $objEvento= new Evento();         
                    $comp= $objEvento->setEventoEliminar($_POST['_id']);  
                    if($comp == "OK"){    
                        $data = array("success" => "true", "priority"=>'success',"msg" => 'El Evento se elimino correctamente!');  
                        echo json_encode($data);              
                    }else{
                        $data = array("success" => "false", "priority"=>'info',"msg" => $comp); 
                        echo json_encode($data);
                    }
                }  else {
                    $data = array("success" => "false", "priority"=>'info', "msg" => 'Faltan campos por llenar!');  
                    echo json_encode($data); 
                }
               break;
              
            case 'KEY_GUARDAR_DIRECCION':///////////////////////////////////////////////////////////   
                 if(!empty($_POST['_ciudad']) && !empty($_POST['_tipo_direccion']) && !empty($_POST['_descripcion_direccion']) ){ 
             
                    $objDireccion= new Direccion();
                    $comp= $objDireccion->setCrearDireccionModal($_POST['_ciudad'],$_POST['_descripcion_direccion'],
                            $_SESSION['user_id_ben'],$_POST['_tipo_direccion']);  
             
                        if($comp != "0"){       
                        
                            $objDireccion= new Direccion();
                            $lista= $objDireccion->getListaDireccion($_POST['_tipo_direccion'], $comp);// $idMaximo);
                            $data = array("success" => "true", "lista_direccion"=> generadorComboSelectOption("_ubicacion", "",$lista));  
                            echo json_encode($data); 

                        }else{
                            $data = array("success" => "false", "priority"=>'info',"msg" => $comp); 
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

function getGCalendarUrl($event){  
    $titulo = urlencode($event['titulo']); 
    $descripcion = urlencode($event['descripcion']); 
    $localizacion = urlencode($event['localizacion']); 
    $start=new DateTime($event['fecha_inicio'].' '.$event['hora_inicio'].' '.date_default_timezone_get()); 
    $end=new DateTime($event['fecha_fin'].' '.$event['hora_fin'].' '.date_default_timezone_get()); 
    $dates = urlencode($start->format("Ymd\THis")) . "/" . urlencode($end->format("Ymd\THis"));
    $name = urlencode($event['nombre']);
    $url = urlencode($event['url']);
    $gCalUrl = "http://www.google.com/calendar/event?action=TEMPLATE&text=$titulo&dates=$dates&details=$descripcion&location=$localizacion&trp=false&sprop=$url&sprop=name:$name";
    return ($gCalUrl);
}


$objTipoEvento= new TipoEvento(); 
$contenido="";
$resultset= $objTipoEvento->getTipoEvento();
while($row = $resultset->fetch_assoc()) { 
    $funcion="getCrearEvento(".$row['tip_eve_id'].")";
    $lista[$row['tip_eve_id']] = array("texto_color" => "bg-".$row['tip_eve_texto_color'] ,"id" => $row['tip_eve_id'] ,"codigo_color" => $row['tip_eve_codigo_color'] ,"funcion" => $funcion ,"texto" => $row['tip_eve_descripcion'] );  
}

$eventReport="eventReport()";
$faReport="faReport()";
$contenido = generadorMenuColor1("Crear Evento", $lista);
$contenido.=generadorMenuColor2("Reportes", $eventReport);
//$contenido.=generadorMenuColor3("Facilitation Activity", $faReport);
$filtro='';
$filtro= getFiltroGruposEvento();

////////////////////////////////////////////////////////////////////////////////
//Dirección
$objPais= new Pais();
$listapais= $objPais->getListaPais(NULL,NULL);
$prefijoPais= $objPais->getPrefijoPais();

$objProvincia=new Provincia();
$objProvincia->setIdPais($objPais->getIdPais());
$listaprov=  $objProvincia->getListaProvincia(NULL);

$objCiudad= new Ciudad();
$objCiudad->setIdProvincia($objProvincia->getIdProvincia());
$listaciudad=$objCiudad->getListaCiudad();


$form['form_7'] = array("elemento" => "combo","change" => "getCargarPaises()",                   "titulo" => $lblPais, "id" => "_pais", "option" => $listapais);
$form['form_8'] = array("elemento" => "combo", "change" => "getCargarProvincias()",                  "titulo" => $lblProvincia, "id" => "_provincia", "option" => $listaprov);
$form['form_9'] = array("elemento" => "combo", "change" => "",                  "titulo" => $lblCiudad, "id" => "_ciudad", "option" => $listaciudad);

$listaDireccion= generadorEtiquetaVVertical($form);





