<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TipoTarea
 *
 * @author Benito
 */
class TipoTarea extends Conexion{ 

    public function __construct(){
        parent:: __construct();        
    }
    public function getTipoTarea() {
        $sql="call sp_selectTipoGestion()";
        return parent::getConsultar($sql);   
    } 
    
    public function getListaTipoTarea($idTarea='') {   
        $resultset_tipo_tarea= $this->getTipoTarea(); 
        $lista_tipo_tarea=array();
        if($idTarea!=''){
            while ($row_tipo_tarea = $resultset_tipo_tarea->fetch_assoc()) { 
                if($idTarea==$row_tipo_tarea['tipges_id']){
                   $lista_tipo_tarea['lista_'.$row_tipo_tarea['tipges_id']] = array("value" => $row_tipo_tarea['tipges_id'],  "select" => "Selected" ,"texto" => $row_tipo_tarea['tipges_descripcion']);
                }else{
                   $lista_tipo_tarea['lista_'.$row_tipo_tarea['tipges_id']] = array("value" => $row_tipo_tarea['tipges_id'],  "select" => "" ,"texto" => $row_tipo_tarea['tipges_descripcion']);
                }
            }
        }  else {
            while ($row_tipo_tarea = $resultset_tipo_tarea->fetch_assoc()) { 
                $lista_tipo_tarea['lista_'.$row_tipo_tarea['tipges_id']] = array("value" => $row_tipo_tarea['tipges_id'],  "select" => "" ,"texto" => $row_tipo_tarea['tipges_descripcion']);
            }
       }
        return $lista_tipo_tarea;
    }
}