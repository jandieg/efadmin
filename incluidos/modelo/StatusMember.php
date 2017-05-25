<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StatusMember
 *
 * @author PRUEBAS
 */
class StatusMember extends Conexion{ 

    public function __construct(){
        parent:: __construct();        
    }
    
    
    public function get($estado, $isMiembroAplicante) {
        $sql="call sp_selectStatus('$estado', '$isMiembroAplicante')";
        return parent::getConsultar($sql);   
    }
    
    function getLista($idSeleccionado='', $lista=array(), $isMiembroAplicante= '1') {
        $resultset= $this->get('A',$isMiembroAplicante); 
       
        if($idSeleccionado!=''){
            while ($row = $resultset->fetch_assoc()) { 
                if($row['mem_sta_id']==$idSeleccionado){
                    $lista['lista_'.$row['mem_sta_id']] = array("value" => $row['mem_sta_id'],  "select" => "selected" ,"texto" =>$row['mem_sta_codigo']." - ".$row['mem_sta_descripcion']);
                }else{
                    $lista['lista_'.$row['mem_sta_id']] = array("value" => $row['mem_sta_id'],  "select" => "" ,"texto" =>$row['mem_sta_codigo']." - ".$row['mem_sta_descripcion']); 
                }
            }
        }  else {
           while ($row = $resultset->fetch_assoc()) { 
                 $lista['lista_'.$row['mem_sta_id']] = array("value" => $row['mem_sta_id'],  "select" => "" ,"texto" =>$row['mem_sta_codigo']." - ".$row['mem_sta_descripcion']);
            }
       }
       return $lista;

    }//sp_updateStatusMember(IN _id INT ,IN _codigo VARCHAR(200), IN _descripcion VARCHAR(200), IN _usuario INT,  IN _estado VARCHAR(10))  BEGIN
    public function setGrabar($codigo , $descripcion, $user) {
        $fecha= date("Y-m-d H:i:s");
        $sql="call sp_createStatusMember('$codigo','$descripcion', '$user','$fecha')";
        return parent::setSqlSp($sql);   
    }
    public function getStatus($id) {
        $sql="call sp_selectStatuMember('$id')";
        return parent::getConsultar($sql);   
    }
    public function setActualizar($id, $codigo,$descripcion, $user, $estado) {
        $sql="call sp_updateStatusMember('$id','$codigo','$descripcion','$user', '$estado')";
        return parent::setSqlSp($sql);   
    }
}
