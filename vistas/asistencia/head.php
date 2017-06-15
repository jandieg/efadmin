<?php
require_once MODELO.'Asistencia.php';
require_once MODELO.'TipoEvento.php';
require_once MODELO.'Grupo.php';
include(HTML."/html.php");
include(HTML."/html_2.php");
include(HTML."/html_combos.php");
$objGrupo;
function getCheck($id,$funcion, $disabled ,$checked) {
    $msg='';
    $msg='<center><input type="checkbox"  id="'.$id.'" '.$disabled.' onclick="'.$funcion.'" '.$checked.'/></center>'; 
    return $msg;
}
function getAddMeses($partida, $tope, $control, $bandera) {
    $html=''; 
    for ($index = $partida; $index <= $tope; $index++) {
        if($index != $control){
            if($bandera == TRUE){
                $html.='<th><center>'.getMesTexto($index).'</center></th>';
            }else{
                 $html.='<td></td>';  
            }         
        } 
    }
    return $html;
}
function getAsistencia($idTipoEvento, $idGrupo, $fecha_inicio, $fecha_fin) {
        $objAsistencia= new Asistencia();
        $resultset= $objAsistencia->getAsistencia($idGrupo, $fecha_inicio, $fecha_fin, $idTipoEvento);  
        $arrayMiembros= array();
        $arrayCabeceraId= array();
        $arrayCabecera= array();
      
        $arrayEventos= array();
        $banderaMiembros='';
        $cont= 1;
        while($row = $resultset->fetch_assoc()) { 
            $isFalta='';
            //Que solo sean fechas ya pasadas
            if(date('Y-m-d',strtotime($row['eve_fechafin'])) <= date("Y-m-d")){
                $disabled="";
                if($row['asis_estado'] == '0'){
                    $checked="checked";
                }else{
                    $checked="";
                }
                $isFalta=$row['asis_estado'];
            }else{
                $disabled="disabled";
                $checked="";
            }
            $funcion="setAsistencia(".$row['asis_id'].")";
            //Guardo en un array todos los eventos, en base al miembro
            $arrayEventos[$cont] =  array("evento" =>  getCheck($row['asis_id'],$funcion,$disabled, $checked),
                "miembro_id" => $row['miembro_mie_id'],
                "mes" => date('m',strtotime($row['eve_fechafin'])),
                "faltas" => $isFalta,
                "control" => date('n',strtotime($row['eve_fechafin'])));
            //Guardo los miembros en un array, es decir, sin repeticiones
            if($banderaMiembros != $row['miembro_mie_id']){
               $arrayMiembros[$cont] = array("nombre" => $row['nombre'], "miembro_id" => $row['miembro_mie_id'], "fecha" => $row['eve_fechafin']);
            }
            $banderaMiembros=$row['miembro_mie_id'];
 
            $funcion2= getAccionesParametrizadas(
                                           "getDetalleEvento('".$row['eve_nombre']."','".$row['eve_responsable']."','".getFormatoFechadmyhis($row['eve_fechainicio'])."','".getFormatoFechadmyhis($row['eve_fechafin'])."','".$row['direccion']."','".$row['eve_descripcion']."')",
                                           "modal_detalleEvento",
                                           "Ver Detalle de Evento",
                                           "fa fa-eye");
            //Guardo la cabecera que seran los meses de la fecha de cada evento
            if ( !in_array($row['eve_id'],  $arrayCabeceraId)) {
                $arrayCabecera[$cont]= array("valor" => date('M',strtotime($row['eve_fechafin'])).'</br>'.$funcion2,
                                             "control" => date('n',strtotime($row['eve_fechafin'])));
                //$arrayCabecera[$cont]= date('M',strtotime($row['eve_fechafin'])).'</br>'.$funcion2;
                $arrayCabeceraId[$cont]= $row['eve_id'];
            }  
            $cont= $cont + 1;         
        } 
        //$arrayCabecera[$cont + 1]= "Faltas";
//        $arrayCabecera[$cont + 2]= "Faltas Promedio";
//        $arrayCabecera[$cont + 3]= "Asistencia Promedio";
        //Creación de la Tabla
        //Cabecera de la tabla
        $control=1; //Para add columnas
        $html='';   
        $html .='<tr style="background-color:#2ECCFA;">';
        $html.='<th><center>Nombre</center></th>';
        foreach($arrayCabecera as $valor =>$val ){
            $html .= getAddMeses($control, $val["control"], $val["control"],TRUE);//Para add columnas
            $control= $val["control"] + 1;//Para add columnas
            
            $html.='<th><center>'.$val["valor"].'</center></th>';
        }
        $html .= getAddMeses($control, 12, "",TRUE);//Para add columnas
        $html.='<th><center>Faltas</center></th>';
//        $html.='<th><center>Faltas Promedio</center></th>';
//        $html.='<th><center>Asistencia Promedio</center></th>';
        $html .='</tr>';
        //cuerpo de la tabla
        $control=1;//Para add columnas
        foreach ($arrayMiembros as $valores => $valor) { 
            $cont_faltas= 0;
            $cont= 0;
            $html .='<tr>';
            $html .='<td>'.$valor['nombre'].'</td>';
            foreach ($arrayEventos as $eventos => $evento) {
                //unicamente va a dibujar los eventos del miembro
                if($evento['miembro_id']==$valor['miembro_id']){   //$evento['mes']
                    $html .= getAddMeses($control, $evento["control"], $evento["control"],FALSE);//Para add columnas
                    $control= $evento["control"] + 1;//Para add columnas
                    $html .='<td> '.$evento['evento'].'</td>';  
                    if($evento['faltas']=="0"){
                        $cont_faltas= $cont_faltas + 1;
                    }
                    if($evento['faltas'] != ""){
                        $cont= $cont + 1;
                    }      
                }
            }
             $html .= getAddMeses($control, 12, '',FALSE);//Para add columnas
             $control= 1;
//            $promedio= round(($cont_faltas * 100)/$cont, 0);
//            $promedio_año=round((($cont - $cont_faltas) * 100 ) / $cont , 0);  
            $html .='<td><center>'.$cont_faltas.'</center></td>';
//            $html .='<td><center>'.$promedio.'%</center></td>';
//            $html .='<td><center>'.$promedio_año.'%</center></td>';
            $html .='</tr>';            
        }
        $tablaDetalle= str_replace("{contenedor_1}", $html,getPage('page_tabla_asistencia'));
        return $tablaDetalle;
}

