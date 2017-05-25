<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Empresa
 *
 * @author PRUEBAS
 */
class Empresa extends Conexion{ 

    public function __construct(){
        parent:: __construct();        
    }
    public function getEmpresa() {
        $sql="call sp_selectSedeEmpresa()";
        return parent::getConsultar($sql);   
    }

    public function setActualizarEmpresa($id,$nombre,$empleados,$tel,$movil, $fax, $sw, $descripcion, $pais, $calle, $cp, $ciudad, $admin, $user) {
        $sql="call sp_updateSedeEmpresa('$id','$nombre','$empleados','$tel','$movil', '$fax', '$sw', '$descripcion', '$pais', '$calle', '$cp', '$ciudad',"
                . " '$admin', '$user')";
        return parent::setSqlSp($sql);   
    }        
    }
