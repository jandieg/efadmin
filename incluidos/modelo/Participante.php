<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Participante
 *
 * @author ben
 */
class Participante extends Conexion{ 
    
    public function __construct(){
        parent:: __construct();        
    }
       
    public function setGrabar( $nombre, $apellido, $id_user, $correo, $celular, $tipo) {
        $fecha= date("Y-m-d H:i:s");
        $sql="call sp_createParticipante('$nombre','$apellido','$fecha','$id_user','$correo','$celular','$tipo')";
        //return parent::setSqlSp($sql); 
        
        $resultset= parent::getConsultar($sql);
        $idMaximo="0";
        if($row = $resultset->fetch_assoc()) { 
            $idMaximo=$row['part_id'];
        }
            
        return $idMaximo;  
    }  
    public function getParticipantes($tipo) {
        $sql="call sp_selectParticipantes('$tipo')";
        return parent::getConsultar($sql);   
    }
    public function getUltimoParticipante($tipo) {
        $sql="call sp_selectParticipanteMax('$tipo')";
        return parent::getConsultar($sql);   
    }
    function getUltimoParticipante_($tipo) {
        
        $resultset= $this->getUltimoParticipante($tipo);
        if ($row = $resultset->fetch_assoc()) { 
            
            return $row['part_id'];     
        }
    }
    // SELECT `part_id`, `part_estado`, `persona_per_id`, `part_fecharegistro`, `part_fechamodificacion`, `part_id_usuario` FROM `participante`;
     public function getListaParticipantes($idSeleccionado='', $tipo) {   
        $resultset= $this->getParticipantes($tipo); 
        $lista=array();
        if($idSeleccionado!=''){
            while ($row = $resultset->fetch_assoc()) {
                if($row['part_id'] == $idSeleccionado){
                    $lista['lista_'.$row['part_id']] = array("value_list" => $row['part_id'],  "select_list" => "selected" ,"texto_list" => $row['per_nombre']." ".$row['per_apellido']);

                }else{
                    $lista['lista_'.$row['part_id']] = array("value_list" => $row['part_id'],  "select_list" => "" ,"texto_list" => $row['per_nombre']." ".$row['per_apellido']);
                }

            }
        }  else {
           while ($row = $resultset->fetch_assoc()) { 
                $lista['lista_'.$row['part_id']] = array("value_list" => $row['part_id'],  "select_list" => "" ,"texto_list" => $row['per_nombre']." ".$row['per_apellido']);
           }
        }
        return $lista;
    }
  
    
    

}
