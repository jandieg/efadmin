<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Miembro
 *
 * @author PRUEBAS
 */
class GlobalMiembro extends Conexion{ 

    public function __construct(){
        parent:: __construct();       
    }

    public function getGlobalFiltros($id, $key, $bases= '') {
       $db= ($bases == '') ? $_SESSION['databases'] : $bases;
       $sql="call sp_globalSelectMiembroFiltros('$id','$key', '$db')";
       return parent::getConsultar($sql);   
    }
}