<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Seccion
 *
 * @author PRUEBAS
 */
class SeccionIndustria extends Conexion{ 

    public function __construct(){
        parent:: __construct();        
    }
    public function gets($estado) {
        $sql="call sp_selectSeccionIndustria('$estado')";
        return parent::getConsultar($sql);   
    }
    
    
    function getListas($idSeleccionado='',$lista= array()) {
        $resultset= $this->gets('A'); 
        if($idSeleccionado!=''){
            while ($row = $resultset->fetch_assoc()) { 
                if($row['sec_ind_id']==$idSeleccionado){
                    $lista['lista_'.$row['sec_ind_id']] = array("value" => $row['sec_ind_id'],  "select" => "selected" ,"texto" => $row['sec_ind_titulo'] ." - ".$row['sec_ind_subtitulo']);
                }else{
                    $lista['lista_'.$row['sec_ind_id']] = array("value" => $row['sec_ind_id'],  "select" => "" ,"texto" => $row['sec_ind_titulo'] ." - ".$row['sec_ind_subtitulo']); 
                }
            }
        }  else {
           while ($row = $resultset->fetch_assoc()) { 
                 $lista['lista_'.$row['sec_ind_id']] = array("value" => $row['sec_ind_id'],  "select" => "" ,"texto" => $row['sec_ind_titulo'] ." - ".$row['sec_ind_subtitulo']);
            }
       }
       return $lista;
    }
}
