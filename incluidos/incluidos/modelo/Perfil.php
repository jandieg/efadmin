<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Perfil
 *
 * @author Benito
 */
class Perfil extends Conexion{ 
    private $idPrimero= '';
    
    public function __construct(){
        parent:: __construct();        
    }
    public function getIdPrimero() {
        return $this->idPrimero;
    }
    public function getPerfiles() {
        $sql="CALL sp_selectPerfiles()";
        return parent::getConsultar($sql);   
    }
    public function getPerfilPerfilForumLeader() {
        $sql="CALL sp_selectPerfilForumLeader()";
        return parent::getConsultar($sql);   
    }
    public function getPerfil($id) {
        $sql="call sp_selectPerfil('$id')";
        return parent::getConsultar($sql);   
    }

     public function setActualizarPerfil($id, $desc, $est, $id_user) {
        $sql="call sp_updatePerfil('$id', '$desc', '$est', '$id_user')";
        return parent::setSqlSp($sql);   
    }
    public function setInactivarPerfil($id,$id_user) {
        $sql="call sp_updatePerfilInactivar('$id','$id_user')";
        return parent::setSqlSp($sql);   
    }
    public function setCrearPerfil( $desc, $est, $id_user) {
        $fecha= date("Y-m-d H:i:s");
        $sql="call sp_createPerfil('$desc','$est','$fecha','$id_user')";
        return parent::setSqlSp($sql);   
    }
    
    public function getListaPerfiles($idPerfil='',$lista=array(), $bandera= '1') {   
        if($bandera == '1'){
            $resultset= $this->getPerfiles(); 
        } elseif ($bandera == '3') {
            $resultset= $this->getPerfilPerfilForumLeader(); 
        }
        
        
        if($idPerfil!=''){
            while ($row = $resultset->fetch_assoc()) { 
                if($this->idPrimero == ''){ $this->idPrimero = $row['per_id']; }
                if($idPerfil==$row['per_id']){
                   $lista['lista_'.$row['per_id']] = array("value" => $row['per_id'],  "select" => "Selected" ,"texto" => $row['per_descripcion']);
                }else{
                   $lista['lista_'.$row['per_id']] = array("value" => $row['per_id'],  "select" => "" ,"texto" => $row['per_descripcion']);
                }
            }
        }  else {
            while ($row = $resultset->fetch_assoc()) { 
                if($this->idPrimero == ''){  $this->idPrimero = $row['per_id']; }
                $lista['lista_'.$row['per_id']] = array("value" => $row['per_id'],  "select" => "" ,"texto" => $row['per_descripcion']);
            }
       }
        return $lista;
    }
    
   
}
