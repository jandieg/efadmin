<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GeneradorID
 *
 * @author PRUEBAS
 */
class GeneradorID extends Conexion{ 
  
    public function __construct(){
        parent:: __construct();       
    }
    
    public function setGenerar() {
        $sql="CALL `sp_selectGenerarID`()";
        return parent::getConsultar($sql);   
    }
    
   public function getGenerar() {
        $idGenerado='';
         $resultset= $this->setGenerar();
         if($row = $resultset->fetch_assoc()) { 
            $idGenerado= $row['generador_id'];                                                                    
         } 
         return $idGenerado;
    }
    

}