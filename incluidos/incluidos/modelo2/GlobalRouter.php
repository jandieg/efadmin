<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Router
 *
 * @author PRUEBAS
 */
class GlobalRouter extends Conexion{ 

    public function __construct(){
        parent:: __construct();        
    }
    
    public function getRouterLogin($usuario) {
        $bases= $_SESSION['databases'];
        $sql="call sp_globalSelectRouterLogin('$usuario', '$bases')";
        return parent::getConsultar($sql);   
    }
    
}