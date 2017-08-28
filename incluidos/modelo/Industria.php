<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Industria
 *
 * @author PRUEBAS
 */
class Industria extends Conexion{ 

    public function __construct(){
        parent:: __construct();        
    }
    public function getIndustrias($estado) {
        $sql="call sp_selectIndustrias('$estado')";
        return parent::getConsultar($sql);   
    }
    
            
    public function getIndustriasSeleccionadas($id) {
        $sql="SELECT  `industria_ind_id`, `prospecto_pro_id` FROM `prospectoindustria` WHERE prospecto_pro_id='$id'";
        return parent::getConsultar($sql);   
    } 
  
    
    function getListaIndustrias($idSeleccionado='') {
        $resultset_industria= $this->getIndustrias('A'); 
        $listaIndustria=array();
        if($idSeleccionado!=''){
            while ($row_industria = $resultset_industria->fetch_assoc()) { 
                if($row_industria['ind_id']==$idSeleccionado){
                    $listaIndustria['lista_'.$row_industria['ind_id']] = array("value" => $row_industria['ind_id'],  "select" => "selected" ,"texto" => $row_industria['ind_descripcion']);
                }else{
                    $listaIndustria['lista_'.$row_industria['ind_id']] = array("value" => $row_industria['ind_id'],  "select" => "" ,"texto" => $row_industria['ind_descripcion']); 
                }
            }
        }  else {
           while ($row_industria = $resultset_industria->fetch_assoc()) { 
                 $listaIndustria['lista_'.$row_industria['ind_id']] = array("value" => $row_industria['ind_id'],  "select" => "" ,"texto" => $row_industria['ind_descripcion']);
            }
       }
       return $listaIndustria;
    }
    
    function setCreateUpdateIndustria($ind_id, $ind_descripcion, $key) {
        $sql = "call sp_createUpdateIndustria('$ind_id','$ind_descripcion', '$key')";
        return parent::setSqlSp($sql);
    }
    
     function getListaIndustrias2($idSeleccionado='',$listaIndustria= array()) {
        $resultset_industria= $this->getIndustrias('A'); 
        if($idSeleccionado!=''){
            while ($row_industria = $resultset_industria->fetch_assoc()) { 
                if($row_industria['ind_id']==$idSeleccionado){
                    $listaIndustria['lista_'.$row_industria['ind_id']] = array("value" => $row_industria['ind_id'],  "select" => "selected" ,"texto" => $row_industria['ind_descripcion']);
                }else{
                    $listaIndustria['lista_'.$row_industria['ind_id']] = array("value" => $row_industria['ind_id'],  "select" => "" ,"texto" => $row_industria['ind_descripcion']); 
                }
            }
        }  else {
           while ($row_industria = $resultset_industria->fetch_assoc()) { 
                 $listaIndustria['lista_'.$row_industria['ind_id']] = array("value" => $row_industria['ind_id'],  "select" => "" ,"texto" => $row_industria['ind_descripcion']);
            }
       }
       return $listaIndustria;

    }
    function getMultiListaIndustria($idProspecto) {
        $resultset_industria_selecionadas= $this->getIndustriasSeleccionadas($idProspecto); 
        $lista_ind_selecionadas=array();
        while ($row_industria_selecionada = $resultset_industria_selecionadas->fetch_assoc()) { 
            $lista_ind_selecionadas[$row_industria_selecionada['industria_ind_id']]=$row_industria_selecionada['industria_ind_id'];        
       
         }
      
        $resultset_industria= $this->getIndustrias('A'); 
        $listaIndustria=array();
        $bandera=FALSE;
        while ($row_industria = $resultset_industria->fetch_assoc()) {      
            foreach ($lista_ind_selecionadas as $val){
                if($row_industria['ind_id']==$val){
                            $bandera=TRUE;
                 }
            }

            if($bandera){
                $listaIndustria['lista_'.$row_industria['ind_id']] = array("value" => $row_industria['ind_id'],  "select" => "selected" ,"texto" => $row_industria['ind_descripcion']);
            }  else {
                $listaIndustria['lista_'.$row_industria['ind_id']] = array("value" => $row_industria['ind_id'],  "select" => "" ,"texto" => $row_industria['ind_descripcion']);
            }
            $bandera=FALSE;
        }
        return $listaIndustria;
        
    }
    
    public function setGrabar($industria, $user, $seccion) {
        $fecha= date("Y-m-d H:i:s");
        $sql="call sp_createIndustria('$industria', '$fecha','$user','$seccion')";
        return parent::setSqlSp($sql);   
    }
    public function get($id_industria) {
        $sql="call sp_selectIndustria('$id_industria')";
        return parent::getConsultar($sql);   
    }
    public function setActualizar($id, $industria,$estado, $user, $seccion) {
        $sql="call sp_updateIndustria('$id','$industria', '$estado','$user','$seccion')";
        return parent::setSqlSp($sql);   
    }
    
     public function getIndustriasWithSeccion($estado) {
        $sql="call sp_selectIndustriasWithSeccion('$estado')";
        return parent::getConsultar($sql);   
    }
//    sp_updateIndustria(IN _id  INT, IN _industria VARCHAR(200), IN _estado VARCHAR(10), IN _id_user INT)  BEGIN
   
}
