<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PrioridadTarea
 *
 * @author PRUEBAS
 */
class PrioridadTarea extends Conexion{ 

    public function __construct(){
        parent:: __construct();        
    }
    public function getPrioridadTarea() {
        $sql="call sp_selectPrioridad()";
        return parent::getConsultar($sql);   
    }  
    
    //Listas
    function getListaPrioridadTarea($idPrioridadTarea='') {   
        $prioridad= new PrioridadTarea();
        $resultset_prioridad= $this->getPrioridadTarea(); 
        $listat_prioridad=array();
        if($idPrioridadTarea!=''){
            while ($row_prioridad= $resultset_prioridad->fetch_assoc()) { 
                if($idPrioridadTarea==$row_prioridad['prio_id']){
                    $listat_prioridad['lista_'.$row_prioridad['prio_id']] = array("value" => $row_prioridad['prio_id'],  "select" => "Selected" ,"texto" => $row_prioridad['prio_descripcion']);
                }  else {
                    $listat_prioridad['lista_'.$row_prioridad['prio_id']] = array("value" => $row_prioridad['prio_id'],  "select" => "" ,"texto" => $row_prioridad['prio_descripcion']);
                }
          }
        }  else {
            while ($row_prioridad= $resultset_prioridad->fetch_assoc()) { 
                $listat_prioridad['lista_'.$row_prioridad['prio_id']] = array("value" => $row_prioridad['prio_id'],  "select" => "" ,"texto" => $row_prioridad['prio_descripcion']);
           }
        }
        return $listat_prioridad;
    }

}
