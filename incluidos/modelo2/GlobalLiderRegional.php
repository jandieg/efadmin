<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LiderRegional
 *
 * @author PRUEBAS
 */
class GlobalLiderRegional extends Conexion{ 

    public function __construct(){
        parent:: __construct();        
    }
    
    public function gets() {
        $sql="call sp_selectLideres()";
        return parent::getConsultar($sql);   
    }
}
