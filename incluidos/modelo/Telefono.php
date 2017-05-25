<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Telefono
 *
 * @author Benito
 */
class Telefono extends Conexion{ 

    public function __construct(){
        parent:: __construct();        
    }
//    public function getTelefono($id, $tipo) {
//        $sql="SELECT `tel_id`, `tel_descripcion` FROM `telefono` WHERE tel_tipo='$tipo' and Persona_per_id='$id'";
//        return parent::getConsultar($sql);   
//    }
     public function getTelefono($id, $tipo) {
        $sql="call sp_selectTelefonos('$id', '$tipo')";
        return parent::getConsultar($sql);   
    }
    function getTelefonoTipo($id, $tipo) {
        $objTelefono= new Telefono();
        $resultset= $objTelefono->getTelefono($id, $tipo);
        if ($row = $resultset->fetch_assoc()) { // `cor_id`, `cor_descripcion`
            return $row['tel_descripcion'];
         }
    }

   
}
