<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EmpresariosMes
 *
 * @author PRUEBAS
 */
class EmpresariosMes extends Conexion{ 

    public function __construct(){
        parent:: __construct();        
    }
 
    public function getEventosEmpresariosMes($id='') {
        $sql="call sp_selectEventosEmpresariosMes('$id')";
        return parent::getConsultar($sql);   
    }
    
    public function getIDEventosEmpresariosMes($id='') {
        $sql="call sp_selectEventoEmpresarioMes('$id')";
        return parent::getConsultar($sql);   
    }
 
}
