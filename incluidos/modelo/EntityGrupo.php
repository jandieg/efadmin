<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EntityGrupo
 *
 * @author PRUEBAS
 */
class EntityGrupo extends Entity{ 
    private $resultset= array();
      
    public function __construct($response= array()){
        parent:: __construct($response);       
    }
    
    public function getFiltro($etiqueta_array, $id, $permiso, $permiso_establecido_1, $permiso_establecido_2) {
        if ($permiso == $permiso_establecido_1){ 
            $parametros= array();
            $this->resultset= parent::getSp('sp_selectGrupos', $parametros, $etiqueta_array);
         }  elseif ($permiso == $permiso_establecido_2) {   
            $parametros= array($id, '4');
            $this->resultset= parent::getSp('sp_selectGrupoKey', $parametros, $etiqueta_array);
         }
         return $this->resultset;
    }
}