function getCasos($idTipoEvento, $idGrupo, $fecha_inicio, $fecha_fin) {
        $objAsistencia= new Asistencia();
        $resultset= $objAsistencia->getAsistenciaCasos($idGrupo, $fecha_inicio, $fecha_fin, $idTipoEvento);  
        $arrayMiembros= array();
        $arrayCabeceraId= array();
        $arrayCabecera= array();
        $arrayEventos= array();
        $banderaMiembros='';
        $caso="";
        $cont= 1;
        while($row = $resultset->fetch_assoc()) { 
            $caso="";
            //Que solo sean fechas ya pasadas
             if(date('Y-m-d',strtotime($row['eve_fechafin'])) <= date("Y-m-d")){
                if($row['id_eve_emp'] != ""){   
                    $caso="#2ECCFA";
                }
             }
            //Guardo en un array todos los eventos, en base al miembro
            $arrayEventos[$cont] =  array("evento" =>  $caso,
                "miembro_id" => $row['miembro_mie_id'],
                "estado" => $row['estado'],
                "control" => date('n',strtotime($row['eve_fechafin'])));
            //Guardo los miembros en un array, es decir, sin repeticiones
            if($banderaMiembros != $row['miembro_mie_id']){
               $arrayMiembros[$cont] = array("nombre" => $row['nombre'], 
                   "miembro_id" => $row['miembro_mie_id']);
            }
            $banderaMiembros=$row['miembro_mie_id']; 
            $funcion2= getAccionesParametrizadas(
                                           "getDetalleEvento('".$row['eve_nombre']."','".$row['eve_responsable']."','".$row['eve_fechainicio']."','".$row['eve_fechafin']."','".$row['direccion']."','".$row['eve_descripcion']."')",
                                           "modal_detalleEvento",
                                           "Ver Detalle de Evento",
                                           "fa fa-eye");
            //Guardo la cabecera que seran los meses de la fecha de cada evento
            if ( !in_array($row['eve_id'],  $arrayCabeceraId)) { 
                $arrayCabecera[$cont]= array("valor" => date('M',strtotime($row['eve_fechafin'])).'</br>'.$funcion2,
                                             "control" => date('n',strtotime($row['eve_fechafin'])));
                $arrayCabeceraId[$cont]= $row['eve_id'];
            }  
            $cont= $cont + 1;         
        } 
   
        //Cabecera de la tabla
        $control=1; //Para add columnas
        $html='';   
        $html .='<tr style="background-color:#2ECCFA;">';
        $html.='<th><center>Nombre</center></th>';
        foreach($arrayCabecera as $valor => $val){ 
            $html .= getAddMeses($control, $val["control"], $val["control"],TRUE);//Para add columnas
            $control= $val["control"] + 1;//Para add columnas
            
            $html.='<th><center>'.$val["valor"].'</center></th>';
        }
        $html .= getAddMeses($control, 12, "",TRUE);//Para add columnas
        $html .='</tr>';
        //cuerpo de la tabla
        $control=1;//Para add columnas
        foreach ($arrayMiembros as $valores => $valor) {            
            $html .='<tr>';
            $html .='<td>'.$valor['nombre'].'</td>';
            foreach ($arrayEventos as $eventos => $evento) {
                //unicamente va a dibujar los eventos del miembro 
                if($evento['miembro_id']==$valor['miembro_id']){   //$evento['mes']    
                    $html .= getAddMeses($control, $evento["control"], $evento["control"],FALSE);//Para add columnas
                    $control= $evento["control"] + 1;//Para add columnas
                    $html .='<td style="background-color:'.$evento['evento'].';"></td>'; 
                } 
            }
            $html .= getAddMeses($control, 12, '',FALSE);//Para add columnas
            $html .='</tr>';
            $control= 1;//Para add columnas
        }
        $tablaDetalle= str_replace("{contenedor_1}", $html,getPage('page_tabla_asistencia'));

        return $tablaDetalle;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    try{
        switch ($_POST['KEY']): 

            case 'KEY_DETALLE_FILTRO':
                if(!empty($_POST['_id_grupos']) && !empty($_POST['_id_tipo_evento']) ){ 
                    $fecha_inicio = getPrimerDiaMes($_POST['_año'],'1');
                    $fecha_fin= getUltimoDiaMes($_POST['_año'],'12');
                    /*if ($_POST['_tipo_asistencia'] == "3") {
                         echo getCasos($_POST['_id_tipo_evento'], $_POST['_id_grupos'], $fecha_inicio, $fecha_fin);
                    }else{*/
                        echo getAsistencia($_POST['_id_tipo_evento'], $_POST['_id_grupos'], $fecha_inicio, $fecha_fin);
                    //}
                    
                    exit();            
                }
                break;                
            case 'KEY_GUARDAR_ASISTENCIA': 
                 
                 if(!empty($_POST['_id_asistencia'])){
                     if($_POST['_checked'] != '1' && $_POST['_checked'] != '0'){
                        $data = array("success" => "false", "priority"=>'info',"msg" => "Error!"); 
                        echo json_encode($data);
                     }

                     $objAsistencia= new Asistencia();
                     $comp= $objAsistencia->setActualizarAsistencia($_POST['_id_asistencia'],$_SESSION['user_id_ben'], $_POST['_checked']);  
                     if($comp == "OK"){
                        $data = array("success" => "true", "priority"=>'success',"msg" => 'El asistencia se actualizó correctamente!');  
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
            case 'KEY_GUARDAR_ASISTENCIA_CASO': 
                 
                 if(!empty($_POST['_id_empresario_mes'])){
                     if($_POST['_checked'] != '1' && $_POST['_checked'] != '0'){
                        $data = array("success" => "false", "priority"=>'info',"msg" => "Error!"); 
                        echo json_encode($data);
                     }

                     $objAsistencia= new Asistencia();
                     $comp= $objAsistencia->setActualizarAsistenciaCasos($_POST['_id_empresario_mes'],$_SESSION['user_id_ben'], $_POST['_checked']);  
                     if($comp == "OK"){
                        $data = array("success" => "true", "priority"=>'success',"msg" => 'El caso se actualizó correctamente!');  
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
            case 'KEY_FILTRO_EVENTO_PERIODO':
                if(!empty($_POST['_tipo_asistencia'])){   
                    $id='';
                    $key='';
                     if ($_POST['_tipo_asistencia'] == "3") {
                        $id='';
                        $key='2';
                     }else{
                        $id=$_POST['_tipo_asistencia'];
                        $key='1';
                     }
                    $objTipoE= new TipoEvento();
                    $listaEventos= $objTipoE->getLista(NULL,NULL,$_POST['_tipo_asistencia'],$key);                 
                    $listaEventos= generadorComboSelectOption("_tipos_eventos", "",$listaEventos); 
                    echo $listaEventos; 
                
                }  else {
                    $data = array("success" => "false", "priority"=>'info', "msg" => 'El combo no tiene datos!');  
                    echo json_encode($data); 
                }

            break;

            case 'KEY_FILTRO_TIPO_EVENTO':
                if(!empty($_POST['_tipo_evento'])){   
                    
                    $objTipoG= new Grupo();
                    $listaGrupos= $objTipoG->getListaByTipoEvento($_POST['_tipo_evento']);                 
                    $listaGrupos= generadorComboSelectOption("_grupos", "",$listaGrupos); 
                    echo $listaGrupos; 
                    
                
                }  else {
                    $data = array("success" => "false", "priority"=>'info', "msg" => 'El combo no tiene datos!');  
                    echo json_encode($data); 
                }

            break;
                 
                 
        endswitch;    
    } catch (Exception $exc) { echo getError($exc);}  
    
     exit(); 
}
if (in_array($perVerTodosFiltrosAsistenciaOp17, $_SESSION['usu_permiso'])) {
    
    //$lista['lista_']=array("value" => "x",  "select" => "" ,"texto" => "Seleccione...");
    
    $objGrupo= new Grupo();
    $listaGrupos= $objGrupo->getListaGrupos2($objGrupo->getPrimerGrupo(),NULL);
    
 }  elseif (in_array($perVerFiltrosIDForumAsistenciaOp17, $_SESSION['usu_permiso'])) {
     
    //$lista['lista_']=array("value" => "x",  "select" => "" ,"texto" => "Seleccione...");
    
    $objGrupo= new Grupo();
    $listaGrupos= $objGrupo->getListaGruposForum($_SESSION['user_id_ben'], NULL,NULL);
 }
 
    $objTipoE= new TipoEvento();
    $listaEventos= $objTipoE->getLista(NULL,NULL,'', '');
    
    $t=getTablaFiltro($listaEventos,$listaGrupos, getAsistencia($objTipoE->getPrimer(), '', '', ''));

function getTablaFiltro($listaEventos= array(), $listaGrupos= array() , $tabla) { 
    $lista['lista_1']=array("value" => "1",  "select" => "selected" ,"texto" => "FORUM MENSUAL");
    $lista['lista_2']=array("value" => "3",  "select" => "" ,"texto" => "CASO DEL MES");
    $lista['lista_3']=array("value" => "2",  "select" => "" ,"texto" => "OTROS");
    
    //$form0['form_0'] = array("elemento" => "combo","disabled" => "","change" => "getEventosPeriodos()","titulo" => "Asistencia / Mesa Redonda", "id" => "_tipo_asistencia", "option" => $lista); 
    $form1['form_3'] = array("elemento" => "combo","disabled" => "","change" => "","titulo" => "Grupos", "id" => "_grupos", "option" => $listaGrupos);
    
    $form2['form_1'] = array("elemento" => "combo","disabled" => "","change" => "","titulo" => "Años", "id" => "_año", "option" => generadorComboAños(date('Y')));
    
    
    //$form2['form_1'] = array("elemento" => "caja" ,"disabled" => "","tipo" => "date" , "titulo" => "Fecha Inicio", "id" => "_fi" ,"reemplazo" => "");
    //$form3['form_1'] = array("elemento" => "caja" ,"disabled" => "","tipo" => "date" , "titulo" => "Fecha Fin", "id" => "_ff" ,"reemplazo" => "");    
    $form4['form_1'] = array("elemento" => "combo","disabled" => "","change" => "getGrupos()","titulo" => "Tipos Eventos", "id" => "_tipos_eventos", "option" => $listaEventos); 
    $resultado = str_replace("{contenedor_1}", generadorEtiquetaVVertical2($form4),  getPage('page_cuerpo'));     
    $resultado = str_replace("{contenedor_2}", generadorEtiquetaVVertical2($form1), $resultado); 
    $resultado = str_replace("{contenedor_3}", "", $resultado); 
    $resultado = str_replace("{contenedor_4}", generadorEtiquetaVVertical2($form2), $resultado); 
    $resultado = str_replace("{contenedor_5}", "", $resultado); 
    $resultado = str_replace("{contenedor_6}", '<div id="ben_contenedor_tabla">'.$tabla.'</div>', $resultado); 
    $resultado = str_replace("{boton}", "", $resultado);  
    $resultado = str_replace("{cabecera}", "Faltas", $resultado);   

    return $resultado;
}






