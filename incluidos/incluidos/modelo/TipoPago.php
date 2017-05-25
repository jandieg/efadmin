<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TipoPago
 *
 * @author Benito
 */
class TipoPago extends Conexion{ 

    public function __construct(){
        parent:: __construct();        
    }
    public function get() {
        $sql="call sp_selectTipoPago()";
        return parent::getConsultar($sql);   
    }
}
