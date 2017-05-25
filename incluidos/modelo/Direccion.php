<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Direccion
 *
 * @author PRUEBAS
 */
class Direccion extends Conexion{ 

    public function __construct(){
        parent:: __construct();        
    }
    public function getDireccion($id) {
        $sql="call sp_selectDireccion('$id')";
        return parent::getConsultar($sql);   
    }
    
    public function getDireccionxIdentificador($identificador) {
        $sql="call sp_selectEventoDireccion('$identificador')";
        return parent::getConsultar($sql);   
    } 
   //SELECT `dir_id`, `dir_calleprincipal`,  `ciudad_ciu_id`  FROM `direccion` WHERE dir_identificador=_identificador; 
    public function getListaDireccion($identificador,$idSeleccionado='') {   
        $resultset= $this->getDireccionxIdentificador($identificador); 
        $lista=array();
        $lista['lista_'] = array("value" => "0",  "select" => "" ,"texto" => "Seleccionar...");
        if($idSeleccionado!=''){
            while ($row = $resultset->fetch_assoc()) { 
                if($idSeleccionado==$row['dir_id']){
                   $lista['lista_'.$row['dir_id']] = array("value" => $row['dir_id'],  "select" => "Selected" ,"texto" => $row['dir_calleprincipal']);
                }else{
                   $lista['lista_'.$row['dir_id']] = array("value" => $row['dir_id'],  "select" => "" ,"texto" => $row['dir_calleprincipal']);
                }
            }
        }  else {
            while ($row = $resultset->fetch_assoc()) { 
                $lista['lista_'.$row['dir_id']] = array("value" => $row['dir_id'],  "select" => "" ,"texto" => $row['dir_calleprincipal']);
            }
       }
        return $lista;
    }
    
    public function setCrearDireccionModal($idCiudad, $direccion,  $user,$identificador ) {
        $fecha= date("Y-m-d H:i:s");
        $sql="call sp_createDireccionModal('$idCiudad', '$direccion', '$fecha', '$user','$identificador')";
        
        $resultset= parent::getConsultar($sql);
        $idMaximo="0";
        if($row = $resultset->fetch_assoc()) { 
            $idMaximo=$row['dir_id'];
        }
            
        return $idMaximo;   
    }
    public function getDirecciones($estado) {
        $sql="call sp_selectDirecciones('$estado')";
        return parent::getConsultar($sql);   
    }
    //sp_createDireccion(IN _ciudad INT, IN _direccion TEXT, IN _tipo VARCHAR(200), IN _usuario INT,  IN _fecharegistro TIMESTAMP)
    public function setGrabar($ciudad , $direccion,$tipo, $user) {
        $fecha= date("Y-m-d H:i:s");
        $sql="call sp_createDireccion('$ciudad','$direccion','$tipo', '$user','$fecha')";
        return parent::setSqlSp($sql);   
    }
    public function get($id) {
        $sql="call sp_selectDireccion2('$id')";
        return parent::getConsultar($sql);   
    }
    public function setActualizar($id, $ciudad,$direccion,$tipo, $user, $estado) {
        $sql="call sp_updateDireccion('$id','$ciudad','$direccion','$tipo','$user', '$estado')";
        return parent::setSqlSp($sql);   
    }

   //sp_updateDireccion(IN _id INT ,IN _ciudad INT, IN _direccion TEXT, IN _tipo VARCHAR(200), IN _usuario INT,  IN _estado VARCHAR(10))
}

