<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TipoEvento
 *
 * @author PRUEBAS
 */
class TipoEvento extends Conexion{ 
    private $primer= '';
    
    public function __construct(){
        parent:: __construct();        
    }
    public function getPrimer() {
        return $this->primer;
    }
    public function getTipoEvento($id="") {
        $sql="call sp_selectTipoEvento('$id')";
        return parent::getConsultar($sql);   
    } 
     public function getTipoEventoParametrizada($id= 1, $key= 1) {
        $sql="call sp_selectTipoEventoParametrizada('$id', '$key')";
        return parent::getConsultar($sql);   
    } 

    public function getTipoEventoAcotado() {
        $sql = "call sp_selectTipoEventoAcotado('$id')";
        return parent::getConsultar($sql);
    }

    function getListaAcotada($idSeleccionado='',$lista= array(), $with_periodo= '', $key= '') {
        
        $resultset= $this->getTipoEventoAcotado('');     
        while ($row = $resultset->fetch_assoc()) { 
                $lista['lista_'.$row['tip_eve_id']] = array("value" => $row['tip_eve_id'],  "select" => "" ,"texto" => $row['tip_eve_descripcion']);
                if($this->primer == ''){
                $this->primer=$row['tip_eve_id'];
                }
        }
       return $lista;

    }
    
    function getLista($idSeleccionado='',$lista= array(), $with_periodo= '', $key= '') {
        if($with_periodo == ''){
            $resultset= $this->getTipoEvento(''); 
        }else{
            $resultset= $this->getTipoEventoParametrizada($with_periodo, $key); 
        }
       
        if($idSeleccionado!=''){
            while ($row = $resultset->fetch_assoc()) { 
                if($row['tip_eve_id']==$idSeleccionado){
                    $lista['lista_'.$row['tip_eve_id']] = array("value" => $row['tip_eve_id'],  "select" => "selected" ,"texto" => $row['tip_eve_descripcion']);
                    if($this->primer == ''){
                        $this->primer=$row['tip_eve_id'];
                    }
                }else{
                    $lista['lista_'.$row['tip_eve_id']] = array("value" => $row['tip_eve_id'],  "select" => "" ,"texto" => $row['tip_eve_descripcion']); 
                }
            }
        }  else {
           while ($row = $resultset->fetch_assoc()) { 
                 $lista['lista_'.$row['tip_eve_id']] = array("value" => $row['tip_eve_id'],  "select" => "" ,"texto" => $row['tip_eve_descripcion']);
                 if($this->primer == ''){
                    $this->primer=$row['tip_eve_id'];
                 }
            }
       }
       return $lista;

    }
    

}
