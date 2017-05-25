<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Profesion
 *
 * @author PRUEBAS
 */
class Profesion extends Conexion{ 

    public function __construct(){
        parent:: __construct();        
    }
    public function getProfesiones() {
        $sql="call sp_selectProfesion()";
        return parent::getConsultar($sql);   
    }
    
      public function getListaprofesion($idSeleccionado='') {   
        $resultset_profe= $this->getProfesiones(); 
        $listaprofe=array();
        if($idSeleccionado!=''){
            while ($row_profe = $resultset_profe->fetch_assoc()) { 
                 if($row_profe['prof_id']==$idSeleccionado){
                     $listaprofe['lista_'.$row_profe['prof_id']] = array("value" => $row_profe['prof_id'],  "select" => "selected" ,"texto" => $row_profe['prof_descripcion']);
                 }else{
                     $listaprofe['lista_'.$row_profe['prof_id']] = array("value" => $row_profe['prof_id'],  "select" => "" ,"texto" => $row_profe['prof_descripcion']); 
                 }
             }
        }else{
           while ($row_profe = $resultset_profe->fetch_assoc()) { 
             $listaprofe['lista_'.$row_profe['prof_id']] = array("value" => $row_profe['prof_id'],  "select" => "" ,"texto" => $row_profe['prof_descripcion']);
           }
       }
       return $listaprofe;
    }
    
    


    
   
}
