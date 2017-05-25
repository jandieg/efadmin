<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Categoria
 *
 * @author PRUEBAS
 */
class Categoria extends Conexion{ 

    public function __construct(){
        parent:: __construct();        
    }
    public function getCategoria($estado) {
		if($_SESSION['_esaplicante'] == '1'){
        $sql="call sp_selectCargosAplicantes('$estado')";
		}else{
		$sql="call sp_selectCargos('$estado')";	
		}
        return parent::getConsultar($sql);   
    } 
    
    public function getListaCategoria($idSeleccionado='') {   
        $resultset_categoria= $this->getCategoria('A'); 
        $listacategoria=array();
        if($idSeleccionado!=''){
            while ($row_categoria = $resultset_categoria->fetch_assoc()) { 
               if($idSeleccionado==$row_categoria['cat_id']){
                   $listacategoria['lista_'.$row_categoria['cat_id']] = array("value" => $row_categoria['cat_id'],  "select" => "selected" ,"texto" => $row_categoria['cat_descripcion']);
               }  else {
                   $listacategoria['lista_'.$row_categoria['cat_id']] = array("value" => $row_categoria['cat_id'],  "select" => "" ,"texto" => $row_categoria['cat_descripcion']);

               }

           }
        }  else {
           while ($row_categoria = $resultset_categoria->fetch_assoc()) { 
                $listacategoria['lista_'.$row_categoria['cat_id']] = array("value" => $row_categoria['cat_id'],  "select" => "" ,"texto" => $row_categoria['cat_descripcion']);
           }
          }
        return $listacategoria;
    }
   
    //sp_updateCargo(IN _id INT ,IN _descripcion VARCHAR(200), IN _usuario INT,  IN _estado VARCHAR(10))
     public function setGrabar($descripcion, $user) {
        $fecha= date("Y-m-d H:i:s");
        $sql="call sp_createCargo('$descripcion', '$user','$fecha')";
        return parent::setSqlSp($sql);   
    }
    public function get($id) {
        $sql="call sp_selectCargo('$id')";
        return parent::getConsultar($sql);   
    }
    public function setActualizar($id, $descripcion, $user, $estado) {
        $sql="call sp_updateCargo('$id','$descripcion','$user', '$estado')";
        return parent::setSqlSp($sql);   
    }
   
}


 