<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EstadoPresupuesto
 *
 * @author PRUEBAS
 */
class EstadoPresupuesto extends Conexion{ 

   
    private $primerEstado= '';
    public function __construct(){
        parent:: __construct();        
    }
    
    public function getPrimerIDEstado() {
        $resultset= $this->getEstadoPresupuesto(); 
        if ($row = $resultset->fetch_assoc()) { 
           $this->primerEstado=$row['est_pre_id'];
        }
        return $this->primerEstado;
    }

    public function getEstadoPresupuesto() {
        $sql="call sp_selectEstadoPresupuestoPrimero()";
        return parent::getConsultar($sql);   
    }
    public function getEstadoPresupuestos() {
        $sql="call sp_selectEstadopresupuestos()";
        return parent::getConsultar($sql);   
    }

    public function getListaEstadoPresupuestos($id='', $lista_=array()) {   
        $resultset= $this->getEstadoPresupuestos(); 
        $lista=$lista_;
        if($id!=''){
            while ($row = $resultset->fetch_assoc()) { 
                if($id==$row['est_pre_id']){
                   $lista['lista_'.$row['est_pre_id']] = array("value" => $row['est_pre_id'],  "select" => "Selected" ,"texto" => $row['est_pre_descripcion']);
                }else{
                   $lista['lista_'.$row['est_pre_id']] = array("value" => $row['est_pre_id'],  "select" => "" ,"texto" => $row['est_pre_descripcion']);
                }
            }
        }  else {
            while ($row = $resultset->fetch_assoc()) { 
                $lista['lista_'.$row['est_pre_id']] = array("value" => $row['est_pre_id'],  "select" => "" ,"texto" => $row['est_pre_descripcion']);
            }
       }
        return $lista;
    }
    public function get($id) {
        $sql="call sp_selectEstadoPresupuesto('$id')";
        return parent::getConsultar($sql);   
    }
    //sp_updateEstadoPresupuesto(IN _id INT ,IN _descripcion TEXT,  IN _usuario INT)
    public function setActualizar($id, $descripcion, $user) {
        $sql="call sp_updateEstadoPresupuesto('$id','$descripcion','$user')";
        return parent::setSqlSp($sql);   
    }

}
