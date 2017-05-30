<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Periodo
 *
 * @author PRUEBAS
 */
class Periodo extends Conexion{ 

    public function __construct(){
        parent:: __construct();        
    }
    public function getPeriodos() {
        $sql="call sp_selectPeriodos()";
        return parent::getConsultar($sql);   
    }
    
    public function getPeriodo($id) {
        $sql="call sp_selectPeriodo('$id')";
        return parent::getConsultar($sql);   
    }
     //SELECT `perio_id`, `perio_descripcion`, `perio_meses`, `perio_estado`, `perio_fecharegistro`, `perio_fechamodificacion`, `perio_id_usuario` FROM `periodo` WHERE perio_id =_id;
    function getPeriodoMes($id) {
        $resultset= $this->getPeriodo($id); 
        $meses='';
        if ($row = $resultset->fetch_assoc()) { 
           $meses= $row['perio_meses'];
        }
        return $meses;
    }
    
    function getListaComboPeriodo($idSeleccionado="") {
        $resultset= $this->getPeriodos(); 
        $lista='';
        while ($row = $resultset->fetch_assoc()) {
           
           if($idSeleccionado==$row['perio_id']){
               $lista.='<option value="'.$row['perio_id'].'" selected>'.$row['perio_descripcion'].'</option>';
           }  else {
               $lista.='<option value="'.$row['perio_id'].'">'.$row['perio_descripcion'].'</option>';

           }
        }
        return $lista;
    }
    
     public function getListaPeriodos($id='', $lista_=array()) {   
        $resultset= $this->getPeriodos(); 
        $lista=$lista_;
        if($id!=''){
            while ($row = $resultset->fetch_assoc()) { 
                if($id==$row['perio_id']){
                   $lista['lista_'.$row['perio_id']] = array("value" => $row['perio_id'],  "select" => "Selected" ,"texto" => $row['perio_descripcion']);
                }else{
                   $lista['lista_'.$row['perio_id']] = array("value" => $row['perio_id'],  "select" => "" ,"texto" => $row['perio_descripcion']);
                }
            }
        }  else {
            while ($row = $resultset->fetch_assoc()) { 
                $lista['lista_'.$row['perio_id']] = array("value" => $row['perio_id'],  "select" => "" ,"texto" => $row['perio_descripcion']);
            }
       }
        return $lista;
    }
}
