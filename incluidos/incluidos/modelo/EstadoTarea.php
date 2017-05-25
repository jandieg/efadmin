<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EstadoTarea
 *
 * @author PRUEBAS
 */
class EstadoTarea extends Conexion{ 

    public function __construct(){
        parent:: __construct();        
    }
    public function getEstadosTarea() {
        $sql="call sp_selectEstadoTarea()";
        return parent::getConsultar($sql);   
    }
    //Listas
    public function getListaEstadoTarea($estadoTarea='') {   
        $resultset_tarea= $this->getEstadosTarea(); 
        $listat_tarea=array();
        if($estadoTarea!=''){
            while ($row_tarea = $resultset_tarea->fetch_assoc()) { 
                if($estadoTarea==$row_tarea['est_tar_id']){
                    $listat_tarea['lista_'.$row_tarea['est_tar_id']] = array("value" => $row_tarea['est_tar_id'],  "select" => "Selected" ,"texto" => $row_tarea['est_tar_descripcion']);   
                }  else {
                    $listat_tarea['lista_'.$row_tarea['est_tar_id']] = array("value" => $row_tarea['est_tar_id'],  "select" => "" ,"texto" => $row_tarea['est_tar_descripcion']);
                }
           }
        }  else {
            while ($row_tarea = $resultset_tarea->fetch_assoc()) { 
                $listat_tarea['lista_'.$row_tarea['est_tar_id']] = array("value" => $row_tarea['est_tar_id'],  "select" => "" ,"texto" => $row_tarea['est_tar_descripcion']);
           }
        }
        return $listat_tarea;
    }
}
