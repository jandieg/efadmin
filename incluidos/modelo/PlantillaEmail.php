<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MiembroAsistente
 *
 * @author PRUEBAS
 */
class PlantillaEmail extends Conexion{ 

    public function __construct(){
        parent:: __construct();        
    }
    
    public function getPlantillaById($idPlantilla) {
        $sql = "call sp_selectPlantillaById('$idPlantilla')";
        return parent::getConsultar($sql);
    }
}
