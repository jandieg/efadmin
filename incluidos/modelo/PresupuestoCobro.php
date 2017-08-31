<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PresupuestoCobro
 *
 * @author Benito
 */
class PresupuestoCobro extends Conexion{ 

    public function __construct(){
        parent:: __construct();       
    }
 
    public function getPresupuestoCobroMiembrosxGrupos($idGrupo, $year) {
        $sql="CALL sp_selectPresupuestoCobroMiembrosxGrupos2('$idGrupo', '$year')";
        return parent::getConsultar($sql);   
    }
    public function grabarPresupuestoCobroMiembro($valor, $fechaInicioMiembro,$idMiembro,$totalCobro,$idPeriodo,$id_user,$listaFechas,$idMembresia,$listaFechasFaltantes,$valorFechasFaltantes,$idTipo, $cancelled, $fechaCambio, $anho) {
        $fecha= date("Y-m-d H:i:s");
        $year= $anho; //date("Y");
        $sql="CALL sp_createPresupuestoCobroMiembro('$valor','$fechaInicioMiembro','$idMiembro','$totalCobro','$idPeriodo','$fecha','$id_user','$listaFechas', '$year', '$idMembresia','$listaFechasFaltantes', '$valorFechasFaltantes','$idTipo', '$cancelled', '$fechaCambio')";
        return parent::setSqlSp($sql);   
    }
    public function actualizarPresupuestoCobroMiembro($idPresupuesto,$valor, $totalCobro,$idPeriodo,$id_user,$listaFechas,$idMembresia,$idMiembro,$listaFechasFaltantes,$valorFechasFaltantes,$idTipo,$cancelled, $fechaCambio, $anho) {
        $fecha= date("Y-m-d H:i:s");
        $year= $anho; //;
        $sql="CALL sp_updatePresupuestoCobroMiembro('$idPresupuesto','$valor','$totalCobro','$idPeriodo','$id_user','$listaFechas','$idMembresia', '$idMiembro','$listaFechasFaltantes','$valorFechasFaltantes','$idTipo','$year', '$cancelled', '$fechaCambio')";
        return parent::setSqlSp($sql);   
    }

    public function cancelarPresupuestoCobroMiembro($idMiembro, $mes, $anho) {
        $mes2 = str_pad($mes,2,"0",STR_PAD_LEFT );
        $fecha = $anho."-".$mes2."-01"; 
        $fecha2= strtotime($fecha);
        $penultima = date('Y-m-d', strtotime("-2 day", $fecha2)) . " 00:00:00";        
        $sql = "CALL sp_cancelPresupuestoCobroMiembro('$idMiembro', '$mes', '$anho', '$penultima')";
        return parent::setSqlSp($sql);
    }       

    public function getPendientesByPrecobro($idPrecobro) {
        $sql = "call sp_selectPendientesByPrecobro('$idPrecobro')";
        return parent::getConsultar($sql);
    }

    public function getCreditoPresupuestoMiembro($id) {
        $sql="CALL sp_selectCreditoPresupuestoMiembro('$id')";
        return parent::getConsultar($sql);
    }

    public function actualizarCreditoPresupuestoMiembro($id, $monto, $bandera) {
        $sql = "CALL sp_updateCreditoPresupuestoMiembro('$id','$monto','$bandera')";
        return parent::setSqlSp($sql);
    }

    public function getCreditoMiembro($id) {
        $resultset = $this->getCreditoPresupuestoMiembro($id);
        while ($row = $resultset->fetch_assoc()) {
            return $row['precobro_credito'];
        }
    }

    public function getPresupuestoMiembro($id) {
        $sql="CALL sp_selectPresupuestoMiembro('$id')";
        return parent::getConsultar($sql);
    }

    public function getPresupuestoByIdMiembro($id_miembro) {
        $sql="CALL sp_selectPresupuestoByIdMiembro('$id_miembro')";
        return parent::getConsultar($sql);
    }

    public function getDetallePresupuestoMiembro($id) {
        $sql="CALL sp_selectDetallePresupuestoMiembro('$id')";
        return parent::getConsultar($sql);   
    }

    public function getDetallePresupuestoMiembroByAnho($id_miembro, $anho) {
        $sql="CALL sp_selectDetallePresupuestoMiembroByAnho('$id_miembro', '$anho')";
        return parent::getConsultar($sql);   
    }

    public function getPresupuestoCobroMiembrosxEmpresas($id, $year) {
        $sql="CALL sp_selectPresupuestoCobroMiembrosxEmpresa('$id', '$year')";
        return parent::getConsultar($sql);   
    }
     public function getPresupuestoCobroMiembrosxMiembros($id, $year) {
        $sql="CALL sp_selectPresupuestoCobroMiembrosxMiembros('$id', '$year')";
        return parent::getConsultar($sql);   
    }
     public function getPresupuestoCobroMiembrosFiltroGrupo($id, $year) {
        $sql="CALL sp_selectPresupuestoCobroMiembrosFiltroxGrupo('$id', '$year')";
        return parent::getConsultar($sql);   
    }

    public function getCuotasEnCero($id) {
        $sql = "CALL sp_selectCuotasEnCero('$id')";
        return parent::getConsultar($sql);
    }

    public function getFechasConCuotasEnCero($id) {
        $resultset = $this->getCuotasEnCero($id);
        $lista = array();

        while ($row = $resultset->fetch_assoc()) {
            $lista[] = date('Y-m-d',strtotime($row['detalleprecobro_fechavencimiento']));
        }
        return $lista;
    }

    public function getCuotasPagas($id) {
        $sql = "CALL sp_selectCuotasPagas('$id')";
        return parent::getConsultar($sql);
    }

    public function getFechasConCuotasPagas($id) {
        $resultset = $this->getCuotasPagas($id);
        $lista = array();

        while ($row = $resultset->fetch_assoc()) {
            $lista[] = date('Y-m-d',strtotime($row['detalleprecobro_fechavencimiento']));
        }
        return $lista;
    }
    
    public function getListaDetallePresupuesto($id) {   
        $resultset= $this->getDetallePresupuestoMiembro($id); 
        $lista=array();
       
        while ($row = $resultset->fetch_assoc()) { 
            $fecha= date('Y-m-d',strtotime($row['detalleprecobro_fechavencimiento']));
            if($row['detalleprecobro_is_inscripcion'] == "1" ){
               $fecha= date('Y-m-d',strtotime($row['detalleprecobro_fechavencimiento'])) . " - INSCRIPCIÓN"; 
            }
            $lista['lista_'.$row['detalleprecobro_id']] = array("value" => $row['detalleprecobro_id'],  "select" => "" ,"texto" =>$fecha);

        }

        return $lista;
    }
    
    
    public function getPresupuestoCobroMiembro($id) {
        $sql="CALL sp_selectPresupuestoCobroMiembros('$id')";
        return parent::getConsultar($sql);   
    }
    
    
    
}
