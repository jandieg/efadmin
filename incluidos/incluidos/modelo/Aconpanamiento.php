<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Aconpanamiento
 *
 * @author Benito
 */
class Aconpanamiento extends Conexion{ 

    public function __construct(){
        parent:: __construct();        
    }
    public function getAconpanamiento() {
        $sql="call sp_selectAcompanado()";
        return parent::getConsultar($sql);   
    } 
    
    public function getListaAconpanamiento($idTarea='') {
       //$objAco= new Aconpanamiento();
        $resultset= $this->getAconpanamiento(); 
        $lista=array();
        if($idTarea!=''){
            while ($row = $resultset->fetch_assoc()) { 
                if($idTarea==$row['eve_aco_id']){
                   $lista['lista_'.$row['eve_aco_id']] = array("value" => $row['eve_aco_id'],  "select" => "Selected" ,"texto" => $row['eve_aco_descripcion']);
                }else{
                   $lista['lista_'.$row['eve_aco_id']] = array("value" => $row['eve_aco_id'],  "select" => "" ,"texto" => $row['eve_aco_descripcion']);
                }
            }
        }  else {
            while ($row = $resultset->fetch_assoc()) { 
                $lista['lista_'.$row['eve_aco_id']] = array("value" => $row['eve_aco_id'],  "select" => "" ,"texto" => $row['eve_aco_descripcion']);
            }
       }
        return $lista;
    }
}