<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cobro
 *
 * @author PRUEBAS
 */
class Cobro extends Conexion{ 

    public function __construct(){
        parent:: __construct();       
    }
 
    public function setGrabar($idpresupuestoCobro,$listaDetallePresupuesto="", $idMiembro, $idFormaPago, $user) {
        //la variable $listaGrupos, es para controlar los pagos
        $fecha= date("Y-m-d H:i:s");
        $sql="CALL sp_createCobro('$idpresupuestoCobro','$listaDetallePresupuesto', '$idMiembro', '$idFormaPago', '$fecha', '$user')";
        return parent::setSqlSp($sql);   
    }

    public function setGrabarWithDatetime($idpresupuestoCobro,$listaDetallePresupuesto="", $idMiembro, $idFormaPago, $user, $fecha) {
        //la variable $listaGrupos, es para controlar los pagos        
        $sql="CALL sp_createCobro('$idpresupuestoCobro','$listaDetallePresupuesto', '$idMiembro', '$idFormaPago', '$fecha', '$user')";
        return parent::setSqlSp($sql);   
    }    

    public function setReversar($idpresupuestoCobro,$listaDetallePresupuesto="", $idMiembro) {        
        $sql="CALL sp_reverseCobro('$idpresupuestoCobro','$listaDetallePresupuesto', '$idMiembro')";
        return parent::setSqlSp($sql);   
    }

    public function setUpdateCobrosByPresupuesto($idpresupuestoCobro,$listaDetallePresupuesto="", $idMiembro) {        
        $sql="CALL sp_updateCobrosByPresupuesto('$idpresupuestoCobro','$listaDetallePresupuesto', '$idMiembro')";
        return parent::setSqlSp($sql);   
    }
}
