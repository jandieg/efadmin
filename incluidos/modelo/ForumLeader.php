<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ForumLeader
 *
 * @author Benito
 */
class ForumLeader extends Conexion{ 

    public function __construct(){
        parent:: __construct();        
    }
    public function getForumLeader($id_forum= '') {
        $sql="Call sp_selectForumLeader('$id_forum')";
        return parent::getConsultar($sql);   
    }
    public function getForumLeader7($id_forum= '', $idUser) {
        $sql="Call sp_selectForumLeader7('$id_forum', '$idUser')";
        return parent::getConsultar($sql);   
    }

    public function getForumLeader7ConGrupos($id_forum= '', $idUser) {
        $sql="Call sp_selectForumLeader7ConGrupos('$id_forum', '$idUser')";
        return parent::getConsultar($sql);   
    }

    public function getForumLeader2($id_forum= '', $estado= '') {
        $sql="Call sp_selectForumLeader1('$id_forum' , '$estado')";
        return parent::getConsultar($sql);   
    }
    public function getListaForumLeaders($idSeleccionado='') {   
        $resultset= $this->getForumLeader(NULL); 
        $listaForum=array();
        if($idSeleccionado!=''){
             while ($row = $resultset->fetch_assoc()) {
                if($idSeleccionado==$row['usu_id']){
                     $listaForum['lista_'.$row['usu_id']] = array("value" => $row['usu_id'],  "select" => "selected" ,"texto" => $row['per_nombre'].' '.$row['per_apellido']);
                }  else {
                    $listaForum['lista_'.$row['usu_id']] = array("value" => $row['usu_id'],  "select" => "" ,"texto" => $row['per_nombre'].' '.$row['per_apellido']);
                }
             }
        }  else {
             while ($row = $resultset->fetch_assoc()) { 
                $listaForum['lista_'.$row['usu_id']] = array("value" => $row['usu_id'],  "select" => "" ,"texto" => $row['per_nombre'].' '.$row['per_apellido']);

            } 
       }
        return $listaForum;
    }
	//Para eventos//
	public function getPersonaById($idPersona) {
        $sql = "call sp_selectPersonaById('$idPersona')";
        return parent::getConsultar($sql);
    }
	public function getListaForumLeadersEVENTOS($idSeleccionado='') {   
        $resultset= $this->getForumLeader(NULL); 
        $listaForum=array();
        if($idSeleccionado!=''){
             while ($row = $resultset->fetch_assoc()) {
                if($idSeleccionado==$row['per_id']){
                     $listaForum['lista_'.$row['usu_id']] = array("value" => $row['per_id'],  "select" => "selected" ,"texto" => $row['per_nombre'].' '.$row['per_apellido']);
                }  else {
                    $listaForum['lista_'.$row['usu_id']] = array("value" => $row['per_id'],  "select" => "" ,"texto" => $row['per_nombre'].' '.$row['per_apellido']);
                }
             }
        }  else {
             while ($row = $resultset->fetch_assoc()) { 
                $listaForum['lista_'.$row['usu_id']] = array("value" => $row['per_id'],  "select" => "" ,"texto" => $row['per_nombre'].' '.$row['per_apellido']);

            } 
       }
        return $listaForum;
    }

    public function getListaForumLeadersEVENTOSConGrupos($idSeleccionado='', $idUser) {   
        $resultset= $this->getForumLeader7ConGrupos(NULL, $idUser); 
        $listaForum=array();
        if($idSeleccionado!=''){
             while ($row = $resultset->fetch_assoc()) {
                if($idSeleccionado==$row['per_id']){
                     $listaForum['lista_'.$row['usu_id']] = array("value" => $row['per_id'],  "select" => "selected" ,"texto" => $row['per_nombre'].' '.$row['per_apellido']);
                }  else {
                    $listaForum['lista_'.$row['usu_id']] = array("value" => $row['per_id'],  "select" => "" ,"texto" => $row['per_nombre'].' '.$row['per_apellido']);
                }
             }
        }  else {
             while ($row = $resultset->fetch_assoc()) { 
                $listaForum['lista_'.$row['usu_id']] = array("value" => $row['per_id'],  "select" => "" ,"texto" => $row['per_nombre'].' '.$row['per_apellido']);

            } 
       }
        return $listaForum;
    }
	
	
    public function getListaForumLeaders2($idSeleccionado='',$listaForum=array()) {   
        $resultset= $this->getForumLeader(NULL); 
        
      
        if($idSeleccionado!=''){
             while ($row = $resultset->fetch_assoc()) { //usuario.usu_id , persona.per_nombre, persona.per_apellido
                if($idSeleccionado==$row['usu_id']){
                     $listaForum['lista_'.$row['usu_id']] = array("value" => $row['usu_id'],  "select" => "selected" ,"texto" => $row['per_nombre'].' '.$row['per_apellido']);
                }  else {
                    $listaForum['lista_'.$row['usu_id']] = array("value" => $row['usu_id'],  "select" => "" ,"texto" => $row['per_nombre'].' '.$row['per_apellido']);

                }

             }
        }  else {
             while ($row = $resultset->fetch_assoc()) { 
                $listaForum['lista_'.$row['usu_id']] = array("value" => $row['usu_id'],  "select" => "" ,"texto" => $row['per_nombre'].' '.$row['per_apellido']);

            } 
       }
        return $listaForum;
    }

