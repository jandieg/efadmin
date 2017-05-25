<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Fuente
 *
 * @author PRUEBAS
 */
class Fuente extends Conexion{ 

    public function __construct(){
        parent:: __construct();        
    }
    public function getFuentes($estado) {
        $sql="call sp_selectFuentes('$estado')";
        return parent::getConsultar($sql);   
    }
    
    public function getListaFuentes($idSeleccionado='') {   
        $resultset_fuente= $this->getFuentes('A'); 
        $listafuente=array();
        if($idSeleccionado!=''){
               while ($row_fuente = $resultset_fuente->fetch_assoc()) { 
                    if($idSeleccionado==$row_fuente['fue_id']){ 
                        $listafuente['lista_'.$row_fuente['fue_id']] = array("value" => $row_fuente['fue_id'],  "select" => "selected" ,"texto" => $row_fuente['fue_descripcion']);
                    }  else {
                        $listafuente['lista_'.$row_fuente['fue_id']] = array("value" => $row_fuente['fue_id'],  "select" => "" ,"texto" => $row_fuente['fue_descripcion']);

                    }
                }
        }  else {
            while ($row_fuente = $resultset_fuente->fetch_assoc()) { 
                $listafuente['lista_'.$row_fuente['fue_id']] = array("value" => $row_fuente['fue_id'],  "select" => "" ,"texto" => $row_fuente['fue_descripcion']);
            }
       }
        return $listafuente;
    }
    
    



    
   
}
