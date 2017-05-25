<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Desafio
 *
 * @author PRUEBAS
 */
class Desafio extends Conexion{ 

    public function __construct(){
        parent:: __construct();        
    }
    public function getDesafio() {
        $sql="call sp_selectDesafios()";
        return parent::getConsultar($sql);   
    }  
   
    public function getDesafioSeleccionado($id) {
        $sql="SELECT  `desafio_des_id` FROM `prospecto_desafio` WHERE prospecto_pro_id='$id'";
        return parent::getConsultar($sql);   
    }
   
    
    
    
    function getListaDesafios($idSeleccionado='') {
        $resultset_desafio= $this->getDesafio(); 
        $listadesafio=array();
        if($idSeleccionado!=''){
            while ($row_desafio = $resultset_desafio->fetch_assoc()) {
                if($row_desafio['des_id']==$idSeleccionado){
                    $listadesafio['lista_'.$row_desafio['des_id']] = array("value" => $row_desafio['des_id'],  "select" => "Selected" ,"texto" => $row_desafio['des_descripcion']);
                }else{
                    $listadesafio['lista_'.$row_desafio['des_id']] = array("value" => $row_desafio['des_id'],  "select" => "" ,"texto" => $row_desafio['des_descripcion']);
                }
            }
        }  else {
            while ($row_desafio = $resultset_desafio->fetch_assoc()) { 
                $listadesafio['lista_'.$row_desafio['des_id']] = array("value" => $row_desafio['des_id'],  "select" => "" ,"texto" => $row_desafio['des_descripcion']);
           }
       }
       return $listadesafio;

    } 
    
    function getMultiListaDesafios($idProspecto) {
        $resultset_desafio_selecionadas= $this->getDesafioSeleccionado($idProspecto); 
        $lista_desafio_selecionadas=array();
        while ($row_desafio_selecionada = $resultset_desafio_selecionadas->fetch_assoc()) { 
            $lista_desafio_selecionadas[$row_desafio_selecionada['desafio_des_id']]=$row_desafio_selecionada['desafio_des_id'];        
       
         }    
        $resultset_desafio= $this->getDesafio(); 
        $listadesafio=array();
        $bandera=FALSE;
        while ($row_desafio = $resultset_desafio->fetch_assoc()) { 
             foreach ($lista_desafio_selecionadas as $val){
            if($row_desafio['des_id']==$val){
                        $bandera=TRUE;
             }
        }                         
            if($bandera){
               $listadesafio['lista_'.$row_desafio['des_id']] = array("value" => $row_desafio['des_id'],  "select" => "selected" ,"texto" => $row_desafio['des_descripcion']);   
       
            }  else {
                $listadesafio['lista_'.$row_desafio['des_id']] = array("value" => $row_desafio['des_id'],  "select" => "" ,"texto" => $row_desafio['des_descripcion']);
     
            }
            $bandera=FALSE;
            
            
       } 
       return $listadesafio;
    }
    
     
    
}

