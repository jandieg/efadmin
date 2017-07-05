<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EstadoProspecto
 *
 * @author PRUEBAS
 */
class EstadoProspecto extends Conexion{ 

    public function __construct(){
        parent:: __construct();        
    }
    public function getEstadosProspecto($estado) {
        $sql="call sp_selectEstadosProspectos('$estado')";
        return parent::getConsultar($sql);   
    }  

    public function getEstadosAplicante($estado) {
        $sql="call sp_selectEstadosAplicantes('$estado')";
        return parent::getConsultar($sql);   
    }  
    public function getListaEstadoProspecto($idSeleccionado='', $listaestadoprospecto= array()) {   
        $resultset_estadoprospecto= $this->getEstadosProspecto('A'); 
//        $listaestadoprospecto=array();
        if($idSeleccionado!=''){
                while ($row_estadoprospecto = $resultset_estadoprospecto->fetch_assoc()) {
                    if($idSeleccionado==$row_estadoprospecto['estpro_id']){
                        $listaestadoprospecto['lista_'.$row_estadoprospecto['estpro_id']] = array("value" => $row_estadoprospecto['estpro_id'],  "select" => "selected" ,"texto" => $row_estadoprospecto['estpro_descripcion']);
                    }  else {
                        $listaestadoprospecto['lista_'.$row_estadoprospecto['estpro_id']] = array("value" => $row_estadoprospecto['estpro_id'],  "select" => "" ,"texto" => $row_estadoprospecto['estpro_descripcion']);

                    }

                }
        }  else {
            while ($row_estadoprospecto = $resultset_estadoprospecto->fetch_assoc()) { 
                $listaestadoprospecto['lista_'.$row_estadoprospecto['estpro_id']] = array("value" => $row_estadoprospecto['estpro_id'],  "select" => "" ,"texto" => $row_estadoprospecto['estpro_descripcion']);
           }
          }
        return $listaestadoprospecto;
    }
    public function setGrabar($descripcion, $user) {
        $fecha= date("Y-m-d H:i:s");
        $sql="call sp_createEstadoProspecto('$descripcion', '$user','$fecha')";
        return parent::setSqlSp($sql);   
    }
    public function get($id) {
        $sql="call sp_selectEstadoProspecto('$id')";
        return parent::getConsultar($sql);   
    }
    public function setActualizar($id, $descripcion, $user, $estado) {
        $sql="call sp_updateEstadoProspecto('$id','$descripcion','$user', '$estado')";
        return parent::setSqlSp($sql);   
    }
    //sp_updateEstadoProspecto(IN _id INT ,IN _descripcion TEXT,  IN _usuario INT,  IN _estado VARCHAR(10))
}

