<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cuidad
 *
 * @author PRUEBAS
 */
class Ciudad extends Conexion{ 

    private $idCiudad= '0';
    private $idProvincia= '0';
    
    public function __construct(){
        parent:: __construct();        
    }
     public function getIdCiudad() {
        return $this->idCiudad;
    }
    public function getIdProvincia() {
        return $this->idProvincia;
    }
    public function setIdProvincia($idProvincia) {
        return $this->idProvincia = $idProvincia;
    }
    
    public function getCiudad($provincia, $estado) {
        $sql="call sp_selectCiudadxProvincias('$provincia','$estado')";
        return parent::getConsultar($sql);   
    }
    
    
    
    
     public function getListaCiudad($idSeleccionado='') {   
        $resultset_ciu= $this->getCiudad($this->idProvincia, 'A'); 
        $listaciudad=array();
        if($idSeleccionado!=''){
            while ($row_ciu = $resultset_ciu->fetch_assoc()) {
                if($row_ciu['ciu_id']==$idSeleccionado){
                     $listaciudad['lista_'.$row_ciu['ciu_id']] = array("value" => $row_ciu['ciu_id'],  "select" => "Selected" ,"texto" => $row_ciu['ciu_nombre']);
                        
                     $this->idCiudad= $row_ciu['ciu_id'];
                }else{
                     $listaciudad['lista_'.$row_ciu['ciu_id']] = array("value" => $row_ciu['ciu_id'],  "select" => "" ,"texto" => $row_ciu['ciu_nombre']);
                }

            }
        }  else {
            while ($row_ciu = $resultset_ciu->fetch_assoc()) { 
                  $listaciudad['lista_'.$row_ciu['ciu_id']] = array("value" => $row_ciu['ciu_id'],  "select" => "" ,"texto" => $row_ciu['ciu_nombre']);
                  if($this->idCiudad =='0'){
                        $this->idCiudad= $row_ciu['ciu_id'];   
                    }
           }
          
          }
        return $listaciudad;
    }

    public function getCiudades($estado) {
        $sql="call sp_selectCiudades('$estado')";
        return parent::getConsultar($sql);   
    }
    
    public function setGrabar($ciudad , $provincia, $user) {
        $fecha= date("Y-m-d H:i:s");
        $sql="call sp_createCiudad('$provincia','$ciudad', '$user','$fecha')";
        return parent::setSqlSp($sql);   
    }
    public function get($id) {
        $sql="call sp_selectCiudad('$id')";
        return parent::getConsultar($sql);   
    }
    public function setActualizar($id, $ciudad,$provincia, $user, $estado) {
        $sql="call sp_updateCiudad('$id','$provincia','$ciudad','$user', '$estado')";
        return parent::setSqlSp($sql);   
    }
    
}

