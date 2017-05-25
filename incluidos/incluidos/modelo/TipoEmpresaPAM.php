<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TipoEmpresaPAM
 *
 * @author PRUEBAS
 */
class TipoEmpresaPAM extends Conexion{ 

    public function __construct(){
        parent:: __construct();        
    }

    public function getTipo() {
        $sql="SELECT `tip_emp_id`, `tip_emp_descripcion` FROM `tipo_empresa_pam`";
        return parent::getConsultar($sql);   
    } 
    public function getLista($idSeleccionado='', $lista= array()) {   
        $resultset= $this->getTipo(); 
//        $lista=array();
        if($idSeleccionado!=''){
            while ($row = $resultset->fetch_assoc()) { 
               if($idSeleccionado==$row['tip_emp_id']){
                   $lista['lista_'.$row['tip_emp_id']] = array("value" => $row['tip_emp_id'],  "select" => "selected" ,"texto" => $row['tip_emp_descripcion']);
               }  else {
                   $lista['lista_'.$row['tip_emp_id']] = array("value" => $row['tip_emp_id'],  "select" => "" ,"texto" => $row['tip_emp_descripcion']);

               }

           }
        }  else {
           while ($row = $resultset->fetch_assoc()) { 
                $lista['lista_'.$row['tip_emp_id']] = array("value" => $row['tip_emp_id'],  "select" => "" ,"texto" => $row['tip_emp_descripcion']);
           }
          }
        return $lista;
    }
}
