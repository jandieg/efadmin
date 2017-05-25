<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Provincia
 *
 * @author PRUEBAS
 */
class Provincia extends Conexion{ 

    private $idPais= '0';
    private $idProvincia= '0';
    
    public function __construct(){
        parent:: __construct();        
    }
    public function getIdProvincia() {
        return $this->idProvincia;
    }
    public function getIdPais() {
        return $this->idPais;
    }
    public function setIdPais($idPais) {
        return $this->idPais = $idPais;
    }
    
    public function getProvincias($pais) {
        $sql="call sp_selectProvinciaEstado('$pais')";
        return parent::getConsultar($sql);   
    } 
    
      public function getListaProvincia($idSeleccionado='') {   
        $resultset_prov= $this->getProvincias($this->idPais); 
        $listaprov=array();
        if($idSeleccionado!=''){
            while ($row_prov = $resultset_prov->fetch_assoc()) {
                if($row_prov['est_id']==$idSeleccionado){
                    $listaprov['lista_'.$row_prov['est_id']] = array("value" => $row_prov['est_id'],  "select" => "Selected" ,"texto" => $row_prov['est_nombre']);
                     $this->idProvincia= $row_prov['est_id'];                  
                }else{
                    $listaprov['lista_'.$row_prov['est_id']] = array("value" => $row_prov['est_id'],  "select" => "" ,"texto" => $row_prov['est_nombre']);
                  
                }

            }
        }  else {
           while ($row_prov = $resultset_prov->fetch_assoc()) { 
                $listaprov['lista_'.$row_prov['est_id']] = array("value" => $row_prov['est_id'],  "select" => "" ,"texto" => $row_prov['est_nombre']);
                if($this->idProvincia =='0'){
                    $this->idProvincia= $row_prov['est_id'];   
                }
           }
          }
        return $listaprov;
    }
    
    
    
    //sp_createProvincia(IN _pais INT, IN _provincia VARCHAR(200), IN _usuario INT,  IN _fecharegistro TIMESTAMP)
    public function get($estado) {
        $sql="call sp_selectProvincias('$estado')";
        return parent::getConsultar($sql);   
    }
    public function setGrabar($pais , $provincia, $user) {
        $fecha= date("Y-m-d H:i:s");
        $sql="call sp_createProvincia('$pais','$provincia', '$user','$fecha')";
        return parent::setSqlSp($sql);   
    }
    public function getProvincia($id) {
        $sql="call sp_selectProvincia('$id')";
        return parent::getConsultar($sql);   
    }
    public function setActualizar($id, $pais,$provincia, $user, $estado) {
        $sql="call sp_updateProvincia('$id','$pais','$provincia','$user', '$estado')";
        return parent::setSqlSp($sql);   
    }
  
}

