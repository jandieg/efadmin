<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Evento
 *
 * @author PRUEBAS
 */
class Evento extends Conexion{ 

    private $objParticipantesAdicionales;
    private $objGrupos;
    private $objMiembros;
    private $objEmpresariosMes;
            
    public function __construct(){
        parent:: __construct();       
    }

   
//    public function setGrabarEvento( $idGenerado, $nombre, $titular,  $toeldia, $fi ,$ff, $descripcion, $id_user,$listaInvitados = '',
//            $listaGrupos = '', $listaMiembros = '', $misGrupos, $todosGrupos, $idEvento, $idDireccion,$idAcompanado, $listaContactos='', $listaEmpresarios='') {
//        $fecha= date("Y-m-d H:i:s");
//        $sql="call sp_createEventoCalendar( '$titular','$toeldia','$fi','$ff','$descripcion' , "
//                . "'$fecha' , '$id_user', '$listaInvitados','$listaGrupos','$listaMiembros',"
//                . "'$misGrupos','$todosGrupos','$idEvento','$idDireccion','$idAcompanado','$listaContactos','$listaEmpresarios','$nombre','$idGenerado')";  
//        return parent::setSqlSp($sql);
//        
//    }
    public function setGrabarEvento( $idGenerado, $nombre, $titular,  $toeldia, $fi ,$ff, $descripcion, $id_user,$listaInvitados = '',
            $listaGrupos = '', $listaMiembros = '', $misGrupos, $todosGrupos, $idEvento, $idDireccion,$idAcompanado, $listaContactos='', $listaEmpresarios='') {
        $fecha= date("Y-m-d H:i:s");
        $sql="call sp_createEventoCalendar( '$titular','$toeldia','$fi','$ff','$descripcion' , "
                . "'$fecha' , '$id_user', '$listaInvitados','$listaGrupos','$listaMiembros',"
                . "'$misGrupos','$todosGrupos','$idEvento','$idDireccion','$idAcompanado','$listaContactos','$listaEmpresarios','$nombre','$idGenerado')";  
        $resultset= parent::getConsultar($sql);
        $idEvento = 0;
        if($row = $resultset->fetch_assoc()) { 
           $idEvento= $row['eve_id'];                                                                    
        }
        return $idEvento;
        
    }
//    public function setEventoIDGenerado($idGenerado) {
//        $sql="call sp_selectEventoIDGenerado('$idGenerado')";
//        return parent::getConsultar($sql);   
//    }
//    public function getEventoIDGenerado($idGenerado) {
//        $idEvento='';
//         $resultset= $this->setEventoIDGenerado($idGenerado);
//         if($row = $resultset->fetch_assoc()) { 
//            $idEvento= $row['eve_id'];                                                                    
//         } 
//         return $idEvento;
//    }

    
    public function setActualizarEvento($id, $nombre, $titular,  $toeldia, $fi ,$ff, $descripcion, $id_user,$listaInvitados = '',
            $listaGrupos = '', $listaMiembros = '', $misGrupos, $todosGrupos,  $idDireccion,$idAcompanado, $listaContactos='', $listaEmpresarios='') {

        $sql="call sp_updateEventoCalendar('$id', '$titular','$toeldia','$fi','$ff','$descripcion' , "
                . "'$id_user', '$listaInvitados','$listaGrupos','$listaMiembros',"
                . "'$misGrupos','$todosGrupos','$idDireccion','$idAcompanado','$listaContactos','$listaEmpresarios','$nombre')";  
        return parent::setSqlSp($sql);
        
    }
    public function getEventosDetalle($id) {
        $sql="call sp_selectEventosDetalleCalendar('$id')";  
        return parent::getConsultar($sql);

    }

    public function getEventosByYearPeriod($anhoinicial, $anhofinal) {
        $sql="call sp_selectEventosByYearPeriod('$anhoinicial', '$anhofinal')";
        return parent::getConsultar($sql);
    }
    
     public function getEventoRecordarNotificar($id) {
        $sql="call sp_selectEventoRecordarNotificar('$id')";  
        return parent::getConsultar($sql);

    }
    public function getEventos($id) {
        $sql="call sp_selectEventosCalendar('$id')";  
        return parent::getConsultar($sql);

    }

