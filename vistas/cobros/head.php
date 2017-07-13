<?php
require_once MODELO.'EmpresaLocal.php';
require_once MODELO.'Grupo.php';
require_once MODELO.'PresupuestoCobro.php';
require_once MODELO.'ForumLeader.php';
require_once MODELO.'Periodo.php';
require_once MODELO.'FormaPago.php';
require_once MODELO.'Cobro.php';
require_once MODELO.'Miembro.php';
require_once MODELO.'Inscripcion.php';
include(HTML."/html_combos.php");
include(HTML."/html.php");
include(HTML."/html_2.php");
include(HTML."/html_filtros.php");
$objPresupuestoCobro;
$objGrupo;
$objEmpresaLocal;
$objFormaPago;
include(LENGUAJE."/lenguaje_1.php");

                        
function getDetalleEmpresaConMiembros($id, $key, $año) {  
     if(isset($_SESSION['cobro_ultimo_id'])){
        $id= $_SESSION['cobro_ultimo_id'];
        $key= $_SESSION['cobro_key'];
    }
    $cuerpo='';
    $objPresupuestoCobro= new PresupuestoCobro();
    if($key == "EMPRESA"){
        $resultset= $objPresupuestoCobro->getPresupuestoCobroMiembrosxEmpresas($id, $año);
    }elseif ($key == "MIEMBRO") {
        $resultset= $objPresupuestoCobro->getPresupuestoCobroMiembrosxMiembros($id, $año);
    }elseif ($key == "GRUPO"){
        $resultset= $objPresupuestoCobro->getPresupuestoCobroMiembrosFiltroGrupo($id,$año );
    }
    
    while ($row = $resultset->fetch_assoc()) {   
        $boton= array();
        $objGrupo = new Grupo();
        $result2 = $objGrupo->getGrupoByMiembro($row['mie_id']);

        $nombre= $row['per_nombre'] ." ". $row['per_apellido'];


        if ($row2 = $result2->fetch_assoc()) {
            
                if($row['valor_inscripcion'] != ""){
                if (in_array($row2['agrup'], array('A'))) {
                    $objInscripcion = new Inscripcion();
                    $result6 = $objInscripcion->getInscripcion($row['mie_id']);
                    $mostrar = true;
                    $valorins = 0;
                    if ($row6 = $result6->fetch_assoc()) {
                        $valorins = $row6['mie_ins_valor'];
                        if ($row6['mie_ins_valor'] == 0) {                            
                            $mostrar = false;
                        }
                    }

                    $msg="El valor de la Inscripción del Miembro ".$nombre." es de : $ ".$valorins;
                    //if ($row['valor_inscripcion'] == 0) {

                    if ($mostrar) {
                        $boton['boton_1'] = array("elemento" => "boton" ,"modal" => "#modal_InscripcionCobro" ,"color" => "btn-info", 
                            "click" => "getGenerarInscripcionCobro('".$msg."',".$row['mie_id'].")" ,"titulo" => "Cobrar Inscripción", 
                            "lado" => "" ,"icono" => "fa-money"); 
                        }                    
                    //}
                }
            }
            
        }
        $boton['boton_2'] = array("elemento" => "boton" ,"modal" => "#modal_detalleCobro" ,"color" => "btn-info" ,"click" => "getGenerarDetalleCobro('".$nombre."',".(($row['precobro_id'] == "") ? "0": $row['precobro_id']) .",".$row['mie_id'].")" ,"titulo" => "Cobrar Cuotas" ,"lado" => "" ,"icono" => "fa-money");
        
        $cuerpo.= generadorTablaColoresFilas("" , array(     
                   $nombre,
                   generadorBoton($boton)));   
        // $tabla_miembros= generadorTablaModal(1,"","", array( "Código", "Nombre",'EF Paid','1st FM','Dues Mo','YTD'), $cuerpo);     
    }
    $tablaDetalleMiembros=  generadorTablaModal(1,"","", array( "Miembros",""), $cuerpo);     
    return "<h4></h4>".$tablaDetalleMiembros.'<div id="ben_contenedor_detalle_cobro"></div>';
    
    
    
    
}
function getCheckPrincipal($total) {
    $msg='';
    $msg='<center><input type="checkbox" id="selectall" name="'.$total.'" onclick="getSeleccionarTodos()"/></center>'; 
    return $msg;
}
function getCheckCobro($id, $idPresupuesto, $disabled, $bandera, $cobro ) {
    $msg='';
    $msg='<center><input type="checkbox" class="'.$bandera.'" name="'.$idPresupuesto.'" id="'.$id.'" '.$disabled.' value="'.$cobro.'" onclick="getSeleccionarCobro()" /></center>'; 
    return $msg;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    try{
        switch ($_POST['KEY']): 
            case 'KEY_ACTUALIZA_FILTRO_MIEMBRO_EMPRESA':
                $lista['lista_']= array("value" => "x",  "select" => "" ,"texto" => "Seleccione..."); 
                $objMiembro = new Miembro();
                $lista = $objMiembro->getListaMiembrosByEmpresa($lista, $_POST['_id']);
                $form2['form_2'] = array("elemento" => "combo","change" => "getDetalleFiltroMiembro()","titulo" => "<h4>Miembros</h4>", "id" => "_miembros", "option" => $lista);  
                echo generadorEtiquetasFiltro($form2);

            break;
            case 'KEY_ACTUALIZA_FILTRO_GRUPO_EMPRESA':
                $lista['lista_']= array("value" => "x",  "select" => "" ,"texto" => "Seleccione..."); 
                $objGrupo = new Grupo();
                $lista = $objGrupo->getListaGruposByEmpresa($lista, $_POST['_id']);
                $form3['form_3'] = array("elemento" => "combo","change" => "getDetalleFiltroGrupo()","titulo" => "<h4>Grupos</h4>", "id" => "_grupos", "option" => $lista); 
                echo generadorEtiquetasFiltro($form3);
            break;

            case 'KEY_ACTUALIZA_FILTRO_MIEMBRO_GRUPO':
                $lista['lista_']= array("value" => "x",  "select" => "" ,"texto" => "Seleccione..."); 
                $objMiembro = new Miembro();
                $lista = $objMiembro->getListaMiembrosByGrupo($lista, $_POST['_id']);
                $form2['form_2'] = array("elemento" => "combo","change" => "getDetalleFiltroMiembro()","titulo" => "<h4>Miembros</h4>", "id" => "_miembros", "option" => $lista);  
                echo generadorEtiquetasFiltro($form2);            
            break;

            case 'KEY_DETALLE_FILTRO_EMPRESA':
                if(strlen($_POST['_id']) > 0){ 
                    $_SESSION['cobro_ultimo_id']=$_POST['_id'];
                    $_SESSION['cobro_key']=$_POST['_key_filtro'];
                    echo getDetalleEmpresaConMiembros($_POST['_id'],$_POST['_key_filtro'] ,$_POST['_año']);
                    exit();            
                } else {
                    $objGrupo = new Grupo();
                    echo getDetalleEmpresaConMiembros($objGrupo->getPrimerGrupo(), "GRUPO", $_POST['_año']);
                }
                break;

            case 'KEY_DETALLE_COBRO_ANHO':
                if (! empty($_POST['_id_miembro']) && ! empty($_POST['_anho'])) {
                    $objPresupuestoCobro= new PresupuestoCobro();
                    $resultset= $objPresupuestoCobro->getDetallePresupuestoMiembroByAnho($_POST['_id_miembro'], $_POST['_anho']);
                    $estadoColor="danger";
                    $disabled="";
                    $bandera="case";
                    $cont = 1;
                    $cuerpo = "";

                    while($row = $resultset->fetch_assoc()) {
                        if($row['estado_presupuesto_est_pre_id'] == '2'){                            
                            $estadoColor="success";
                            $disabled="";
                            $bandera="case2";                                                   
                        }
                       
                        $fecha= $row['detalleprecobro_fechavencimiento'];

                         $cuerpo.= generadorTablaColoresFilas("" ,
                               array(
                                   getCheckCobro($cont,$row['detalleprecobro_id'],$disabled,$bandera, $row['detalleprecobro_valor']),                 
                                   getFormatoFechadmy($fecha),
                                   "$ ".$row['detalleprecobro_valor'],           
                                   '<span class="label label-'.$estadoColor.'">'.$row['detalleprecobro_estado'].'</span>')); 
                         $cont=$cont + 1;
                         $estadoColor="danger";
                         $disabled="";
                         $bandera="case";
                    }
                    if (strlen($cuerpo) > 0) {
                        $tablaDetalle= generadorTablaDetalleContenidoEstadoCuentaAdminReg(
                        array( 
                            getCheckPrincipal($cont - 1),
                            //generadorNegritas("N°"),
                            generadorNegritas("Fecha"),
                            generadorNegritas("Valor a Cobrar"),
                            generadorNegritas("Estado")), $cuerpo); 
                        echo $tablaDetalle;
                    } else {
                        echo '<center><h1>No hay presupuesto para el año elegido</h1></center></br></br></br></br>';                 
                    }                                                           
                } else {                    
                    echo '<center><h1>Faltan Datos</h1></center></br></br></br></br>';                
                }
            break;
            
            case 'KEY_DETALLE_PRESUPUESTO_COBRO':
                        
                if(!empty($_POST['_nombre']) &&  !empty($_POST['_id_presupuesto']) && !empty($_POST['id_miembro'])){ 
                    $estadoColor="danger";
                    $disabled="";
                    $bandera="case";
                    $cuerpo="";
                    $cont=1;
                    $credito = 0;
                    $esadminreg = false;                    
                    if (in_array(trim($_SESSION['user_perfil']), array('Administrador Regional', 'IBP'))) {
                        $esadminreg = true;
                    }
                    if ($esadminreg) {
                        $listaYear = array();
                        $anho = intval(date('Y'));
                        $objPresupuestoCobro3 = new PresupuestoCobro();
                        $resultPresup = $objPresupuestoCobro3->getPresupuestoMiembro($_POST['_id_presupuesto']);
                        $anhopresupuesto = "";
                        if ($row4 = $resultPresup->fetch_assoc()) {
                            $anhopresupuesto = $row4['precobro_year'];
                        }
                        for ($i = $anho; $i > $anho-5; $i--) {        
                            if ($anhopresupuesto == $i) {
                                $listaYear['lista_' . $i] = array("value" => $i, "select" => "selected", "texto" => $i);
                            } else {
                                $listaYear['lista_' . $i] = array("value" => $i, "select" => "", "texto" => $i);
                            }                                                    
                        }                        
                        
                        $form6['form_1'] = array("elemento" => "combo","change" => "cambioAnhoCobro()", "titulo" => "Año", "id" => "_anho_cobro", "option" => $listaYear);
                        $head1 = str_replace("{contenedor_2}", generadorEtiqueta($form6),  getPage('page_detalle'));
                        $head1 = str_replace("{contenedor_1}", "",  $head1);
                        
                    }
                    
                    $objPresupuestoCobro= new PresupuestoCobro();
                    $credito = $objPresupuestoCobro->getCreditoMiembro($_POST['_id_presupuesto']);
                    $objPresupuestoCobro2= new PresupuestoCobro();
                    $resultset= $objPresupuestoCobro2->getDetallePresupuestoMiembro($_POST['_id_presupuesto']);
                    
                        

                    while($row = $resultset->fetch_assoc()) { 
                        if($row['estado_presupuesto_est_pre_id'] == '2'){
                            if (! $esadminreg) {
                                $estadoColor="success";
                                $disabled="disabled";
                                $bandera="";
                            } else {
                                $estadoColor="success";
                                $disabled="";
                                $bandera="case2";
                            }
                           
                        }
                       
                        $fecha= $row['detalleprecobro_fechavencimiento'];

                         $cuerpo.= generadorTablaColoresFilas("" ,
                               array(
                                   getCheckCobro($cont,$row['detalleprecobro_id'],$disabled,$bandera, $row['detalleprecobro_valor']),                 
                                   getFormatoFechadmy($fecha),
                                   "$ ".$row['detalleprecobro_valor'],           
                                   '<span class="label label-'.$estadoColor.'">'.$row['detalleprecobro_estado'].'</span>')); 
                         $cont=$cont + 1;
                         $estadoColor="danger";
                         $disabled="";
                         $bandera="case";
                     }
          
                     if ($esadminreg) {
                        $tablaDetalle= generadorTablaDetalleEstadoCuentaAdminReg(
                        array( 
                            getCheckPrincipal($cont - 1),
                            //generadorNegritas("N°"),
                            generadorNegritas("Fecha"),
                            generadorNegritas("Valor a Cobrar"),
                            generadorNegritas("Estado")), $cuerpo); 
                     } else {
                        $tablaDetalle= generadorTablaDetalleEstadoCuenta(
                        array( 
                            getCheckPrincipal($cont - 1),
                            //generadorNegritas("N°"),
                            generadorNegritas("Fecha"),
                            generadorNegritas("Valor a Cobrar"),
                            generadorNegritas("Estado")), $cuerpo); 
                     }
                    
                    $formModal['form_1'] = array("elemento" => "caja - oculta","id" => "_id_presupuesto_cobro" ,"reemplazo" => $_POST['_id_presupuesto']);
                    $formModal['form_2'] = array("elemento" => "caja - oculta","id" => "_id_miembro_cobro" ,"reemplazo" =>$_POST['id_miembro']);  
                    $idOcultos= generadorEtiquetaVVertical($formModal);
                    
               
                    $objFormaPago= new FormaPago();
                    $listaFormaPago= $objFormaPago->getListaFormaPago();    

                    $form['form_1'] = array("elemento" => "combo","change" => "","titulo" => "Forma de Pago", "id" => "_formapago", "option" => $listaFormaPago);  
                    if (! $esadminreg) {
                        $boton_f['boton_2'] = array("elemento" => "boton","id" => "btnGuardar" ,"modal" => "" ,"color" => "btn-primary" ,
                        "click" => "setCobrar()" ,"titulo" => "Cobrar" ,"lado" => "" ,"icono" => ""); 
                    } else {
                        $boton_f['boton_2'] = array("elemento" => "boton","id" => "btnGuardar" ,"modal" => "" ,"color" => "btn-primary" ,
                        "click" => "setCobrarAdminReg()" ,"titulo" => "Cobrar" ,"lado" => "" ,"icono" => ""); 
                    }
                    
                    $boton_r['boton_2'] = array("elemento" => "boton","id" => "btnReversar" ,"modal" => "" ,"color" => "btn-primary" ,
                    "click" => "setReversarCobros()" ,"titulo" => "Reversar Cobros" ,"lado" => "" ,"icono" => ""); 
                    
                     
                    $form2['form_1'] = array("elemento" => "caja pequeña", "titulo" => "Monto Pagado ", "tipo" => "text", "id" => "_montopagado");  
                    $form3['form_1'] = array('elemento' => "Checkbox-color", "titulo" => "Utilizar credito de $ " . $credito,                     
                    "chec" => 'value="'.$credito.'"', "id" => "_credito");
                    $form4['form_1'] = array("elemento" => "caja pequeña", "titulo" => "Monto Reversado ", "tipo" => "text", "id" => "_montoreversado", "reemplazo" => 0);  
                    $form5['form_1'] = array("elemento" => "caja" ,"tipo" => "date", "titulo" => "Fecha de Cobro", "id" => "_fecha_cobro", "reemplazo" => date('Y-m-d'));                                            
                    $pie= str_replace("{contenedor_1}", generadorEtiqueta($form2),  getPage('page_detalle'));
                    $pie= str_replace("{contenedor_2}", generadorEtiqueta($form),  $pie );
                    $pie2 = str_replace("{contenedor_1}", generadorEtiqueta($form3), getPage('page_detalle'));                                        
                    
                    if ($esadminreg) {
                        $pie2 = str_replace("{contenedor_2}", generadorEtiqueta($form5), $pie2);             
                        $pie3 = str_replace("{contenedor_1}", generadorEtiqueta($form4), getPage('page_detalle'));                                        
                        $pie3 = str_replace("{contenedor_2}", "", $pie3);                                        
                        $html = str_replace("{cuerpo}", $head1.$tablaDetalle.$pie.$pie2.$pie3.$idOcultos, getPage("page_detalle_forum_modal")); 
                        
                    } else {
                        $pie2 = str_replace("{contenedor_2}", "", $pie2);             
                        $html = str_replace("{cuerpo}", $tablaDetalle.$pie.$pie2.$idOcultos, getPage("page_detalle_forum_modal")); 
                    }                           
                    
                    
                    $html = str_replace("{boton}",generadorBoton3($boton_f), $html); 
                    if (! $esadminreg) {
                        $html = str_replace("{boton2}","", $html); 
                    } else {
                        $html = str_replace("{boton2}",generadorBoton3($boton_r), $html); 
                    }
                    
                    
                    
                    echo $html; 
                    
                    
                    
                   // echo $tablaDetalle.generadorEtiquetasFiltroSencillo($form).$idOcultos;
       
                }else{
                    echo '<center><h1>Debes agregar un presupuesto!</h1></center></br></br></br></br>';
                }
              
                break;
                
            case 'KEY_GUARDAR_COBRO': 
                 
                 if( !empty($_POST['_id_presupuesto']) && !empty($_POST['_lista_id_detalle_presupuesto'] ) 
                 && !empty($_POST['_formapago'] ) && !empty($_POST['_id_miembro']) 
                 &&  strlen($_POST['_bandera_credito']) > 0 && strlen($_POST['_resto'])>0 ){  
                    
               
                    $lista="";
                    if(isset($_POST['_lista_id_detalle_presupuesto'])){
                        foreach($_POST['_lista_id_detalle_presupuesto'] as $valor){
                            $lista.= $valor.",";
                        }
                    }

                     $objPresupuestoCobro = new PresupuestoCobro();
                    $resultado = $objPresupuestoCobro->actualizarCreditoPresupuestoMiembro($_POST['_id_presupuesto'], $_POST['_resto'], $_POST['_bandera_credito']); 
                   
                     $objCobro= new Cobro();
                     $comp= $objCobro->setGrabar($_POST['_id_presupuesto'],$lista,$_POST['_id_miembro'], $_POST['_formapago'],$_SESSION['user_id_ben']);  
                    
                   
                                    
                    
                     if($comp == "OK"){
                       
                        $data = array("success" => "true", "priority"=>'success',"msg" => 'El Cobro se creo correctamente!');  
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

            case 'KEY_GUARDAR_COBRO_ADMIN_REG': 
                 
                 if( !empty($_POST['_id_presupuesto']) && !empty($_POST['_lista_id_detalle_presupuesto'] ) 
                 && !empty($_POST['_formapago'] ) && !empty($_POST['_id_miembro']) && ! empty($_POST['_fecha'])
                 &&  strlen($_POST['_bandera_credito']) > 0 && strlen($_POST['_resto'])>0 ){  
                    
               
                $fechad = date_format(date_create($_POST['_fecha']), 'Y-m-d H:i:s');
                    $lista="";
                    if(isset($_POST['_lista_id_detalle_presupuesto'])){
                        foreach($_POST['_lista_id_detalle_presupuesto'] as $valor){
                            $lista.= $valor.",";
                        }
                    }

                     $objPresupuestoCobro = new PresupuestoCobro();
                    $resultado = $objPresupuestoCobro->actualizarCreditoPresupuestoMiembro($_POST['_id_presupuesto'], $_POST['_resto'], $_POST['_bandera_credito']); 
                   
                     $objCobro= new Cobro();
                     $comp= $objCobro->setGrabarWithDatetime($_POST['_id_presupuesto'],$lista,$_POST['_id_miembro'], $_POST['_formapago'],$_SESSION['user_id_ben'], $fechad);  
                    
                   
                                    
                    
                     if($comp == "OK"){
                       
                        $data = array("success" => "true", "priority"=>'success',"msg" => 'El Cobro se creo correctamente!');  
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


            case 'KEY_REVERSAR_COBRO': 
                 
                 if (! empty($_POST['_id_presupuesto']) && ! empty($_POST['_lista_id_detalle_presupuesto'] ) 
                  && ! empty($_POST['_id_miembro'])) {  
                                   
                    $lista="";
                    if(isset($_POST['_lista_id_detalle_presupuesto'])){
                        foreach($_POST['_lista_id_detalle_presupuesto'] as $valor){
                            $lista.= $valor.",";
                        }
                    }
                   
                     $objCobro= new Cobro();
                     $comp= $objCobro->setReversar($_POST['_id_presupuesto'], $lista,$_POST['_id_miembro']);  
                    $objCobro2= new Cobro();
                    $results = $objCobro2->setUpdateCobrosByPresupuesto($_POST['_id_presupuesto'], $lista,$_POST['_id_miembro']);                                                       
                    
                     if($comp == "OK"){                       
                        $data = array("success" => "true", "priority"=>'success',"msg" => 'El Cobro se reverso correctamente!');  
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
            
            case 'KEY_GUARDAR_COBRO_INSCRIPCION': 
                 
                 if( !empty($_POST['_id_inscripcion_miembro'])){  
               
                     $objInscripcion= new Inscripcion();
                     $comp= $objInscripcion->setCobrar($_POST['_id_inscripcion_miembro'],$_SESSION['user_id_ben']);  
   
                     if($comp == "OK"){
                        $data = array("success" => "true", "priority"=>'success',"msg" => 'El Cobro se realizó correctamente!');  
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
function getTablaFiltro($listaMiembros= array(),$listaEmpresa= array(), $listaGrupos= array(),$tabla_miembros='' ) {
    global $perVerTodosFiltrosCobrosOp13, $perVerFiltrosIDForumOp13;
    if(count($listaEmpresa) > 0 ){
        $form1['form_1'] = array("elemento" => "combo","change" => "getDetalleFiltroEmpresa()","titulo" => "<h4>Empresa</h4>", "id" => "_empresa", "option" => $listaEmpresa); 
    }
    if(count($listaMiembros) > 0 ){
        $form2['form_2'] = array("elemento" => "combo","change" => "getDetalleFiltroMiembro()","titulo" => "<h4>Miembros</h4>", "id" => "_miembros", "option" => $listaMiembros);  
    }
    if(count($listaGrupos) > 0 ){
        $form3['form_3'] = array("elemento" => "combo","change" => "getDetalleFiltroGrupo()","titulo" => "<h4>Grupos</h4>", "id" => "_grupos", "option" => $listaGrupos); 
    }
   $form4['form_1'] = array("elemento" => "combo","disabled" => "","change" => "getDetalleFiltroAnho()","titulo" => "<h4>Año</h4>", "id" => "_año", "option" => generadorComboAños(date('Y')));
    if (in_array($perVerTodosFiltrosCobrosOp13, $_SESSION['usu_permiso'])) {
        $resultado = str_replace("{contenedor_1}", generadorEtiquetasFiltro($form1),  getPage('page_detalle_filtros')); 
    }  elseif (in_array($perVerFiltrosIDForumOp13, $_SESSION['usu_permiso'])) {
        $resultado =   getPage('page_detalle_filtros_forum'); 
    }
         
    $resultado = str_replace("{contenedor_2}", generadorEtiquetasFiltro($form2), $resultado); 
    $resultado = str_replace("{contenedor_3}", generadorEtiquetasFiltro($form3), $resultado); 
    $resultado = str_replace("{contenedor_4}", '<div id="ben_contenedor_tabla">'.$tabla_miembros.'</div>', $resultado); 
    $resultado = str_replace("{contenedor_5}", generadorEtiquetasFiltro($form4), $resultado); 
    $resultado = str_replace("{boton}", "", $resultado);  
    $resultado = str_replace("{cabecera}", "Cobros", $resultado);   

    return $resultado;
}


if (in_array($perVerTodosFiltrosCobrosOp13, $_SESSION['usu_permiso'])) {

    $lista['lista_']= array("value" => "x",  "select" => "" ,"texto" => "Seleccione...");
    $objEmpresaLocal= new EmpresaLocal();
    $listaEmpresa= $objEmpresaLocal->getListaEmpresa2($objEmpresaLocal->getPrimerEmpresa(), $lista);
    
    $objMiembro= new Miembro();
    $listaMiembros= $objMiembro->getListaMiembros(NULL, $lista,"",FALSE);
    
    $objGrupo= new Grupo();
    $listaGrupos= $objGrupo->getListaGrupos2(NULL,$lista);
    
    $tabla_miembros= getDetalleEmpresaConMiembros($objGrupo->getPrimerGrupo(), "GRUPO", date('Y')); 
    
    $t=getTablaFiltro($listaMiembros,$listaEmpresa,$listaGrupos, $tabla_miembros );
    
 }  elseif (in_array($perVerFiltrosIDForumOp13, $_SESSION['usu_permiso'])) {
    
    $lista['lista_']= array("value" => "x",  "select" => "" ,"texto" => "Seleccione...");   
    $objMiembro= new Miembro();
    $listaMiembros= $objMiembro->getListaMiembros(NULL, $lista,$_SESSION['user_id_ben'],FALSE);
    
    $objGrupo= new Grupo();
    $listaGrupos= $objGrupo->getListaGruposForum($_SESSION['user_id_ben'],NULL, $lista); 
    
    $tabla_miembros= getDetalleEmpresaConMiembros($objGrupo->getPrimerGrupo(), "GRUPO", date('Y')); 
    
    $t=getTablaFiltro($listaMiembros ,NULL, $listaGrupos ,$tabla_miembros);
    
}
$objPerido= new Periodo();
$listaPeriodos= $objPerido->getListaComboPeriodo("");





