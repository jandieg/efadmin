<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pais
 *
 * @author PRUEBAS
 */
class Pais extends Conexion{ 
    private $idPais= '0';
    private $prefijoPais= '0';

    public function __construct(){
        parent:: __construct();        
    }
    
    public function getIdPais() {
        return $this->idPais;
    }
    public function getPrefijoPais() {
        return $this->prefijoPais;
    }
    public function getPaises() {
        $sql="call sp_selectPaises()";
        return parent::getConsultar($sql);   
    }  
	
	public function getPaisesAdmin() {
        $sql="call sp_selectPaisesAdmin()";
        return parent::getConsultar($sql);   
    }  
	
		public function getPaisesAplicantes($id) {
        $sql="call getPaisesAplicantes('$id')";
        return parent::getConsultar($sql);   
    }  
    
     public function getListaPaisAplicante($idSeleccionado, $listapais= array()) {   
       // $resultset_pais= $this->getPaisesAplicantes($idSeleccionado); 
		$resultset_pais= $this->getPaises(); 
//        $listapais=array();
        if($idSeleccionado!=''){
                while ($row_pais = $resultset_pais->fetch_assoc()) {
                if($row_pais['pai_id']==$idSeleccionado){
                    $listapais['lista_'.$row_pais['pai_id']] = array("value" => $row_pais['pai_id'],  "select" => "selected" ,"texto" => $row_pais['pai_nombre']);
                    $this->idPais= $row_pais['pai_id'];  
                    $this->prefijoPais= $row_pais['pai_prefijo']; 
                    
                }else{
                    $listapais['lista_'.$row_pais['pai_id']] = array("value" => $row_pais['pai_id'],  "select" => "" ,"texto" => $row_pais['pai_nombre']);
                }

            }
        }  else {
           while ($row_pais = $resultset_pais->fetch_assoc()) { 
                $listapais['lista_'.$row_pais['pai_id']] = array("value" => $row_pais['pai_id'],  "select" => "" ,"texto" => $row_pais['pai_nombre']);
                if($this->idPais =='0'){
                    $this->idPais= $row_pais['pai_id'];  
                    $this->prefijoPais= $row_pais['pai_prefijo'];
                }
           }
          }
        return $listapais;
    }
	
	
	 public function getListaPais($idSeleccionado='', $listapais= array()) {   
        $resultset_pais= $this->getPaises(); 
//        $listapais=array();
        if($idSeleccionado!=''){
                while ($row_pais = $resultset_pais->fetch_assoc()) {
                if($row_pais['pai_id']==$idSeleccionado){
                    $listapais['lista_'.$row_pais['pai_id']] = array("value" => $row_pais['pai_id'],  "select" => "selected" ,"texto" => $row_pais['pai_nombre']);
                    $this->idPais= $row_pais['pai_id'];  
                    $this->prefijoPais= $row_pais['pai_prefijo']; 
                    
                }else{
                    $listapais['lista_'.$row_pais['pai_id']] = array("value" => $row_pais['pai_id'],  "select" => "" ,"texto" => $row_pais['pai_nombre']);
                }

            }
        }  else {
           while ($row_pais = $resultset_pais->fetch_assoc()) { 
                $listapais['lista_'.$row_pais['pai_id']] = array("value" => $row_pais['pai_id'],  "select" => "" ,"texto" => $row_pais['pai_nombre']);
                if($this->idPais =='0'){
                    $this->idPais= $row_pais['pai_id'];  
                    $this->prefijoPais= $row_pais['pai_prefijo'];
                }
           }
          }
        return $listapais;
    }

}
