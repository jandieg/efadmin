<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GlobalSede
 *
 * @author PRUEBAS
 */
class GlobalSede extends Conexion{ 
    private $idPais= '0';  
    private $sedesBasesDatos= '';
    
    public function __construct(){
        parent:: __construct();        
    }
    
    public function getSedesBasesDatos() {
        return $this->sedesBasesDatos;
    }
    public function setSedesBasesDatos($sedesBasesDatos = '') {
        return $this->sedesBasesDatos = $sedesBasesDatos;
    }
    
    
    public function getIdPais() {
        return $this->idPais;
    }
    public function setIdPais($idPais = '') {
        return $this->idPais = $idPais;
    }
  
    
    public function getGlobalSedes($idPais) {
        $bases= $_SESSION['databases'];
        $sql="call sp_globalSelectSedes('$idPais', '$bases')";
        return parent::getConsultar($sql);   
    }
    
    public function getGlobalTodasSedes($estado) {
        $bases= $_SESSION['databases'];
        $sql="call sp_globalSelectTodasSedes('$estado', '$bases')";
        return parent::getConsultar($sql);   
    }
    
     public function getLista($id='', $lista=array()) {   
        $resultset= $this->getGlobalSedes($this->idPais); 
        if($id!=''){
            while ($row = $resultset->fetch_assoc()) {
                $this->sedesBasesDatos= $this->sedesBasesDatos . $row['db'] . ",";
                if($row['db']==$id){
                    $lista['lista_'.$row['db']] = array("value" => $row['db'],  "select" => "Selected" ,"texto" => $row['sede_razonsocial']);
                }else{
                    $lista['lista_'.$row['db']] = array("value" => $row['db'],  "select" => "" ,"texto" => $row['sede_razonsocial']);
                }
            }
        }  else {
            while ($row = $resultset->fetch_assoc()) { 
                $this->sedesBasesDatos= $this->sedesBasesDatos . $row['db'] . ",";
                $lista['lista_'.$row['db']] = array("value" => $row['db'],  "select" => "" ,"texto" => $row['sede_razonsocial']);
            }
        }
        return $lista;
    }
    
  
}
