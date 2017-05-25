<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Asistencia
 *
 * @author Benito
 */
class Asistencia extends Conexion{ 


            
    public function __construct(){
        parent:: __construct();       
    }

   
  
    
    
     function setCrearAsistencia($id, $user) {   
        $objEvento= new Evento();
        $resultset= $objEvento->getIDParaAsistencia($id);
        
        $listaGruposMiembros='';
        $listaMiembrosInvitados='';
        $listaMiembrosEmpresario='';
        $listaInvitados='';
        while ($row = $resultset->fetch_assoc()) {
           if($row['key'] == "mis-grupos-miembros" || $row['key'] == "todos-grupos-miembros" || $row['key'] == "grupos-miembros"){    
               $listaGruposMiembros .=$row['id'].",";
               
           } elseif ($row['key'] == "miembros") {
               $listaMiembrosInvitados .= $row['id'].",";
               
           }
        }
        $fecha= date("Y-m-d H:i:s");
        $sql="call sp_createAsistencia('$id', '$listaGruposMiembros','$listaMiembrosInvitados',"
             . "'$fecha','$user')";  
        return parent::setSqlSp($sql);

    }   
    function setCrearAsistencia2($id, $user,$listaGruposMiembros,$listaMiembrosInvitados) {   
        
        $fecha= date("Y-m-d H:i:s");
        $sql="call sp_createAsistencia('$id', '$listaGruposMiembros','$listaMiembrosInvitados',"
             . "'$fecha','$user')";  
        return parent::setSqlSp($sql);

    } 
    
    function getAsistencia($grupo, $fecha_inicio = '',$fecha_fin= '', $tipoEvento) {   
        if($fecha_inicio == '' || $fecha_fin == ''){
            $fecha_inicio = getPrimerDiaMes(date('Y'),'1');
            $fecha_fin= getUltimoDiaMes(date('Y'),'12');
        }
        $fecha= date("Y-m-d H:i:s");
        $sql="call sp_selectAsistencia('$grupo', '$fecha_inicio','$fecha_fin','$tipoEvento')";  
        return parent::getConsultar($sql);
    } 
    function getAsistenciaTotales($grupo, $fecha_inicio = '',$fecha_fin= '', $tipoEvento) {   
        if($fecha_inicio == '' || $fecha_fin == ''){
            $fecha_inicio = getPrimerDiaMes(date('Y'),'1');
            $fecha_fin= getUltimoDiaMes(date('Y'),'12');
        }
        $fecha= date("Y-m-d H:i:s");
        $sql="call sp_selectAsistenciaTotales('$grupo', '$fecha_inicio','$fecha_fin','$tipoEvento')";  
        return parent::getConsultar($sql);
    } 
    
    function setActualizarAsistencia($id_asistencia, $user,$estado) {   
        
        //$fecha= date("Y-m-d H:i:s");
        $sql="call sp_updateAsistencia('$id_asistencia','$user','$estado')";  
        return parent::setSqlSp($sql);

    } 
    
    
     function getAsistenciaCasos($grupo, $fecha_inicio = '',$fecha_fin= '', $tipoEvento) {   
        if($fecha_inicio == '' || $fecha_fin == ''){
            $fecha_inicio = getPrimerDiaMes(date('Y'),'1');
            $fecha_fin= getUltimoDiaMes(date('Y'),'12');
        }
        $sql="call sp_selectAsistenciaCasos('$grupo', '$fecha_inicio','$fecha_fin','$tipoEvento')";  
        return parent::getConsultar($sql);
    } 
    
    function setActualizarAsistenciaCasos($id_eve_emp, $user,$estado) {   

        $sql="call sp_updateAsistenciaCaso('$id_eve_emp','$user','$estado')";  
        return parent::setSqlSp($sql);

    } 
    
}

    