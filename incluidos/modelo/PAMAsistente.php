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
class PAMAsistente extends Conexion{ 

    public function __construct(){
        parent:: __construct();        
    }
    
    public function get($_id_miembro, $bansera= '1') {
        $sql="call sp_selectPAMAsistente('$_id_miembro', '$bansera')";
        return parent::getConsultar($sql);   
    }
    
    public function setCrearAsistente($_id_miembro, $nombre, $apellido, $id_user, $correo, $celular, $funcion,$convencional,$bansera= '1') {
        $fecha= date("Y-m-d H:i:s");
        $sql="call sp_createPAMAsistente('$_id_miembro','$nombre','$apellido','$fecha','$id_user', '$correo', '$celular', '$funcion','$convencional', '$bansera')";
        return parent::setSqlSp($sql);   
    }
     public function setActualizarAsistente($_id_asistente, $nombre, $apellido, $id_user, $correo, $celular, $funcion,$convencional,$bansera= '1') {     
        $sql="call sp_updatePAMAsistente('$_id_asistente','$nombre','$apellido','$id_user', '$correo', '$celular', '$funcion', '$convencional', '$bansera')";
        return parent::setSqlSp($sql);   
    } 
    
     public function setDeleteAsistente($_id_persona, $bansera= '1', $_id_asistente) {     
        $sql="call sp_deletePAMAsistente('$_id_persona', '$bansera', $_id_asistente)";
        return parent::setSqlSp($sql);   
    }

    public function getTablaSinEdicion($_id, $bandera= '1') {
        global $lblNombre, $lblCategoría,$lblTM, $lblTF, $lblCorreo;
            $cuerpo='';
            $cont= 1;
            $resultset= $this->get($_id,$bandera);
            while ($row_ma = $resultset->fetch_assoc()) { 
               $cuerpo.= generadorTablaColoresFilas("" ,
                       array(
                           $cont,
                           $row_ma['per_nombre'] ." ". $row_ma['per_apellido'],
                           $row_ma['cargo'],
                           $row_ma['movil'],
                           $row_ma['fijo'],
                           $row_ma['correo']
                           ));   
                 $cont= $cont + 1; 
             }


        $tablaDetalleAsistente= generadorTablaDetalleEstadoCuenta(
            array( "N°",
                generadorNegritas($lblNombre),
                generadorNegritas($lblCategoría),
                generadorNegritas($lblTM),
                generadorNegritas($lblTF),
                generadorNegritas($lblCorreo)), $cuerpo);

        
        return $tablaDetalleAsistente;
    }

    public function getTabla($_id, $bandera= '1') {
        global $lblNombre, $lblCategoría,$lblTM, $lblTF, $lblCorreo;
            $cuerpo='';
            $cont= 1;
            $resultset= $this->get($_id,$bandera);
            while ($row_ma = $resultset->fetch_assoc()) { 
               $cuerpo.= generadorTablaColoresFilas("" ,
                       array(
                           $cont,
                           $row_ma['per_nombre'] ." ". $row_ma['per_apellido'],
                           $row_ma['cargo'],
                           $row_ma['movil'],
                           $row_ma['fijo'],
                           $row_ma['correo'],
                           getAccionesParametrizadas(
                                   "getPAMActualizarAsistente(".$_id.",".$row_ma['mie_asi_id'].",'".$row_ma['per_nombre']."','".$row_ma['per_apellido']."','".$row_ma['movil']."','".$row_ma['correo']."',".$row_ma['cargo_id'].",'".$row_ma['fijo']."')",
                                   "modal_getPAMActualizarAsistente",
                                   "Actualizar",
                                   "fa fa-pencil").
                           getAccionesParametrizadas(
                                   "setPAMEliminarAsistente(".$_id.",".$row_ma['persona_per_id'].",'".$bandera."',".$row_ma['mie_asi_id'].")",
                                   "",
                                   "Eliminar",
                                   "fa fa-trash")));   
                 $cont= $cont + 1; 
             }


        $tablaDetalleAsistente= generadorTablaDetalleEstadoCuenta(
            array( "N°",
                generadorNegritas($lblNombre),
                generadorNegritas($lblCategoría),
                generadorNegritas($lblTM),
                generadorNegritas($lblTF),
                generadorNegritas($lblCorreo),
                generadorNegritas("Acción")), $cuerpo);

        
        return $tablaDetalleAsistente;
    }
}
