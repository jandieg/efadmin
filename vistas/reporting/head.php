<?php
require_once MODELO.'Reporte.php';
require_once MODELO.'Grupo.php';
require_once MODELO.'PresupuestoCobro.php';
require_once MODELO.'ForumLeader.php';
require_once MODELO.'Periodo.php';
require_once MODELO.'Membresia.php';
require_once MODELO.'TipoPresupuesto.php';
require_once MODELO.'Miembro.php';
require_once MODELO.'EstadoPresupuesto.php';
include(HTML."/html.php");
include(HTML."/html_filtros.php");
include(HTML."/html_2.php");
include(HTML."/html_combos.php");
$objPresupuestoCobro;
$objGrupo;
$objTipoPresupuesto;
include(LENGUAJE."/lenguaje_1.php");
function getDetalleGruposConMiembros($idGrupo, $estado, $año) {
        $cont=1;
        $cuerpo='';
        
        $objR= new Reporte();
        $objR->setEstablecerfehas($año);
        if($estado == '2'){
            $resultset= $objR->get($idGrupo);
        }else{
            $resultset= $objR->getPendientes($idGrupo);
        }
        while($row = $resultset->fetch_assoc()) { 
            if($row['Código'] != "zzz"){
               $cuerpo.= generadorTablaFilas(array(
                   $row['Código'],
                   $row['nombre'],
                   (($row['EF Paid'] == "") ? "" : date('m-Y',strtotime($row['EF Paid']))),
                 (($row['1st FM'] == "") ? "" : date('m-Y',strtotime($row['1st FM']))),
                   (empty($row['Dues Mo']) ? "" : "$ ".$row['Dues Mo']),
                   (empty($row['YTD']) ? "" : "$ ".$row['YTD']))); 
               $cont=$cont + 1;   
            }
             
         }   
        $objGrupo= new Grupo();
        $tabla_miembros= generadorTablaModal(1,"","", array( "Código", "Nombre",'EF Paid','1st FM','Dues Mo','YTD'), $cuerpo);      
        return $tabla_miembros;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    try{
        switch ($_POST['KEY']): 
            case 'KEY_DETALLE_FILTRO_GRUPO':
                if(!empty($_POST['idGrupo']) ){         
                    echo getDetalleGruposConMiembros($_POST['idGrupo'],$_POST['_estado_presupuesto'],$_POST['_año']);
                    exit();            
                }
                break;
        endswitch;    
    } catch (Exception $exc) { echo getError($exc);}  
    
     exit(); 
}

if (in_array($perVerTodosFiltrosReportesCobroOp15, $_SESSION['usu_permiso'])) {
    
    
    $objGrupo= new Grupo();
    $listaGrupos= $objGrupo->getListaGruposForum_by_Sede($_SESSION['sede_id'], NULL, NULL); 
    $tabla_miembros= getDetalleGruposConMiembros($objGrupo->getPrimerGrupo(),'2',date('Y')); 
    $t=getTablaFiltro($listaGrupos,$tabla_miembros );
    
 }  elseif (in_array($perVerFiltrosIDForumReportesCobroOp15, $_SESSION['usu_permiso'])) {
     
    $objForum = new ForumLeader();
    $idPrimerGrupo= $objForum->getIdPrimerGruposDePrivilegioForumLeader($_SESSION['user_id_ben']);
    $tabla_miembros= getDetalleGruposConMiembros($idPrimerGrupo, '2', date('Y'));      
    
    $objGrupo= new Grupo();
    $listaGrupos= $objGrupo->getListaGruposForum_by_Sede($_SESSION['sede_id'], NULL, NULL); 
    $t=getTablaFiltro($listaGrupos,$tabla_miembros );
}

function getTablaFiltro($listaGrupos= array(),$tabla_miembros='') {


   // $form2['form_2'] = array("elemento" => "combo","change" => "ResetReports('1')" ,"titulo" => "<h4>Grupo</h4>", "id" => "_grupo", "option" => $listaGrupos); 
    $form2['form_1'] = array("elemento" => "combo","disabled" => "","change" => "ResetReports('1')","titulo" => "<h4>Año</h4>", "id" => "_año", "option" => generadorComboAños(date('Y')));
    $form4['form_1'] = array("elemento" => "caja" ,"disabled" => "","tipo" => "date" , "titulo" => "", "id" => "_fecha_corte" ,"reemplazo" => date('Y-m-d', strtotime(date('Y-m-01'). ' -1 days')));  
    
    
    $resultado = str_replace("{contenedor_3}", '<div id="ben_contenedor_tabla">
							 <style>
h3{
        text-align: center;
    }
	</style>
<div class="row" style=margin-left:0.5%; id="report1">
  <div class="col-6 col-md-6" id="fullReport"><a class="btn btn-info" onClick=do_report("fullReport","'.$_SESSION['user_id_ben'].'"); style="cursor:pointer;">  
GENERAR REPORTE COMPLETO
</a> </div>
    <div class="col-6 col-md-6" ><a class="btn btn-info" onClick=do_report("ActivityReport","'.$_SESSION['user_id_ben'].'"); style="cursor:pointer;" id="ActivityReport">  
GENERAR REPORTE DE ACTIVIDAD</a></div>
</div>




',  getPage('page_detalle_update') );
    $resultado = str_replace("{contenedor_2}", generadorEtiquetasFiltro($form3),  $resultado);
    $resultado = str_replace("{contenedor_1}", generadorEtiquetasFiltro($form2),  $resultado );
    $resultado = str_replace("{contenedor_4}", generadorEtiquetasFiltro($form1),  $resultado );
    $resultado = str_replace("{contenedor_5}", generadorEtiquetasFiltro($form4),  $resultado );
    
    $resultado = str_replace("{boton}", generadorBoton($boton), $resultado);  
    $resultado = str_replace("{cabecera}", "Reportes", $resultado);   
	
	
	

    return $resultado;
}


/*

        
 echo getUltimoDiaMes(date('2017'),'1'). '</br>';
       echo getUltimoDiaMes(date('2017'),'2'). '</br>';

        
        
      echo getPrimerDiaMes(date('2017'),'1'). '</br>';
      echo getPrimerDiaMes(date('2017'),'2'). '</br>';


*/