    public function getListaForumLeaders7($idSeleccionado='',$listaForum=array(), $idUser) {   
        $resultset= $this->getForumLeader7(NULL, $idUser); 
        
      
        if($idSeleccionado!=''){
             while ($row = $resultset->fetch_assoc()) { //usuario.usu_id , persona.per_nombre, persona.per_apellido
                if($idSeleccionado==$row['usu_id']){
                     $listaForum['lista_'.$row['usu_id']] = array("value" => $row['usu_id'],  "select" => "selected" ,"texto" => $row['per_nombre'].' '.$row['per_apellido']);
                }  else {
                    $listaForum['lista_'.$row['usu_id']] = array("value" => $row['usu_id'],  "select" => "" ,"texto" => $row['per_nombre'].' '.$row['per_apellido']);

                }

             }
        }  else {
             while ($row = $resultset->fetch_assoc()) { 
                $listaForum['lista_'.$row['usu_id']] = array("value" => $row['usu_id'],  "select" => "" ,"texto" => $row['per_nombre'].' '.$row['per_apellido']);

            } 
       }
        return $listaForum;
    }

    public function getListaForumLeaders7ConGrupos($idSeleccionado='',$listaForum=array(), $idUser) {   
        $resultset= $this->getForumLeader7ConGrupos(NULL, $idUser); 
        
      
        if($idSeleccionado!=''){
             while ($row = $resultset->fetch_assoc()) { //usuario.usu_id , persona.per_nombre, persona.per_apellido
                if($idSeleccionado==$row['usu_id']){
                     $listaForum['lista_'.$row['usu_id']] = array("value" => $row['usu_id'],  "select" => "selected" ,"texto" => $row['per_nombre'].' '.$row['per_apellido']);
                }  else {
                    $listaForum['lista_'.$row['usu_id']] = array("value" => $row['usu_id'],  "select" => "" ,"texto" => $row['per_nombre'].' '.$row['per_apellido']);

                }

             }
        }  else {
             while ($row = $resultset->fetch_assoc()) { 
                $listaForum['lista_'.$row['usu_id']] = array("value" => $row['usu_id'],  "select" => "" ,"texto" => $row['per_nombre'].' '.$row['per_apellido']);

            } 
       }
        return $listaForum;
    }

        public function getListaForumLeaders7ConGruposPersona($idSeleccionado='',$listaForum=array(), $idUser) {   
        $resultset= $this->getForumLeader7ConGrupos(NULL, $idUser); 
        
      
        if($idSeleccionado!=''){
             while ($row = $resultset->fetch_assoc()) { //usuario.usu_id , persona.per_nombre, persona.per_apellido
                if($idSeleccionado==$row['usu_id']){
                     $listaForum['lista_'.$row['per_id']] = array("value" => $row['Persona_per_id'],  "select" => "selected" ,"texto" => $row['per_nombre'].' '.$row['per_apellido']);
                }  else {
                    $listaForum['lista_'.$row['per_id']] = array("value" => $row['Persona_per_id'],  "select" => "" ,"texto" => $row['per_nombre'].' '.$row['per_apellido']);

                }

             }
        }  else {
             while ($row = $resultset->fetch_assoc()) { 
                $listaForum['lista_'.$row['per_id']] = array("value" => $row['per_id'],  "select" => "" ,"texto" => $row['per_nombre'].' '.$row['per_apellido']);

            } 
       }
        return $listaForum;
    }


     public function getListaForumLeaders3($idSeleccionado='', $estado,$listaForum=array()) {   
        $resultset= $this->getForumLeader2(NULL, $estado); 
        
      
        if($idSeleccionado!=''){
             while ($row = $resultset->fetch_assoc()) { //usuario.usu_id , persona.per_nombre, persona.per_apellido
                if($idSeleccionado==$row['usu_id']){
                     $listaForum['lista_'.$row['usu_id']] = array("value" => $row['usu_id'],  "select" => "selected" ,"texto" => $row['per_nombre'].' '.$row['per_apellido']);
                }  else {
                    $listaForum['lista_'.$row['usu_id']] = array("value" => $row['usu_id'],  "select" => "" ,"texto" => $row['per_nombre'].' '.$row['per_apellido']);

                }

             }
        }  else {
             while ($row = $resultset->fetch_assoc()) { 
                $listaForum['lista_'.$row['usu_id']] = array("value" => $row['usu_id'],  "select" => "" ,"texto" => $row['per_nombre'].' '.$row['per_apellido']);

            } 
       }
        return $listaForum;
    }
    
    public function getPrimerGruposDePrivilegioForumLeader($idPrivilegioForum) {
        $sql="call sp_selectForumLeaderMax('$idPrivilegioForum')";
        return parent::getConsultar($sql);   
    }
    function getIdPrimerGruposDePrivilegioForumLeader($idPrivilegioForum) {
        $resultset= $this->getPrimerGruposDePrivilegioForumLeader($idPrivilegioForum); 
        $nombreGrupo='';
        if ($row = $resultset->fetch_assoc()) { //usuario.usu_id , persona.per_nombre, persona.per_apellido
           $nombreGrupo=$row['gru_id'];

        }
        return $nombreGrupo;
    }
    
    function getListaComboForumLeader() {
        $resultset= $this->getForumLeader(NULL); 
        $listaForum='';
        while ($row = $resultset->fetch_assoc()) { //usuario.usu_id , persona.per_nombre, persona.per_apellido
           $listaForum.='<option value="'.$row['usu_id'].'">'.$row['per_nombre'].' '.$row['per_apellido'].'</option>';

        }
        return $listaForum;
    }
    
    function getCorreo($id, $tipo= 'Personal') {
        $sql="Call sp_selectUsuarioCorreo('$id', '$tipo')";
        $resultset= parent::getConsultar($sql); 
        
        if ($row = $resultset->fetch_assoc()) {
            return $row['correo_forum'];
        }
        return '';
    }

}
