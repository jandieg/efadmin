<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Correo
 *
 * @author Benito
 */
class Correo extends Conexion{ 

    public function __construct(){
        parent:: __construct();        
    }
//    public function getCorreo($id) {
//        $sql="call sp_selectCorreos('121')";
//        return parent::getConsultar($sql);   
//    }
 public function getCorreo($id) {
        $sql="SELECT `cor_id`, `cor_descripcion` FROM `correo` WHERE Persona_per_id='$id'";
        return parent::getConsultar($sql);   
    }
    
    
    
   
    
    function getCorreoPersonalSecundario($idpersona,$tipo='') {
        $correo='';
        $correo_2='';
        $resultset= $this->getCorreo($idpersona);
        while ($row_correo = $resultset->fetch_assoc()) { // `cor_id`, `cor_descripcion`
            if($correo==''){
                $correo=$row_correo['cor_descripcion'];
            }else{
                $correo_2=$row_correo['cor_descripcion'];
            }

        }
        if($tipo=='Personal'){
           return $correo;
        }  else {
           return $correo_2;
        }    
    }

   
}
