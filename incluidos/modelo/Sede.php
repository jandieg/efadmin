<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Sede
 *
 * @author PRUEBAS
 */
class Sede extends Conexion{ 

    private $idCiudad= '0';
    
    public function __construct(){
        parent:: __construct();        
    }

    public function getTipoCambio($anho, $idUser) {
        $sql = "call sp_selectTipoCambio('$anho', '$idUser')";
        return parent::getConsultar($sql);
    }

    public function setTipoCambio($mes, $anho, $sede, $cambio, $moneda) {
        $sql = "call sp_updateTipoCambio('$mes', '$anho', '$sede', '$cambio', '$moneda')";
        return parent::setSqlSp($sql);
    }

    public function getSedeByUser($id_usuario) {
        $sql = "call sp_selectSedeByUser('$id_usuario')";
        return parent::getConsultar($sql);
    }
    
     public function getIdCiudad() {
        return $this->idCiudad;
    }
    public function setIdCiudad($idCiudad = '') {
        return $this->idCiudad = $idCiudad;
    }
    
    public function gets($estado) {
        $sql="call sp_selectSedes('$estado')";
        return parent::getConsultar($sql);   
    } 
    public function getSedesXCiudad($id) {
        $sql="call sp_selectSedesXCiudad('$id')";
        return parent::getConsultar($sql);   
    } 

    public function getListaSedeUsuario($id, $sede_id = '') {
        $lista = array();
        $resultset = $this->getSedesXPais($id);
        while ($row = $resultset->fetch_assoc()) {
            if ($row['sede_id'] == $sede_id) {
                $lista['lista_' . $row['sede_id']] = array("value" => $row['sede_id'],  
                "select" => "selected", "texto" => $row['sede_razonsocial'] . ' - ' . $row['ciu_nombre']);
            } else {
                $lista['lista_' . $row['sede_id']] = array("value" => $row['sede_id'],  
                "select" => "", "texto" => $row['sede_razonsocial'] . ' - ' . $row['ciu_nombre']);
            }
            
        }

        return $lista;
    }

    public function getSedesXPais($id) {
        $sql = "call sp_selectSedexPais('$id')";
        return parent::getConsultar($sql);
    }
    
    public function getLista($id='', $lista=array()) { 
        if($this->idCiudad == ''){
            $resultset= $this->gets('A');
        }  else {
            $resultset= $this->getSedesXCiudad($this->idCiudad);
        }
         
        if($id!=''){
            while ($row = $resultset->fetch_assoc()) { 
               if($id == $row['sede_id']){
                   $lista['lista_'.$row['sede_id']] = array("value" => $row['sede_id'],  "select" => "selected" ,"texto" => $row['sede_razonsocial']);
               }  else {
                   $lista['lista_'.$row['sede_id']] = array("value" => $row['sede_id'],  "select" => "" ,"texto" => $row['sede_razonsocial']);

               }

           }
        }  else {
           while ($row = $resultset->fetch_assoc()) { 
                $lista['lista_'.$row['sede_id']] = array("value" => $row['sede_id'],  "select" => "" ,"texto" => $row['sede_razonsocial']);
           }
        }
        return $lista;
    }

     public function setGrabar($nombre,$empleados,$tel,$movil, $fax, $sw, $descripcion,$correo_1, $correo_2, $pais, $calle, $cp, $ciudad, $admin, $user) {
        $fecha= date("Y-m-d H:i:s");
        $sql="call sp_createSede('$nombre','$empleados','$tel','$movil', '$fax', '$sw', '$descripcion','$correo_1', '$correo_2', '$pais', '$calle', '$cp', '$ciudad',"
                . " '$admin', '$user','$fecha')";
        return parent::setSqlSp($sql);   
    }
    public function get($id) {
        $sql="call sp_selectSede('$id')";
        return parent::getConsultar($sql);   
    }
    public function setActualizar($id,$estado, $nombre,$empleados,$tel,$movil, $fax, $sw, $descripcion,$correo_1, $correo_2, $pais, $calle, $cp, $ciudad, $admin, $user){
        $sql="call sp_updateSede('$id','$estado','$nombre','$empleados','$tel','$movil', '$fax', '$sw', '$descripcion','$correo_1', '$correo_2', '$pais', '$calle', '$cp', '$ciudad',"
                . " '$admin', '$user')";
        return parent::setSqlSp($sql);   
    }
   
}

