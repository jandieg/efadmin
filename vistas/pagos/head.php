<?php
require_once MODELO.'Grupo.php';
require_once MODELO.'ForumLeader.php';

require_once MODELO.'Miembro.php';
require_once MODELO.'Inscripcion.php';
require_once MODELO.'TipoPago.php';
require_once MODELO.'Grupo.php';
require_once MODELO.'Pago.php';
require_once MODELO.'Porcentaje.php';
include(HTML."/html.php");
include(HTML."/html_2.php");
include(HTML."/html_filtros.php");
$objPresupuestoCobro;
$objGrupo;
$objTipoPago;
$objPago;
$objForumLeader;
$objPorcentaje;
include(LENGUAJE."/lenguaje_1.php");

$valor_pagar=""; $valor_recaudado=""; $estado=''; $disabled=""; $bandera=""; $tipo_pago_franquicia=""; $name_franquicia="";  $porc_franquicia=""; $peri_franquicia=""; 
$tipo_pago_forum_grupo=""; $name_forum_grupo=""; $porc_forum_grupo=""; $id_porc_forum_grupo="";  $peri_forum_grupo=""; $tipo_pago_miembro=""; $name_forum_miembro="";
$tipo_pago_forum_otros=""; $name_forum_otros_pagos=""; $tipo_pago_varios=""; $name_pagos_varios=""; $id_porc_franquicia=""; $id_porc_forum_grupo="";
                    
                    
function getCheckPrincipal($total) {
    $msg='';
    $msg='<center><input type="checkbox" id="selectall" name="'.$total.'" onclick="getSeleccionarTodos()"/></center>'; 
    return $msg;
}
function getCheckCobro($id, $idPresupuesto, $disabled, $bandera ) {
    $msg='';
    $msg='<center><input type="checkbox" class="'.$bandera.'" name="'.$idPresupuesto.'" id="'.$id.'" '.$disabled.' onclick="getSeleccionarCobro()" /></center>'; 
    return $msg;
}

                        
if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    try{
        switch ($_POST['KEY']): 
            case 'KEY_DETALLE_PAGO_FORUM':
                        
                 if(!empty($_POST['id_tipo_pago']) && !empty($_POST['forum']) 
                         && !empty($_POST['identificador']) ){
                     
                    $boton_f['boton_2'] = array("elemento" => "boton","id" => "btnGuardarF" ,"modal" => "" ,"color" => "btn-primary" ,
                    "click" => "setPagarForumMO(".$_POST['id_tipo_pago'].",".$_POST['forum'].",".$_POST['identificador'].")" ,"titulo" => "Autorizar" ,"lado" => "" ,"icono" => ""); 
                                       
                    $form1['form_'] = array("elemento" => "caja" ,"disabled" => "disabled","tipo" => "text" , "titulo" => "Forum Leader", "id" => "_nombre" ,"reemplazo" => $_POST['nombre']);
                    $form1['form_1'] = array("elemento" => "caja" ,"disabled" => "","tipo" => "number" , "titulo" => "Valor a Pagar", "id" => "_valor_mo" ,"reemplazo" => "");
                     if($_POST['identificador'] == "1"){ 
                            $objMiembro= new Miembro();
                            $listaMiembros= $objMiembro->getListaMiembros(Null, NULL,$_POST['forum'],TRUE);
                            if($listaMiembros ==''){
                                $listaMiembros['lista_'] = array("value" => "",  "select" => "" ,"texto" => "");
                            }
                            $form1['form_2'] = array("elemento" => "lista-multiple","disabled" => "",  "titulo" => "Miembros", "id" => "_miembros", "option" => $listaMiembros);            
//                            $listaGrupoMiembros=array();
//                            $listaGrupoMiembros['lista_'] = array("value_list" => "",  "select_list" => "" ,"texto_list" => "");
//
//                            $form1['form_2'] = array("elemento" => "lista + boton" ,"tipo" => "text" , "titulo" => "Miembros", 
//                                                    "id" => "" ,"reemplazo" => '',"boton_tipo" => "btn-info",
//                                                    "modal" => "#modal_get_busqueda","boton_click" => "",
//                                                    "boton_icono" => "fa fa-search-plus","boton_nombre" => "","boton_title" =>"Buscar","change" => "getEliminarNoSeleccionados()",
//                                                    "id_list" => "_miembros_grupos","disabled" => "disabled", "option_list" => $listaGrupoMiembros);
                     }
                     $form1['form_3'] = array("elemento" => "textarea" ,"disabled" => "","titulo" => "Nota", "id" => "_nota_mo", "reemplazo" => "");  

                    $html = str_replace("{cuerpo}", generadorEtiquetaHorizontal($form1), getPage("page_detalle_forum_modal")); 
                    $html = str_replace("{boton}",generadorBoton3($boton_f), $html); 
                    echo $html;
                }
              
                break;    
            case 'KEY_GUARDAR_PAGO_FORUM_MO': 
                 if( !empty($_POST['_id_tipo']) &&  !empty($_POST['_valor'] ) 
                         && !empty($_POST['_forum']) && !empty($_POST['_identificador']) ){
//               
                     $valor_pagar= round($_POST['_valor'], 2);
                     
                     if($_POST['_identificador'] == "1"){
                        $listaMiembros="";
                        if(isset($_POST['_lista_miembros'])){
                            foreach($_POST['_lista_miembros'] as $valor){
                                $listaMiembros.= $valor.",";
                            }
                        }else{
                            $data = array("success" => "false", "priority"=>'info',"msg" => "Debes seleccionar miembros!"); 
                            echo json_encode($data);
                            exit();
                        }
                        $objPago= new Pago();
                        $comp= $objPago->setPagoValorForumMiembros($_POST['_id_tipo'], $listaMiembros, $valor_pagar,
                             $_POST['_forum'], $_SESSION['user_id_ben'],$_POST['_nota']); 
                     }else{
                        $objPago= new Pago();
                        $comp= $objPago->setPagoValorForumOtros($_POST['_id_tipo'], $valor_pagar,
                             $_POST['_forum'], $_SESSION['user_id_ben'],$_POST['_nota']);
                     }
  
                     if($comp == "OK"){
                        $data = array("success" => "true", "priority"=>'success',"msg" => 'El Pago se creo correctamente!');  
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
            case 'KEY_GUARDAR_PAGO_VARIOS': 
                 if( !empty($_POST['_id_tipo']) && !empty($_POST['_valor'] ) ){
//               
                    $valor_pagar= round($_POST['_valor'], 2);
  
                    $objPago= new Pago();
                    $comp= $objPago->setPagoValorVarios($_POST['_id_tipo'], $valor_pagar,
                              $_SESSION['user_id_ben'],$_POST['_nota']);
                  
  
                     if($comp == "OK"){
                        $data = array("success" => "true", "priority"=>'success',"msg" => 'El Pago se creo correctamente!');  
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
            case 'KEY_DETALLE_PAGO_FORUM_GRUPO':
                        
                 if(!empty($_POST['fi']) && !empty($_POST['ff']) && !empty($_POST['id_tipo_pago']) 
                          && !empty($_POST['forum'])){
                    
                    $cuerpo=""; $cont=1; $validar_pago= "NO";
                    $objPago= new Pago();
                    $resultset= $objPago->getPagoValorForumGrupos($_POST['fi'], $_POST['ff'],$_POST['forum']);
                    while($row = $resultset->fetch_assoc()) { 
                        if($row['pago'] != ''){
                             $disabled="disabled";
                             $bandera="";
                             $estado=generadorResaltador("success","Pagado" );
                             $valor_pagar=round($row['pago'], 2);
                             $valor_pagar="$ ". $valor_pagar;
                             $valor_recaudado="$ ".$row['valor_base'];
                        }else{
                            if($row['valor_pagar'] !=''){
                                $disabled="";
                                $bandera="case";
                                $estado=generadorResaltador("danger","Pendiente" );
                                $valor_pagar=($row['valor_pagar']  * $_POST['_porcentaje']) / 100;
                                //$valor_pagar= $row['valor_pagar'];
                                $valor_pagar= round($valor_pagar, 2);
                                $valor_pagar= "$ ". $valor_pagar;
                                $valor_recaudado= "$ ".$row['valor_pagar'];
                                $validar_pago= "SI";
                            }else{
                                $disabled="disabled";
                                $bandera="";
                                $estado=generadorResaltador("danger","-none-" );
                                $valor_pagar=generadorResaltador("danger","-none-" );
                                $valor_recaudado=generadorResaltador("danger","-none-" );
                                
                            }        
                        }

                         $cuerpo.= generadorTablaColoresFilas("" ,array(
                                   getCheckCobro($cont, $row['gru_id'], $disabled, $bandera),                 
                                   $row['gru_descripcion'],//."xxxx".$row['valor_pagar']."ssss".$row['pago'],
                                    generadorResaltador("info",getFormatoFechadmy($_POST['ff'])),
                                    '<div id="_valor_recaudado_'.$cont.'">'.$valor_recaudado.'</div>',
                                    '<div id="_valor_pagar_'.$cont.'">'.$valor_pagar.'</div>',           
                                   $estado)); 
                         $cont=$cont + 1;
                     }
                    if($validar_pago == "SI"){

                        
                        $lista['lista_'] = array( "value" => "x",  "select" => "selected" ,"texto" => "Seleccione %");
                        $objPorcentaje= new Porcentaje();
                        $lista_porcentajes= $objPorcentaje->getLista(($_POST['_id_porcentaje'] ),$lista);
                        $form1['form_5'] = array("elemento" => "combo - 50","change" => "getPorcentajeForumGrupo(".$cont.")",  "titulo" => "", "id" => "_porcentaje_pagar_fg", "option" =>$lista_porcentajes);
                        $funcion= generadorEtiquetasFiltroSencillo($form1).'&nbsp;&nbsp;&nbsp;'.getAccionesParametrizadas(
                                                                    "getTope(".$cont.")",
                                                                    "modal_getCrearPorcentaje",
                                                                    "Crear Porcentaje",
                                                                    "fa fa-plus");
                        //$alerta= generadorAlertaDinamica("Alerta!","Debes seleccionar un porcentaje de pago!","warning", "fa-warning");
                        $alerta="";
                    }else{
                        $funcion="Porcentaje a Pagar";
                        $alerta="";
                    }
                    

                    $tablaDetalle= generadorTablaDetalleEstadoCuenta( array( 
                            getCheckPrincipal($cont - 1),
                            generadorNegritas("Grupo"),
                            generadorNegritas("Fecha de Pago Hasta"),
                            generadorNegritas("Valor Recaudado"),
                            $funcion,
                            generadorNegritas("Estado")), $cuerpo); 
                    
                    $formModal['form_1'] = array("elemento" => "caja - oculta","id" => "_fg_id_tipo_pago" ,"reemplazo" => $_POST['id_tipo_pago']);
                    $formModal['form_4'] = array("elemento" => "caja - oculta","id" => "_fg_id_forum" ,"reemplazo" => $_POST['forum']); 
                    $formModal['form_5'] = array("elemento" => "caja - oculta","id" => "_fg_ff" ,"reemplazo" => $_POST['ff']);
                    $formModal['form_6'] = array("elemento" => "caja - oculta","id" => "_fg_fi" ,"reemplazo" => $_POST['fi']);
                
                    $formModal['form_7'] = array("elemento" => "caja - oculta","id" => "_validar_pago_fg" ,"reemplazo" => $validar_pago);
                
                    $idOcultos= generadorEtiquetaVVertical($formModal);
                       
                    $form['form_1'] = array("elemento" => "textarea","titulo" => "Nota", "id" => "_fg_nota", "reemplazo" => "");  
                    
                    $pie= str_replace("{contenedor_1}", generadorEtiqueta($form),  getPage('page_detalle') );
                    echo $alerta.$tablaDetalle.$pie.$idOcultos; 
     
                }
              
                break;    
            case 'KEY_GUARDAR_PAGO_FORUM_GRUPO': 
                 if( !empty($_POST['_fg_id_tipo_pago']) &&  !empty($_POST['_fg_id_forum'] ) 
                         && !empty($_POST['_fg_ff']) && !empty($_POST['_fg_fi']) && !empty($_POST['_porcentaje'])
                         && !empty($_POST['_lista_grupos']) && !empty($_POST['_id_porcentaje'])){  
    
                    $lista="";
                    if(isset($_POST['_lista_grupos'])){
                        foreach($_POST['_lista_grupos'] as $valor){
                            $lista.= $valor.",";
                        }
                    }
          
               
                     $objPago= new Pago();
                     $comp= $objPago->setPagoValorForumGrupos($_POST['_fg_id_tipo_pago'], $lista,$_POST['_porcentaje'],
                             $_POST['_fg_id_forum'], $_POST['_fg_fi'] , $_POST['_fg_ff'], $_SESSION['user_id_ben'],$_POST['_nota'], $_POST['_id_porcentaje']);  
                     if($comp == "OK"){
                        $data = array("success" => "true", "priority"=>'success',"msg" => 'El Pago al grupo se creo correctamente!');  
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
            case 'KEY_GUARDAR_PAGO_FRANQUICIA': 
                 if( !empty($_POST['_id_tipo']) &&  !empty($_POST['_base_total'] ) 
                         && !empty($_POST['_fg_ff']) && !empty($_POST['_fg_fi']) && !empty($_POST['_descuento'])
                         && !empty($_POST['_valor']) && !empty($_POST['_porcentaje_pagar']) ){  

                     
                     //redondear valor
                     $valor_pagar= round($_POST['_valor'], 2);
                     $objPago= new Pago();
                     $comp= $objPago->setPagoValorFranquicia($_POST['_id_tipo'],  $_POST['_fg_fi'] , $_POST['_fg_ff'], $valor_pagar,
                             ($_POST['_descuento'] == 'x')? '' : $_POST['_descuento'], $_SESSION['user_id_ben'],$_POST['_base_total'],$_POST['_nota'],$_POST['_porcentaje_pagar']);  
                     if($comp == "OK"){
                        $data = array("success" => "true", "priority"=>'success',"msg" => 'El Pago se creo correctamente!');  
                        echo json_encode($data);
                    }else{
                        $data = array("success" => "false", "priority"=>'info',"msg" => $comp); 
                        echo json_encode($data);
                    }


                 }  else {
                     $data = array("success" => "false", "priority"=>'info', "msg" => 'No se puede efectuar la transacción con valores en 0!');  
                     echo json_encode($data); 
                 }

                 break;  
            case 'KEY_GUARDAR_PORCENTAJE':///////////////////////////////////////////////////////////   
                 if(!empty($_POST['_porcentaje']) && !empty($_POST['_tipo'])){ 
             
                    $objPorcentaje= new Porcentaje();
                    $comp= $objPorcentaje->setCrearPorcentajeModal($_POST['_porcentaje'], $_SESSION['user_id_ben']);  
             
                        if($comp != "0"){       
                            $lista['lista_'] = array( "value" => "x",  "select" => "" ,"texto" => "Seleccione...");
                            $objPorcentaje= new Porcentaje();
                            $lista= $objPorcentaje->getLista($comp, $lista);                            
                            if($_POST['_tipo'] == "1"){
                                $data = array("success" => "true", "lista_porcentajes"=> generadorComboSelectOption("_porcentaje_pagar", "",$lista));
                            }else{
                                $data = array("success" => "true", "lista_porcentajes"=> generadorComboSelectOption("_descuento", "",$lista));
                            }
                              
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
    
$objTipoPago= new TipoPago();
$resultset= $objTipoPago->get();
$cont=1;
 while($row = $resultset->fetch_assoc()) { 
    if($cont == 1){
        $tipo_pago_franquicia= $row['tip_pag_id'];
        $name_franquicia= $row['tip_pag_descripcion'];
        $id_porc_franquicia=$row['porcentaje_porc_id'];
        $porc_franquicia=$row['valor_porcentaje'];
        $peri_franquicia= $row['num_periodos'];
         
    }elseif ($cont == 2) {
        $tipo_pago_forum_grupo=$row['tip_pag_id'];
        $name_forum_grupo=$row['tip_pag_descripcion'];
        $id_porc_forum_grupo=$row['porcentaje_porc_id'];
        $porc_forum_grupo=$row['valor_porcentaje'];
        $peri_forum_grupo=$row['num_periodos'];
        
    }elseif ($cont == 3) {
        $tipo_pago_miembro=$row['tip_pag_id'];
        $name_forum_miembro=$row['tip_pag_descripcion'];

    }elseif ($cont == 4) {
        $tipo_pago_forum_otros=$row['tip_pag_id'];
        $name_forum_otros_pagos=$row['tip_pag_descripcion'];   
    }elseif ($cont == 5) {
        $tipo_pago_varios=$row['tip_pag_id'];
        $name_pagos_varios=$row['tip_pag_descripcion'];   
    }
     
         
    $cont=$cont + 1;
 }
 ///////////////////////////////////////////////////////////////////////////////
 //Franquicia
$periodo= $peri_franquicia;
$mes_actual=date('m');
$respuesta=0;
$ano=date("Y");
for ($index = $periodo; $index < $mes_actual; $index =$index + $periodo) {
	$respuesta= $index;       
}
if($respuesta == 0){
    $respuesta=12;
    $ano=date("Y")-1;
}
$total= ($respuesta - $periodo) + 1;
$fecha_rango_inicio=  getPrimerDiaMes($ano, $total);

$fecha_rango_fin=  getUltimoDiaMes($ano, $total + ($periodo - 1));
$fecha_topoe_pago= getUltimoDiaMes($ano, $total + ($periodo - 1))." 23:59:00";

$lista['lista_'] = array( "value" => "x",  "select" => "selected" ,"texto" => "Seleccione...");
$objPorcentaje= new Porcentaje();
$lista_porcentajes= $objPorcentaje->getLista($id_porc_franquicia,$lista);
$objPorcentaje= new Porcentaje();
$lista_descuentos= $objPorcentaje->getLista("",$lista);

$objPago= new Pago();
$resultset= $objPago->getPagoValorFranquicia($tipo_pago_franquicia,$fecha_rango_inicio,$fecha_rango_fin,$fecha_topoe_pago);
 if($row = $resultset->fetch_assoc()) {
     if($row['cab_pag_id'] == ""){
         
        $boton_f['boton_2'] = array("elemento" => "boton","id" => "btnGuardarPF" ,"modal" => "" ,"color" => "btn-info" ,
        "click" => "setPagarFranquicia(".$tipo_pago_franquicia.",'".$fecha_rango_inicio."','".$fecha_rango_fin."')" ,"titulo" => "Autorizar" ,"lado" => "" ,"icono" => "fa-money");

        //Formularios
        $form1['form_1'] = array("elemento" => "caja" ,"disabled" => "disabled","tipo" => "text" , "titulo" => "Fecha de Pago Hasta", "id" => "_periodo" ,"reemplazo" => getFormatoFechadmy($fecha_rango_fin));
        $form1['form_2'] = array("elemento" => "caja" ,"disabled" => "disabled" ,"tipo" => "text" , "titulo" => "Valor Recaudado", "id" => "_base_total" ,"reemplazo" => "$ ".$row['valor']);
        $form1['form_3'] = array("elemento" => "combo + boton","change" => "getAplicarPorcentaje(1)", "disabled" => "" ,"titulo" => "Porcentaje a Pagar", "id" => "_porcentaje_pagar", "option" => $lista_porcentajes, 
                                            "modal" => "#modal_getCrearPorcentaje","boton_click" => "", "boton_icono" => "fa fa-plus-square","boton_nombre" => "", "boton_title" =>"Crear Porcentaje"
                                            ,"boton_tipo" => "btn-info");
        
        $form1['form_4'] = array("elemento" => "caja" ,"disabled" => "disabled" ,"tipo" => "text" , "titulo" => "Valor a Pagar", "id" => "_valor_sinrebate" ,"reemplazo" =>  "$ ".($row['valor'] * $porc_franquicia) / 100);

        $form1['form_5'] = array("elemento" => "combo + boton","change" => "getAplicarPorcentaje(2)", "disabled" => "" ,"titulo" => "Rebate", "id" => "_descuento", "option" => $lista_descuentos, 
                                            "modal" => "#modal_getCrearRebate","boton_click" => "", "boton_icono" => "fa fa-plus-square","boton_nombre" => "", "boton_title" =>"Crear Rebate"
                                            ,"boton_tipo" => "btn-info");
        $form1['form_6'] = array("elemento" => "caja" ,"disabled" => "disabled","tipo" => "text" , "titulo" => "Total a Pagar", "id" => "_valor_franquicia" ,"reemplazo" => "$ ".($row['valor'] * $porc_franquicia) / 100);
       
        $form1['form_7'] = array("elemento" => "textarea" ,"disabled" => "","titulo" => "Nota", "id" => "_nota_franquicia", "reemplazo" => "");  

        $html_franquicia = str_replace("{encabezado}", "Pago a Franquicia", getPage("page_detalle_1")); 
        $html_franquicia = str_replace("{boton}",generadorBoton2($boton_f), $html_franquicia); 
        $html_franquicia = str_replace("{contenedor_1}", generadorEtiquetaHorizontal($form1), $html_franquicia); 
        $html_franquicia =generadorContenedorColor("default", $html_franquicia);
        
     }else{
         
        $tabla['t_5'] = array("t_1" => generadorNegritas("Fecha de Pago Hasta"), "t_2" =>generadorResaltador("info",$row['cab_pag_fi']));
        $tabla['t_1'] = array("t_1" => generadorNegritas("Valor Recaudado:"), "t_2" => "$ ".$row['cab_pag_valor_base']);
        $tabla['t_2'] = array("t_1" => generadorNegritas("Porcentaje a Pagar:"), "t_2" =>$row['porcentaje']."%" );
        $tabla['t_3'] = array("t_1" => generadorNegritas("Rebate:"), "t_2" =>($row['descuento'] == '') ? '0 %': $row['descuento']."%" );
        $tabla['t_4'] = array("t_1" => generadorNegritas("Total Pagado:"), "t_2" => "$ ".$row['cab_pag_valor'] );   
        $tabla['t_6'] = array("t_1" => generadorNegritas("Nota:"), "t_2" => $row['cab_pag_nota']);
         
     
        //$diseño= generadorResaltador("info",$diseño);
        $html_franquicia = str_replace("{encabezado}", "Pagó a Franquicia", getPage("page_detalle_1")); 
        $html_franquicia = str_replace("{boton}","", $html_franquicia); 
        $html_franquicia = str_replace("{contenedor_1}", generadorTablaTranparente($tabla) , $html_franquicia);
        $html_franquicia =generadorContenedorColor("default", $html_franquicia);
         
     }
     
 }

////////////////////////////////////////////////////////////////////////////////   
//Los rangos para forum grupos
$periodo= $peri_forum_grupo;
$mes_actual=date('m');
$respuesta=0;
$ano=date("Y");
for ($index = $periodo; $index < $mes_actual; $index =$index + $periodo) {
	$respuesta= $index;       
}
if($respuesta == 0){
    $respuesta=12;
    $ano=date("Y")-1;
}
$total= ($respuesta - $periodo) + 1;
$fecha_rango_inicio=  getPrimerDiaMes($ano, $total);
$fecha_rango_fin=  getUltimoDiaMes($ano, $total + ($periodo - 1));
 
if (in_array($perVerTodosOpcionesPagoOp14, $_SESSION['usu_permiso'])) {
    $objForumLeader= new ForumLeader();
    $cuerpo='';$cont=1;
    $resultset= $objForumLeader->getForumLeader(NULL);
    
}elseif(in_array($perVerOpcionesPagoIDForumOp14, $_SESSION['usu_permiso'])) {
    $objForumLeader= new ForumLeader();
    $cuerpo='';$cont=1;
    $resultset= $objForumLeader->getForumLeader($_SESSION['user_id_ben']);
    
}
 while($row = $resultset->fetch_assoc()) {
     $acciones['boton_1'] = array("elemento" => "boton" ,"modal" => "#modal_PagarForumGrupos" ,"color" => "btn-info" ,
         "click" => "getPagoForumGrupo(".$tipo_pago_forum_grupo.",'".$fecha_rango_inicio."','".$fecha_rango_fin."',".$row['usu_id'].",".$id_porc_forum_grupo.",".$porc_forum_grupo.")" 
         ,"titulo" => "Cobros" ,"lado" => "" ,"icono" => "fa-money");
     $acciones['boton_2'] = array("elemento" => "boton" ,"modal" => "#modal_PagarForum" ,"color" => "btn-info" ,
         "click" => "getPagoForum(".$tipo_pago_miembro.",".$row['usu_id'].",1,'".$row['per_nombre']." ".$row['per_apellido']."')" 
         ,"titulo" => "# Miembros" ,"lado" => "" ,"icono" => "fa-user");
     $acciones['boton_3'] = array("elemento" => "boton" ,"modal" => "#modal_PagarForum" ,"color" => "btn-info" ,
         "click" => "getPagoForum(".$tipo_pago_forum_otros.",".$row['usu_id'].",2,'".$row['per_nombre']." ".$row['per_apellido']."')" 
         ,"titulo" => "Otros" ,"lado" => "" ,"icono" => "fa-dollar");
     
     $cuerpo.= generadorTablaColoresFilas("",array(
         "<center>".$cont."</center>",
         $row['per_nombre'].' '.$row['per_apellido'],
         "<center>".generadorBotonSinLado($acciones)."</center>")); 
     $cont=$cont + 1;   
 }  
 $diseño='<h3>Pago a Forum Leader por concepto de Grupos</h3>'.
         generadorTablaDetalleEstadoCuenta(
                 array("<center>N°</center>", "Forum Leader",'<center>Pagar</center>'),
                 $cuerpo);
  $t= generadorContenedorColor("default", $diseño);
  
  
 ////////////////////////////////////////////////////////////////////////////////
 //Varios
  
$boton_otros['boton_2'] = array("elemento" => "boton","id" => "btnGuardarPFVarios" ,"modal" => "" ,"color" => "btn-info" ,
        "click" => "setPagarVarios(".$tipo_pago_varios.")" ,"titulo" => "Autorizar" ,"lado" => "" ,"icono" => "fa-money");

$form3['form_1'] = array("elemento" => "caja" ,"disabled" => "","tipo" => "text" , "titulo" => "Valor a Pagar", "id" => "_valor_varios" ,"reemplazo" => "");
$form3['form_4'] = array("elemento" => "textarea" ,"disabled" => "","titulo" => "Nota", "id" => "_nota_varios", "reemplazo" => "");  

$html_otros = str_replace("{encabezado}", "Pago Varios", getPage("page_detalle_1")); 
$html_otros = str_replace("{boton}",generadorBoton2($boton_otros), $html_otros); 
$html_otros = str_replace("{contenedor_1}", generadorEtiquetaHorizontal($form3), $html_otros); 
$html_otros =generadorContenedorColor("default", $html_otros);
////////////////////////////////////////////////////////////////////////////////
//consultas
$cont=1;
$cuerpo='';
$objPago= new Pago();
$resultset= $objPago->getPagos();
while($row = $resultset->fetch_assoc()) {    
     $cuerpo.= generadorTablaFilas(array(
         $row['tipo'],
         "$ ".$row['cab_pag_valor'],
         $row['cab_pag_nota'],
         getFormatoFechadmy($row['cab_pag_fecharegistro'])));                                                                                   

     $cont=$cont + 1;   
 }   
$tabla_consulta= generadorTablaModal(1,"","", array( "Tipo Pago", "Valor","Nota", "Fecha"), $cuerpo);      


////////////////////////////////////////////////////////////////////////////////
//tab
if (in_array($perPagoFranquiciaOp14, $_SESSION['usu_permiso'])) {
    $tab['tab_1'] = array("titulo" => $name_franquicia, "id" => "t_1" , "reemplazo" => "{t_1}");
}
if (in_array($perPagoForumOp14, $_SESSION['usu_permiso'])) {
    $tab['tab_2'] = array("titulo" => "Forum Leader", "id" => "t_2", "reemplazo" => "{t_2}"); 
}
if (in_array($perPagoVariosOp14, $_SESSION['usu_permiso'])) {
    $tab['tab_5'] = array("titulo" => $name_pagos_varios, "id" => "t_5", "reemplazo" => "{t_5}");  
}
if (in_array($perPagoVerReportesOp14, $_SESSION['usu_permiso'])) {
    $tab['tab_6'] = array("titulo" => "Reportes", "id" => "t_6", "reemplazo" => "{t_6}"); 
}

$resultado = str_replace("{t_1}", $html_franquicia, generadorTabVertical($tab)); 
$resultado = str_replace("{t_2}", $t, $resultado); 
$resultado = str_replace("{t_5}", $html_otros, $resultado); 
$resultado = str_replace("{t_6}", $tabla_consulta, $resultado); 

$resultado = str_replace("{contenedor_1}", $resultado,  getPage('page_detalle_update') );  
$t= $resultado;
//UPDATE `cobro_grupo_pago` SET `cgp_estado_pago_grupo`='0',`cgp_estado_pago_franquicia`='0'