    public function getTodosEventos() {
        $sql = "call sp_selectEventos()";
        return parent::getConsultar($sql);
    }

    public function getEventosByGrupo($idGrupo) {
        $sql = "call sp_selectEventosByGrupo('$idGrupo')";
        return parent::getConsultar($sql);
    }

    public function getEventosByForumLeader($idForumLeader) {
        $sql = "call sp_selectEventosByForumLeader('$idForumLeader')";
        return parent::getConsultar($sql);
    }
      

    public function getMiembrosPendientes() {
        $sql = "call sp_selectMiembrosPendientes()";
        return parent::getConsultar($sql);
    }
    public function getMiembrosPendientesxGrupo($idGrupo) {
        $sql = "call sp_selectMiembrosPendientesxGrupo('$idGrupo')";
        return parent::getConsultar($sql);
    }  

    public function getMiembrosPendientesxForumLeader($idMiembro) {
        $sql = "call sp_selectMiembrosPendientesxForumLeader('$idMiembro')";
        return parent::getConsultar($sql);
    }

    public function getJSONEventosCalendar($id){
        $resultset= $this->getEventos($id);
        $response = array();
        while ($row = $resultset->fetch_assoc()) { 
            array_push($response, $row);     
        } 
        return json_encode(json_encode($response)); 
    }
    
    
    public function getEvento($idEvento) {
        $sql="call sp_selectEvento('$idEvento')";  
        return parent::getConsultar($sql);

    }
    
    public function getEventoParticipanteAdicional($idEvento) {
        $sql="call sp_selectEventoParticipanteAdicional('$idEvento')";
        return parent::getConsultar($sql);   
    }
    public function getEventoGrupos($idEvento) {
        $sql="call sp_selectEventoGrupos('$idEvento')";
        return parent::getConsultar($sql);   
    }
    public function getEventoMiembros($idEvento) {
        $sql="call sp_selectEventoMiembros('$idEvento')";
        return parent::getConsultar($sql);   
    }
    
    
     function getMultiListaParticipantesAdicionales($idEvento,$tipo) {      
        $resultset_evento_selecionadas= $this->getEventoParticipanteAdicional($idEvento);         
        $lista_eve_selecionadas=array();
        while ($row_evento_selecionada = $resultset_evento_selecionadas->fetch_assoc()) { 
            $lista_eve_selecionadas[$row_evento_selecionada['participante_part_id']]=$row_evento_selecionada['participante_part_id'];        
       
         } 
        $this->objParticipantesAdicionales = new Participante();
        $resultset_participante= $this->objParticipantesAdicionales->getParticipantes($tipo); 
        $lista=array();
        $bandera=FALSE;
        while ($row_participante = $resultset_participante->fetch_assoc()) {      
            foreach ($lista_eve_selecionadas as $val){
                if($row_participante['part_id']==$val){
                    $bandera=TRUE;
                 }
            }
            if($bandera){
                $lista['lista_'.$row_participante['part_id']] = array("value_list" => $row_participante['part_id'],  "select_list" => "selected" ,"texto_list" => $row_participante['per_nombre']." ".$row_participante['per_apellido']);
            }  else {
                $lista['lista_'.$row_participante['part_id']] = array("value_list" => $row_participante['part_id'],  "select_list" => "" ,"texto_list" => $row_participante['per_nombre']." ".$row_participante['per_apellido']);
            }
            $bandera=FALSE;
        }
        return $lista;
        
    }
    
