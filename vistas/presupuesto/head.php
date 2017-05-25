<?php
require_once MODELO.'Grupo.php';
require_once MODELO.'PresupuestoCobro.php';
require_once MODELO.'ForumLeader.php';
require_once MODELO.'Periodo.php';
require_once MODELO.'Membresia.php';
require_once MODELO.'TipoPresupuesto.php';
require_once MODELO.'Miembro.php';
include(HTML."/html.php");
include(HTML."/html_filtros.php");
include(HTML."/html_2.php");
$objPresupuestoCobro;
$objGrupo;
$objTipoPresupuesto;
include(LENGUAJE."/lenguaje_1.php");
function getDetalleGruposConMiembros($idGrupo) {
        $cont=1;
        $cuerpo='';
        $objPresupuestoCobro= new PresupuestoCobro();
        $resultset= $objPresupuestoCobro->getPresupuestoCobroMiembrosxGrupos($idGrupo, date('Y'));//precobro_id
         while($row = $resultset->fetch_assoc()) { 
           
             $nombre= $row['per_nombre'].' '.$row['per_apellido'];
             $id_presupuesto= (empty($row['precobro_id']) ? "0" : $row['precobro_id']);
             $id_periodo= (empty($row['periodo_perio_id']) ? "0" : $row['periodo_perio_id']);
                
             $fecha_registro_cobros= (empty($row['precobro_fechainiciomiembro']) ? date('Y-m-d',strtotime($row['mie_fecharegistro'])) : date('Y-m-d',strtotime($row['precobro_fechainiciomiembro'])));
             //para cuando desee actualizar y ya existan cobros en base a ese presupuesto
             $ultimaFechaXPagar= (empty($row['ultima_fecha_x_pagar']) ? "0" : date('Y-m-d',strtotime($row['ultima_fecha_x_pagar'])));
             $fechaXPagar= (empty($row['fecha_x_pagar']) ? "0" : date('Y-m-d',strtotime($row['fecha_x_pagar'])));
             if($fechaXPagar != "0"){
                 if($fechaXPagar <= $fecha_registro_cobros){
                     $fechaXPagar= "0";
                 }
             }
             ///////////////////////////////////////////////////////////////////
             $id_membresia= (empty($row['membresia_id']) ? "0" : $row['membresia_id']);
             $funcion_1= "getAgregarPresupuesto(".$id_presupuesto.",".$row['mie_id'].",".$id_membresia.",'".$nombre."',".$id_periodo.",'".$fecha_registro_cobros."','".$fechaXPagar."','".$ultimaFechaXPagar."')";
             $funcion_2="getDetallePresupuesto(".$id_presupuesto.")";
             $cuerpo.= generadorTablaFilas(array(
                 "<center>".$cont."</center>",
                 $nombre,
                 (empty($row['memb_descripcion']) ? '<span class="label label-danger">-none-</span>' :'<span class="label label-warning">'. $row['memb_descripcion'].'</span>'),
                 (empty($row['precobro_periodo']) ? '<span class="label label-danger">-none-</span>' :'<span class="label label-success">'. $row['precobro_periodo'].'</span>'),
                 (empty($row['precobro_valor']) ? "$ 0.00" : "$ ". $row['precobro_valor']),
                 (empty($row['precobro_total']) ? "$ 0.00" : "$ ".$row['precobro_total']),
                 
                 "<center>".getAccionesParametrizadas($funcion_1,"modal_agregarPresupuesto","Presupuesto" , "fa fa-pencil")
                 .getAccionesParametrizadas($funcion_2,"modal_detallePresupuesto","Ver Presupuesto" , "fa fa-eye")."</center>"));                                                                                   
        
             $cont=$cont + 1;   
         }   
        $objGrupo= new Grupo();
        $tabla_miembros= generadorTablaModal(1,"",'getCrear_()', array( "N°", "Nombre", "Membresía","Período","Valor", "Total a Cobrar" , "Acción"), $cuerpo);      
        return $tabla_miembros;
}

