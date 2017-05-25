<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Permiso
 *
 * @author PRUEBAS
 */
class Permiso extends Conexion{ 
   

    public function __construct(){
        parent:: __construct();        
    }
    
    public function getPermisos($idPerfil) {
        $sql="call sp_selectRolPermisos('$idPerfil')";
        return parent::getConsultar($sql);   
    }
    
    public function getPermisosGlobales($idPerfil) {
        $sql="call sp_selectRolPermiso('$idPerfil')";
        return parent::getConsultar($sql);   
    }
    
    public function setEstablecerPermisoPerfil($idPerfil, $idPermiso,$estado, $idModificador) {
        $fecha= date("Y-m-d H:i:s");
        $sql="call sp_createRolPermiso('$idPerfil','$idPermiso', '$estado','$fecha','$idModificador')";
        return parent::setSqlSp($sql);   
    }
    public function setActualizarPermisoPerfil($idPerfil, $idPermiso,$estado, $idModificador) {
        $sql="call sp_updateRolPermiso('$idPerfil','$idPermiso', '$estado','$idModificador')";
        return parent::setSqlSp($sql);   
    }
    
}
