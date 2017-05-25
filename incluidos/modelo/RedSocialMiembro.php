<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RedSocialMiembro
 *
 * @author Benito
 */
class RedSocialMiembro extends Conexion{ 

    public function __construct(){
        parent:: __construct();        
    }
    public function getRedSocial($id, $tipo) {
        $sql="call sp_selectRedSocialMiembro('$id', '$tipo')";
        return parent::getConsultar($sql);   
    }
    function getNombreRedSocial($id, $tipo) {
        $objRedSocial= new RedSocialMiembro();
        $resultset= $objRedSocial->getRedSocial($id, $tipo);
        if ($row = $resultset->fetch_assoc()) { // cor_id, cor_descripcion
            return $row['redmi_descripcion'];
         }
    }

   
}