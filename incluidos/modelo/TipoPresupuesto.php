<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TipoPresupuesto
 *
 * @author PRUEBAS
 */
class TipoPresupuesto extends Conexion{ 

   
    private $tipoEstado= '';
    public function __construct(){
        parent:: __construct();        
    }
    
    public function getPrimerIDTipo() {
        $resultset= $this->getTipoPresupuesto(); 
        if ($row = $resultset->fetch_assoc()) { 
           $this->tipoEstado=$row['tip_pre_id'];
        }
        return $this->tipoEstado;
    }

    public function getTipoPresupuesto() {
        $sql="call sp_selectTipoPresupuesto()";
        return parent::getConsultar($sql);   
    }
    
    

}
