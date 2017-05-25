<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MiembroEmpresa
 *
 * @author PRUEBAS
 */
class MiembroEmpresa extends Conexion{ 

    public function __construct(){
        parent:: __construct();        
    }
    
     public function get($_id_empresa= '' , $_id_miembro='') {
        $sql="call sp_selectMiembroEmpresa('$_id_empresa', '$_id_miembro')";
        return parent::getConsultar($sql);   
    }
    public function setAdd($_id_miembro, $empresa, $descripcion, $id_user) {
        $fecha= date("Y-m-d H:i:s");
        $sql="call sp_createMiembroEmpresa('$_id_miembro','$empresa','$descripcion','$fecha','$id_user')";
        return parent::setSqlSp($sql);   
    }
    public function setActualizar($_id_miembro, $empresa, $descripcion, $id_user) {
        $sql="call sp_updateMiembroEmpresa('$_id_miembro','$empresa','$descripcion','$id_user')";
        return parent::setSqlSp($sql);   
    }
    public function setDelete($_id_miembro_empresa) {
        $sql="call sp_deleteMiembroEmpresa('$_id_miembro_empresa')";
        return parent::setSqlSp($sql);   
    }
}