function getCrearOActualizarPresupuesto($idMiembro, $nombre, $fechaRegistro) {
                           
    $modal="";
    $id_presupuesto="0";
    $objMiembro= new Miembro();
    $resultset= $objMiembro->getPresupuesto($idMiembro, date('Y'));  
    if($row = $resultset->fetch_assoc()) { 
        
        $id_presupuesto= (empty($row['precobro_id']) ? "0" : $row['precobro_id']);
        $id_periodo= (empty($row['periodo_perio_id']) ? "0" : $row['periodo_perio_id']);
        $id_valor= (empty($row['precobro_valor']) ? "0" : $row['precobro_valor']);//precobro_fechainiciomiembro


        $fecha_registro_cobros= (empty($row['precobro_fechainiciomiembro']) ? date('Y-m-d',strtotime($fechaRegistro)) : date('Y-m-d',strtotime($row['precobro_fechainiciomiembro'])));
        //para cuando desee actualizar y ya existan cobros en base a ese presupuesto
        $fechaXPagar= (empty($row['fecha_x_pagar']) ? "0" : date('Y-m-d',strtotime($row['fecha_x_pagar'])));
        if($fechaXPagar != "0"){
            if($fechaXPagar > $fecha_registro_cobros){
                $fecha_registro_cobros =$fechaXPagar;
            }
        }

        /////////////////////////////////////////////////////////////////// 
        $objMembresia= new Membresia();
        $lista= array();
        $lista= $objMembresia->getListaMembresias($row['membresia_id'],NULL);

        $objPerido= new Periodo();
        $listaPeriodos= array();
        $listaPeriodos= $objPerido->getListaPeriodos($row['periodo_perio_id'],NULL);


        $formModal['form_1'] = array("elemento" => "caja - oculta","id" => "_id_presupuesto" ,"reemplazo" => $id_presupuesto);
        $formModal['form_2'] = array("elemento" => "caja - oculta","id" => "_id_miembro_presupuesto" ,"reemplazo" => $idMiembro);   

        $formModal['form_3'] = array("elemento" => "caja" ,"tipo" => "text" , "titulo" => "Miembro", "id" => "_nombre_presupuesto" ,"reemplazo" => $nombre); 
        $formModal['form_4'] = array("elemento" => "caja" ,"tipo" => "date" , "titulo" => "Fecha de Registro", "id" => "_fecha_registro_miembro_presupuesto" ,"reemplazo" => $fecha_registro_cobros);  
        $formModal['form_5'] = array("elemento" => "combo","change" => "","titulo" => "Membresía", "id" => "_membresia_presupuesto", "option" => $lista);  
        $formModal['form_6'] = array("elemento" => "combo","change" => "","titulo" => "Período", "id" => "_periodo_presupuesto", "option" => $listaPeriodos);  

        $modal= generadorEtiquetaVVertical($formModal);
        return $modal;
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    try{
        switch ($_POST['KEY']): 
            case 'KEY_GUARDAR_PRESUPUESTO':   

                 if( !empty($_POST['_id_miembro']) && !empty($_POST['_id_periodo']) && !empty($_POST['_id_membresia']) && !empty($_POST['_fecha_registro'])  ){ 
                     if(date('Y',strtotime($_POST['_fecha_registro'])) > date("Y") || date('Y',strtotime($_POST['_fecha_registro'])) < date("Y")){
                        $data = array("success" => "false", "priority"=>'info',"msg" => "La fecha debe estar en el rango de este año!");
                        echo json_encode($data);
                        exit();
                    }
                    ////////////////////////////////////////////////////////////
                    $objPerido = new Periodo();
                    $periodoMeses= $objPerido->getPeriodoMes($_POST['_id_periodo']);
                    
                    $objMembresia = new Membresia();
                    $membresiaValor= $objMembresia->getMembresiaValor($_POST['_id_membresia']);
                       
                    ////////////////////////////////////////////////////////////
                    //Obtener las fechas del primer período
                    $multiplicadorPeriodo= 0;
                    $listaFechaLetrasPeriodos="";
                    $fechaPrimeraVuelta="";
                    
                    $multiplicadorLetrasFaltantes= 0;
                    $listaFechaLetrasFaltantes="";
                    
                    $fechaRegistroPresupuesto= date('Y-m-d',strtotime($_POST['_fecha_registro']));
                    $fechaPrimerDia_Registro= getPrimerDiaMes(date("Y"), date('m',strtotime($_POST['_fecha_registro'])));

                    for ($index = $periodoMeses; $index <= 12; $index = $index + $periodoMeses) {
                          
                            $fecha= getPrimerDiaMes(date("Y"),($index - $periodoMeses) + 1);
                            if($fecha >= $fechaPrimerDia_Registro){ //ojo, parte siempre y cuando sea mayor
                                if($fechaPrimeraVuelta == ""){
                                    $fechaPrimeraVuelta= $fecha;
                                }
                                $listaFechaLetrasPeriodos.= $fecha.",";
                                $multiplicadorPeriodo= $multiplicadorPeriodo + 1;
                            }
                    }
                    ////////////////////////////////////////////////////////////
                    //Obtener meses que falten de pagar, que no hayan caído en el período  
                    $numMes_DelRegistro= date("m", strtotime($fechaRegistroPresupuesto)); //2 febrero  1
                    $numMes_DelPrimeraVuelta= date("m", strtotime($fechaPrimeraVuelta)); //3 abril  
                    if($listaFechaLetrasPeriodos == ""){
                        $numMes_DelPrimeraVuelta= $numMes_DelPrimeraVuelta + 1;
                    }                      
                        
                    $numMesesFaltantes= $numMes_DelPrimeraVuelta - $numMes_DelRegistro;
                    if($numMesesFaltantes > 0){
                        for ($index = $numMes_DelRegistro; $index < $numMes_DelPrimeraVuelta; $index = $index + 1) {
                            $fecha= getPrimerDiaMes(date("Y"),$index); 
                            $listaFechaLetrasFaltantes.= $fecha.",";
                            $multiplicadorLetrasFaltantes= $multiplicadorLetrasFaltantes + 1;
                        }    
                    }
                    ////////////////////////////////////////////////////////////

                    $valorCobrarPeriodo= $membresiaValor * $periodoMeses;  
                    $valorCobrarLetrasFaltantes= $membresiaValor;
                    
                    $totalCobrar= ($valorCobrarPeriodo * $multiplicadorPeriodo) + ($valorCobrarLetrasFaltantes * $multiplicadorLetrasFaltantes);
                    $objTipoPresupuesto = new TipoPresupuesto();
                    $idTipo= $objTipoPresupuesto->getPrimerIDTipo();
                     if($_POST['_id_presupuesto'] != "0"){
                        $objPresupuestoCobro= new PresupuestoCobro();   
                        $comp= $objPresupuestoCobro->actualizarPresupuestoCobroMiembro($_POST['_id_presupuesto'], $valorCobrarPeriodo,
                                $totalCobrar,$_POST['_id_periodo'], $_SESSION['user_id_ben'],$listaFechaLetrasPeriodos, $_POST['_id_membresia'],
                                $_POST['_id_miembro'],$listaFechaLetrasFaltantes, $valorCobrarLetrasFaltantes,$idTipo); 
                        $msg='El Presupuesto se actualizo correctamente!';
                     }else{
                        
                        $objPresupuestoCobro= new PresupuestoCobro();
                        $comp= $objPresupuestoCobro->grabarPresupuestoCobroMiembro( $valorCobrarPeriodo, $fechaRegistroPresupuesto, $_POST['_id_miembro'],
                                $totalCobrar,$_POST['_id_periodo'], $_SESSION['user_id_ben'],$listaFechaLetrasPeriodos, $_POST['_id_membresia'],
                                 $listaFechaLetrasFaltantes, $valorCobrarLetrasFaltantes, $idTipo); 
                        $msg='El Presupuesto se creo correctamente!';
                     }
                     

                    if($comp == "OK"){
                        $data = array("success" => "true", "priority"=>'success',"msg" => $msg);
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
  
            case 'KEY_DETALLE_FILTRO_GRUPO':
                if(!empty($_POST['idGrupo']) ){         
                    echo getDetalleGruposConMiembros($_POST['idGrupo']);
                    exit();            
                }
                break;
            case 'KEY_DETALLE_PRESUPUESTO':
                if(!empty($_POST['id_presupuesto']) ){         
                    $cuerpo='';
                    $cont=1;
                    $objPresupuestoCobro= new PresupuestoCobro();
                    $resultset= $objPresupuestoCobro->getDetallePresupuestoMiembro($_POST['id_presupuesto']);
                    while ($row = $resultset->fetch_assoc()) {  
                       $fecha= date('d/m/Y',strtotime($row['detalleprecobro_fechavencimiento']));
                       $cuerpo.= generadorTablaColoresFilas("" ,
                               array(
                                   $cont,
                                   $row['detalleprecobro_valor'],
                                   $fecha,
                                   $row['detalleprecobro_estado']));
                        $cont=$cont + 1;
                     }
                    $tablaDetalle= generadorTablaDetalleEstadoCuenta(
                        array( 
                            generadorNegritas("N°"),
                            generadorNegritas("Valor"),
                            generadorNegritas("Fecha"),
                            generadorNegritas("Estado")), $cuerpo);  
                    echo $tablaDetalle;
                }
                break;
        endswitch;    
    } catch (Exception $exc) { echo getError($exc);}  
    
     exit(); 
}

if (in_array($perVerTodosFiltrosPresupuestoOp16, $_SESSION['usu_permiso'])) {

    
    $objGrupo= new Grupo();
    $listaGrupos= $objGrupo->getListaGrupos(NULL);
    $tabla_miembros= getDetalleGruposConMiembros($objGrupo->getPrimerGrupo()); 
    $t=getTablaFiltro($listaGrupos,$tabla_miembros );
    
 }  elseif (in_array($perVerFiltrosIDForumPresupuestoOp16, $_SESSION['usu_permiso'])) {
     
    $objForum = new ForumLeader();
    $idPrimerGrupo= $objForum->getIdPrimerGruposDePrivilegioForumLeader($_SESSION['user_id_ben']);
    $tabla_miembros= getDetalleGruposConMiembros($idPrimerGrupo);      
    
    $objGrupo= new Grupo();
    $listaGrupos= $objGrupo->getListaGruposForum($_SESSION['user_id_ben'], NULL, NULL); 
    $t=getTablaFiltro($listaGrupos,$tabla_miembros );
    
    
 } 

function getTablaFiltro($listaGrupos= array(),$tabla_miembros='') {
    $form['form_1'] = array("elemento" => "combo","change" => "getDetalleFiltroGrupo()","titulo" => "<h4>Grupos</h4>", "id" => "_grupo", "option" => $listaGrupos);  
    $resultado = str_replace("{contenedor_1}", generadorEtiquetasFiltro($form).'<div id="ben_contenedor_tabla">'.$tabla_miembros.'</div>',  getPage('page_detalle_update') );//generadorContMultipleRow($colum));      
    $resultado = str_replace("{boton}", "", $resultado);  
    $resultado = str_replace("{cabecera}", "Presupuesto", $resultado);   

    return $resultado;
}

$objPerido= new Periodo();
$listaPeriodos= $objPerido->getListaComboPeriodo("");

$objMembresia= new Membresia();
$listaMembresia= $objMembresia->getListaComboMembresia("");





