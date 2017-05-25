<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Porcentaje
 *
 * @author Benito
 */
class Porcentaje extends Conexion{ 
    
    public function __construct(){
        parent:: __construct();       
    }

    
     public function get() {
        $sql="call sp_selectPorcentaje()";
        return parent::getConsultar($sql);   
    }
     public function getLista($idSeleccionado='', $lista=array()) {   
        $resultset= $this->get();
        
      
        if($idSeleccionado!=''){
            while($row = $resultset->fetch_assoc()) { 
                if($row['porc_id'] == $idSeleccionado){
                      $lista['lista_'.$row['porc_id']] = array( "value" => $row['porc_id'],  "select" => "selected" ,"texto" => $row['porc_valor']." %");
                }else{
                     $lista['lista_'.$row['porc_id']] = array( "value" => $row['porc_id'],  "select" => "" ,"texto" => $row['porc_valor']." %");

                }
            }
        }  else {
            while($row = $resultset->fetch_assoc()) { 
                $lista['lista_'.$row['porc_id']] = array( "value" => $row['porc_id'],  "select" => "" ,"texto" => $row['porc_valor']." %");
            }
       }
        return $lista;
    }
    public function setCrearPorcentajeModal($porcentaje, $user) {
        $fecha= date("Y-m-d H:i:s");
        $sql="call sp_createPorcentajeModal('$porcentaje', '$fecha', '$user')";
        
        $resultset= parent::getConsultar($sql);
        $idMaximo="0";
        if($row = $resultset->fetch_assoc()) { 
            $idMaximo=$row['porc_id'];
        }
            
        return $idMaximo;   
    }
}
