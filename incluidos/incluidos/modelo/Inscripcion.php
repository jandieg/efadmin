<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Inscripcion
 *
 * @author Benito
 */
class Inscripcion extends Conexion{ 

    public function __construct(){
        parent:: __construct();        
    }

     public function getInscripcion($id) {
        $sql="call sp_selectInscripcion('$id')";
        return parent::getConsultar($sql);   
    }

     public function setGrabar($valor, $idMiembro,  $user, $fechaInscripcion,$estado, $fecha_cobro) {
        $fecha= date("Y-m-d H:i:s");
        $ano= date("Y");
        $f_c= $fecha_cobro . ' ' . date("H:i:s");
        $sql="call sp_createInscripcion('$valor', '$idMiembro', '$fecha', '$user' ,'$fechaInscripcion','$estado','$ano', '$f_c')";  
        return parent::setSqlSp($sql);
        
    }
     public function setActualizar($id, $valor,  $user, $fechaInscripcion,$estado, $fecha_cobro) {
        $f_c= $fecha_cobro . ' ' . date("H:i:s");
        $sql="call sp_updateInscripcion('$id', '$valor',  '$user' ,'$fechaInscripcion','$estado', '$f_c')";  
        return parent::setSqlSp($sql);
        
}
    public function setCobrar($idMiembro,  $user) {
        $fecha= date("Y-m-d H:i:s");
        $ano= date("Y");
        $sql="call sp_updateInscriccionCobrar('$idMiembro','$ano',  '$fecha', '$user')";  
        return parent::setSqlSp($sql);
        
    }

}
