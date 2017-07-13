<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Membresia
 *
 * @author PRUEBAS
 */
class Membresia extends Conexion{ 

    public function __construct(){
        parent:: __construct();        
    }
    public function getMembresias($estado) {
        $sql="call sp_selectMembresias('$estado')";
        return parent::getConsultar($sql);   
    } 
    
    
     public function getMembresia($id) {
        $sql="call sp_selectMembresia('$id')";
        return parent::getConsultar($sql);   
    }
     // SELECT `memb_id`, `memb_descripcion`, `memb_valor`, `memb_estado`, `memb_id_usuario`, `memb_fecharegistro`, `memb_fechamodificacion` FROM `membresia` WHERE memb_id = _id;
    function getMembresiaValor($id) {
        $resultset= $this->getMembresia($id); 
        $valor='';
        if ($row = $resultset->fetch_assoc()) { 
           $valor= $row['memb_valor'];
        }
        return $valor;
    }

    function getMembresiaByValor($valor) {
        $sql = "call sp_selectMembresiaByValor('$valor')";
        return parent::getConsultar($sql);
    }

    function getListaComboMembresiaValor($id='') {
        $resultset= $this->getMembresias('A'); 
        $lista=array();
        //if (!empty($resultset))
        while ($row = $resultset->fetch_assoc()) {  
            if ($id == $row['memb_id']) {
                $lista[$row['memb_valor']] = array("value" => $row['memb_id'],  "select" => "Selected" ,"texto" => "$ " . $row['memb_valor']);                
            } else {
                $lista[$row['memb_valor']] = array("value" => $row['memb_id'],  "select" => "" ,"texto" => "$ " . $row['memb_valor']);                
            }            
            
        }
        krsort($lista);
        return $lista;
    }
    
    function getListaComboMembresiaValorValor() {
        $resultset= $this->getMembresias('A'); 
        $lista=array();
        
        while ($row = $resultset->fetch_assoc()) {                 
            $lista[$row['memb_valor']] = array("value" => $row['memb_valor'],  "select" => "" ,"texto" => "$ " . $row['memb_valor']);                
        }
        krsort($lista);
        return $lista;
    }
    
    
    function getListaComboMembresia($idSeleccionado="") {
        $resultset= $this->getMembresias('A'); 
        $lista='';
        while ($row = $resultset->fetch_assoc()) {
           if($idSeleccionado==$row['memb_id']){
               $lista.='<option  value="'.$row['memb_id'].'" selected>'.$row['memb_descripcion'].'</option>';
           }  else {
               $lista.='<option  value="'.$row['memb_id'].'">'.$row['memb_descripcion'].'</option>';

           }
        }
        return $lista;
    }
    public function getListaMembresias($id='', $lista_=array()) {   
        $resultset= $this->getMembresias('A'); 
        $lista=$lista_;
        if($id!=''){
            while ($row = $resultset->fetch_assoc()) { 
                if($id==$row['memb_id']){
                   $lista['lista_'.$row['memb_id']] = array("value" => $row['memb_id'],  "select" => "Selected" ,"texto" => $row['memb_descripcion']);
                }else{
                   $lista['lista_'.$row['memb_id']] = array("value" => $row['memb_id'],  "select" => "" ,"texto" => $row['memb_descripcion']);
                }
            }
        }  else {
            while ($row = $resultset->fetch_assoc()) { 
                $lista['lista_'.$row['memb_id']] = array("value" => $row['memb_id'],  "select" => "" ,"texto" => $row['memb_descripcion']);
            }
       }
        return $lista;
    }
    
    //sp_updateMembresia(IN _id INT ,IN _valor DOUBLE, IN _membresia VARCHAR(200), IN _usuario INT,  IN _estado VARCHAR(10))
    public function setGrabar($valor , $membresia, $user) {
        $fecha= date("Y-m-d H:i:s");
        $sql="call sp_createMembresia('$valor','$membresia', '$user','$fecha')";
        return parent::setSqlSp($sql);   
    }
    public function setActualizar($id, $valor , $membresia, $user, $estado) {
        $sql="call sp_updateMembresia('$id','$valor','$membresia','$user', '$estado')";
        return parent::setSqlSp($sql);   
    }
}