    function getMultiListaEventosGrupos($idEvento,$lista=array()) { 
                     
        $resultset_evento_selecionadas= $this->getEventoGrupos($idEvento);         
        $lista_eve_selecionadas=array();
        while ($row_evento_selecionada = $resultset_evento_selecionadas->fetch_assoc()) { 
            $lista_eve_selecionadas[$row_evento_selecionada['grupos_gru_id']]=$row_evento_selecionada['grupos_gru_id'];        
       
         } 
        $this->objGrupos= new Grupo();
        $resultset= $this->objGrupos->getGrupos();
        
        $bandera=FALSE;
        while ($row = $resultset->fetch_assoc()) {      
            foreach ($lista_eve_selecionadas as $val){
                if($row['gru_id']==$val){
                    $bandera=TRUE;
                 }
            }
            if($bandera){
                $lista['lista_'.$row['gru_id']] = array("value_list" => $row['gru_id']."G",  "select_list" => "selected" ,"texto_list" => $row['gru_descripcion']);
            }  
            $bandera=FALSE;
        }
        return $lista;
        
    }
    function getMultiListaEventosMiembros($idEvento, $listaGrupo=array()) { 
                     
        $resultset_evento_selecionadas= $this->getEventoMiembros($idEvento);         
        $lista_eve_selecionadas=array();
        while ($row_evento_selecionada = $resultset_evento_selecionadas->fetch_assoc()) { 
            $lista_eve_selecionadas[$row_evento_selecionada['miembro_mie_id']]=$row_evento_selecionada['miembro_mie_id'];        
       
         } 
        $this->objMiembros= new Miembro();
        $resultset= $this->objMiembros->getMiembros1();
        $lista= $listaGrupo;
        $bandera=FALSE;
        while ($row = $resultset->fetch_assoc()) {      
            foreach ($lista_eve_selecionadas as $val){
                if($row['mie_id']==$val){
                    $bandera=TRUE;
                 }
            }
            if($bandera){
                $lista['lista_'.$row['mie_id']] = array("value_list" => $row['mie_id']."-".$row['grupo_id']."M",  "select_list" => "selected" ,"texto_list" => $row['per_nombre']." ".$row['per_apellido']);
            }  
//            else {
//                $lista['lista_'.$row['gru_id']] = array("value_list" => $row['gru_id'],  "select_list" => "" ,"texto_list" => $row['gru_descripcion']);
//            }
            $bandera=FALSE;
        }
        return $lista;
        
    }
    
    
    
    function getMultiListaEventosEmpresariosMes($id) {
        $this->objEmpresariosMes= new EmpresariosMes();
        $resultset_em_selecionadas= $this->objEmpresariosMes->getIDEventosEmpresariosMes($id); 
        $lista_em_selecionadas=array();
        while ($row_em_selecionada = $resultset_em_selecionadas->fetch_assoc()) { 
            $lista_em_selecionadas[$row_em_selecionada['miembro_mie_id']]=$row_em_selecionada['miembro_mie_id'];        
       
        }
        $this->objMiembros= new Miembro();
        $resultset= $this->objMiembros->getMiembros1();
        $lista= array();
        $bandera=FALSE;
        while ($row = $resultset->fetch_assoc()) {      
            foreach ($lista_em_selecionadas as $val){
                if($row['mie_id']==$val){
                    $bandera=TRUE;
                }
            }
            if($bandera){
                $lista['lista_'.$row['mie_id']] = array("value" => $row['mie_id']."-".$row['grupo_id']."M",  "select" => "selected" ,"texto" => $row['per_nombre']." ".$row['per_apellido']);
            }else{
                $lista['lista_'.$row['mie_id']] = array("value" => $row['mie_id']."-".$row['grupo_id']."M",  "select" => "" ,"texto" => $row['per_nombre']." ".$row['per_apellido']);
            }  
            $bandera=FALSE;
        }
       return $lista;  
    }
    public function getParticipantesEventoInvitadoOContacto($idEvento, $tipo) {
        $sql="call sp_selectEventoParticipantesInvitadoOContacto('$idEvento','$tipo')";
        return parent::getConsultar($sql);   
    }
    public function getEventosDetalleGrupos($idEvento) {
        $sql="call sp_selectEventosDetalleGrupos('$idEvento')";
        return parent::getConsultar($sql);   
    }

    public function getEventosDetalleMiembros($idEvento) {
        $sql="call sp_selectEventosDetalleMiembros('$idEvento')";
        return parent::getConsultar($sql);   
    }
    
    
  
    
    
    public function setEventoEliminar($id) {
        $sql="call sp_deleteEvento('$id')";
        return parent::setSqlSp($sql);   
    }
    public function getIDParaAsistencia($id) {
        $sql="call sp_selectAsistenciaCreate('$id')";  
        return parent::getConsultar($sql);
        
        
                     

    }
}

 
    