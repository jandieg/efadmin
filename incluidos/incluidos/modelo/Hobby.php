<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Hobby
 *
 * @author PRUEBAS
 */
class Hobby extends Conexion{ 

    public function __construct(){
        parent:: __construct();        
    }
    public function getHobby() {
        $sql="call sp_selectHobbies()";
        return parent::getConsultar($sql);   
    }  
      function getLista($id='') {
        $resultset= $this->getHobby(); 
        $lista=array();
        if($id!=''){
            while ($row = $resultset->fetch_assoc()) {
                if($row['hob_id']==$id){
                    $lista['lista_'.$row['hob_id']] = array("value" => $row['hob_id'],  "select" => "Selected" ,"texto" => $row['hob_descripcion']);
                }else{
                    $lista['lista_'.$row['hob_id']] = array("value" => $row['hob_id'],  "select" => "" ,"texto" => $row['hob_descripcion']);
                }
            }
        }  else {
            while ($row = $resultset->fetch_assoc()) { 
                $lista['lista_'.$row['hob_id']] = array("value" => $row['hob_id'],  "select" => "" ,"texto" => $row['hob_descripcion']);
           }
       }
       return $lista;

    } 
    
}

