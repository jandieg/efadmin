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
    public function grabarPresupuestoCobroMiembro($valor, $fechaInicioMiembro,$idMiembro,$totalCobro,$idPeriodo,$id_user,$listaFechas,$idMembresia,$listaFechasFaltantes,$valorFechasFaltantes,$idTipo) {
        $fecha= date("Y-m-d H:i:s");
        $year= date("Y");
        $sql="CALL sp_createPresupuestoCobroMiembro('$valor','$fechaInicioMiembro','$idMiembro','$totalCobro','$idPeriodo','$fecha','$id_user','$listaFechas', '$year', '$idMembresia','$listaFechasFaltantes', '$valorFechasFaltantes','$idTipo')";
        return parent::setSqlSp($sql);   
    }
    public function actualizarPresupuestoCobroMiembro($idPresupuesto,$valor, $totalCobro,$idPeriodo,$id_user,$listaFechas,$idMembresia,$idMiembro,$listaFechasFaltantes,$valorFechasFaltantes,$idTipo) {
        $fecha= date("Y-m-d H:i:s");
        $year= date("Y");
        $sql="CALL sp_updatePresupuestoCobroMiembro('$idPresupuesto','$valor','$totalCobro','$idPeriodo','$id_user','$listaFechas','$idMembresia', '$idMiembro','$listaFechasFaltantes','$valorFechasFaltantes','$idTipo','$year')";
        return parent::setSqlSp($sql);   
    }
               
            
    public function getDetallePresupuestoMiembro($id) {
        $sql="CALL sp_selectDetallePresupuestoMiembro('$id')";
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
