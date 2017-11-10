<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Grupo
 *
 * @author Benito
 */
class Grupo extends Conexion{ 
    private $primerGrupo= '';
    public function __construct(){
        parent:: __construct();       
    }
    
     public function getPrimerGrupo() {
        return $this->primerGrupo;
    }
    
     public function getGrupos() {
        $sql="CALL `sp_selectGrupos`()";
        return parent::getConsultar($sql);   
    }

    public function getGrupos3($idUser) {
        $sql = "call sp_selectGrupos2('$idUser')";
        return parent::getConsultar($sql);
    }
    public function getGrupos2($estado= '') {
        $sql="CALL `sp_selectGrupos1`('$estado')";
        return parent::getConsultar($sql);   
    }
     public function getNombreGrupos($id) {
        $sql="call sp_selectGrupoKey('$id', '1')";
        return parent::getConsultar($sql);   
    }
      public function getIDGrupoxForum($id) {
        $sql="call sp_selectGrupoKey('$id', '2')";
        return parent::getConsultar($sql);   
    }
    public function getIDForumxGrupo($id) {
        $sql="call sp_selectGrupoKey('$id', '3')";
        return parent::getConsultar($sql);   
    }
    public function getIDGrupos() {
        $sql="call sp_selectGrupoKey('0', '5')";
        return parent::getConsultar($sql);   
    }
    
 
    public function setGrabarGrupo($idForum, $grupo, $idModificador, $sede) {
        $fecha= date("Y-m-d H:i:s");
         $sql="call sp_createGrupo('$grupo','$idForum','$fecha','$idModificador', '$sede')";
        return parent::setSqlSp($sql);   
    }
  
    public function setActualizarGrupo($idGrupo, $idForum, $grupo, $idModificador) {
        $sql="call sp_updateGrupo('$idGrupo','$grupo','$idForum','$idModificador')";
        return parent::setSqlSp($sql);   
    }
    
 
    public function getMiembroxGruposAllMiembros($idMiembro) {
        $sql="call sp_selectSmMiembrosxGrupo('$idMiembro')";
        return parent::getConsultar($sql);   
    }
    
    
    //Metodos 
   public function getNombre($idForum) {
        $nombre_grupo='';
         $resultset= $this->getNombreGrupos($idForum);
         if($row = $resultset->fetch_assoc()) { 
            $nombre_grupo= $row['gru_descripcion'];                                                                    
         } 
         return $nombre_grupo;
    }
    
    public function getNombreForum($id) {
        $sql="call sp_selectGrupoNombreForum('$id')";
        return parent::getConsultar($sql);   
    }
    public function getNombreForum_($idGrupo) {
        $nombre='';
         $resultset= $this->getNombreForum($idGrupo);
         if($row = $resultset->fetch_assoc()) { 
            $nombre= $row['forum'];                                                                    
         } 
         return $nombre;
    }
    
    
 
    function getListaComboGruposForum($idForum) {
        $resultset= $this->getGruposForum($idForum); 
        $listaForum='';
        while ($row = $resultset->fetch_assoc()) {
           $listaForum.='<option value="'.$row['gru_id'].'">'.$row['gru_descripcion'].'</option>';

        }
        return $listaForum;
    }

    
    
    ////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////

    

   public function getListaGrupos($idSeleccionado='') {   
        $resultset= $this->getGrupos();
        $listaGrupos=array();
        if($idSeleccionado!=''){
            while($row = $resultset->fetch_assoc()) { 
                if($row['gru_id'] == $idSeleccionado){
                      $listaGrupos['lista_'.$row['gru_id']] = array( "value" => $row['gru_id'],  "select" => "selected" ,"texto" => $row['gru_descripcion']);
                
                      if($this->primerGrupo == ''){
                        $this->primerGrupo=$row['gru_id'];
                      }
                }else{
                     $listaGrupos['lista_'.$row['gru_id']] = array( "value" => $row['gru_id'],  "select" => "" ,"texto" => $row['gru_descripcion']);

                }
            }
        }  else {
            while($row = $resultset->fetch_assoc()) { 
                $listaGrupos['lista_'.$row['gru_id']] = array( "value" => $row['gru_id'],  "select" => "" ,"texto" => $row['gru_descripcion']);
            
                if($this->primerGrupo == ''){
                        $this->primerGrupo=$row['gru_id'];
                      }
            }
       }
        return $listaGrupos;
    }

       public function getListaGrupos7($idSeleccionado='',$listaGrupos=array(), $idUser) {   
        $resultset= $this->getGrupos3($idUser);      
        if($idSeleccionado!=''){
            while($row = $resultset->fetch_assoc()) { 
                if($row['gru_id'] == $idSeleccionado){
                      $listaGrupos['lista_'.$row['gru_id']] = array( "value" => $row['gru_id'],  "select" => "selected" ,"texto" => $row['gru_descripcion']);
                      if($this->primerGrupo == ''){  $this->primerGrupo=$row['gru_id'];  }
                }else{
                     $listaGrupos['lista_'.$row['gru_id']] = array( "value" => $row['gru_id'],  "select" => "" ,"texto" => $row['gru_descripcion']);
                     if($this->primerGrupo == ''){  $this->primerGrupo=$row['gru_id'];  }
                }
            }
        }  else {
            while($row = $resultset->fetch_assoc()) { 
                $listaGrupos['lista_'.$row['gru_id']] = array( "value" => $row['gru_id'],  "select" => "" ,"texto" => $row['gru_descripcion']);
            
                if($this->primerGrupo == ''){  $this->primerGrupo=$row['gru_id'];  }
            }
       }
        return $listaGrupos;
    
    }

    public function getGrupoByMiembro($idMiembro) {
        $sql = "call sp_selectGrupoByMiembro('$idMiembro')";
        return parent::getConsultar($sql);
    }

    public function getListaGrupos3() {
        $sql= "call sp_selectListaGrupos()";
        return parent::getConsultar($sql);
    }

    public function getGrupoByTipoEvento($tipo_evento_id) {
        $sql="call sp_selectGrupoByTipoEvento('$tipo_evento_id')";
        return parent::getConsultar($sql);   
    }

    public function getListaByAgrup($listaAgrup = array()) {
        $datos = array(
            "A" => "Top",
            "B" => "Key",
            "C" => "Esposas"
        );        
        foreach ($datos as $k => $d) {
            $listaAgrup['lista_' . $k] = array("value" => $k, "select" =>"", "texto" => $d);
        }
        return $listaAgrup;
    }

    public function getListaByTipoEvento($tipo_evento_id) {
        $resultset = $this->getGrupoByTipoEvento($tipo_evento_id);

        $listaGrupos = array();
        while($row = $resultset->fetch_assoc()) { 
            $listaGrupos['lista_'.$row['gru_id']] = array( "value" => $row['gru_id'],  "select" => "" ,"texto" => $row['gru_descripcion']);
        
            if($this->primerGrupo == ''){  $this->primerGrupo=$row['gru_id'];  }
        }
        return $listaGrupos;
    }

  public function getListaGrupos4($idSeleccionado='', $listaGrupos=array(), $idUser) {   
        $resultset= $this->getGrupos3($idUser);
        
      
        if($idSeleccionado!=''){
            while($row = $resultset->fetch_assoc()) { 
                if($row['gru_id'] == $idSeleccionado){
                      $listaGrupos['lista_'.$row['gru_id']] = array( "value" => $row['gru_id'],  "select" => "selected" ,"texto" => $row['gru_descripcion']);
                      if($this->primerGrupo == ''){  $this->primerGrupo=$row['gru_id'];  }
                }else{
                     $listaGrupos['lista_'.$row['gru_id']] = array( "value" => $row['gru_id'],  "select" => "" ,"texto" => $row['gru_descripcion']);
                     if($this->primerGrupo == ''){  $this->primerGrupo=$row['gru_id'];  }
                }
            }
        }  else {
            while($row = $resultset->fetch_assoc()) { 
                $listaGrupos['lista_'.$row['gru_id']] = array( "value" => $row['gru_id'],  "select" => "" ,"texto" => $row['gru_descripcion']);
            
                if($this->primerGrupo == ''){  $this->primerGrupo=$row['gru_id'];  }
            }
       }
        return $listaGrupos;
    }
    

   public function getListaGrupos2($idSeleccionado='', $listaGrupos=array()) {   
        $resultset= $this->getGrupos();
        
      
        if($idSeleccionado!=''){
            while($row = $resultset->fetch_assoc()) { 
                if($row['gru_id'] == $idSeleccionado){
                      $listaGrupos['lista_'.$row['gru_id']] = array( "value" => $row['gru_id'],  "select" => "selected" ,"texto" => $row['gru_descripcion']);
                      if($this->primerGrupo == ''){  $this->primerGrupo=$row['gru_id'];  }
                }else{
                     $listaGrupos['lista_'.$row['gru_id']] = array( "value" => $row['gru_id'],  "select" => "" ,"texto" => $row['gru_descripcion']);
                     if($this->primerGrupo == ''){  $this->primerGrupo=$row['gru_id'];  }
                }
            }
        }  else {
            while($row = $resultset->fetch_assoc()) { 
                $listaGrupos['lista_'.$row['gru_id']] = array( "value" => $row['gru_id'],  "select" => "" ,"texto" => $row['gru_descripcion']);
            
                if($this->primerGrupo == ''){  $this->primerGrupo=$row['gru_id'];  }
            }
       }
        return $listaGrupos;
    }
    
    
       public function getGruposForum($idForum) {
        $sql="call sp_selectGrupoKey('$idForum', '4')";
        return parent::getConsultar($sql);   
    }

    public function getGruposForumByAgrup($idForum, $agrup = "") {
        $sql = "call sp_selectGruposForumByAgrup('$idForum', '$agrup')";
        return parent::getConsultar($sql);
    }

    public function getGrupoByUsuario($idUser, $agrup) {
        $sql = "call sp_selectGrupoByUser('$idUser', '$agrup')";
        return parent::getConsultar($sql);
    }

    public function getGrupoByEmpresa($idEmpresa) {
        $sql ="call sp_selectGrupoByEmpresa('$idEmpresa');";
        return parent::getConsultar($sql);
    } 

    public function getGrupoByIndustria($idIndustria) {
        $sql ="call sp_selectGrupoByIndustria('$idIndustria');";
        return parent::getConsultar($sql);
    }

    public function getGrupoByIndustriaAndUser($idIndustria, $idUser) {
        $sql ="call sp_selectGrupoByIndustriaAndUser('$idIndustria', '$idUser');";
        return parent::getConsultar($sql);
    }

    public function getGrupoByForumLeader($idForumLeader) {
        $sql ="call sp_selectGrupoByForumLeader('$idForumLeader')";
        return parent::getConsultar($sql);
    }

    public function getGrupoByForumLeaderPersona($idPersona) {
        $sql ="call sp_selectGrupoByForumLeaderPersona('$idPersona')";
        return parent::getConsultar($sql);
    }

    public function getListaGruposByForumLeader($idForumLeader, $lista=array()) {
        $resultset = $this->getGrupoByForumLeader($idForumLeader);
         while($row = $resultset->fetch_assoc()) { 
            $lista['lista_'.$row['gru_id']] = array( "value" => $row['gru_id'],  "select" => "" ,"texto" => $row['gru_descripcion']);
            if($this->primerGrupo == ''){ $this->primerGrupo=$row['gru_id']; }
        }
        return $lista; 
    }

    public function getListaGruposByForumLeaderPersona($idPersona, $lista=array()) {
        $resultset = $this->getGrupoByForumLeaderPersona($idPersona);
         while($row = $resultset->fetch_assoc()) { 
            $lista['lista_'.$row['gru_id']] = array( "value" => $row['gru_id'],  "select" => "" ,"texto" => $row['gru_descripcion']);
            if($this->primerGrupo == ''){ $this->primerGrupo=$row['gru_id']; }
        }
        return $lista; 
    }

    public function getMiembrosActivosPorGrupo( $idGrupo, $key) {
        $sql="call sp_selectMiembrosActivosxGrupo1('$idGrupo', $key)";
        return parent::getConsultar($sql);   
    }

    public function getListaGruposByEmpresa($lista=array(),$idEmpresa) {
        $resultset = $this->getGrupoByEmpresa($idEmpresa);
         while($row = $resultset->fetch_assoc()) { 
            $lista['lista_'.$row['gru_id']] = array( "value" => $row['gru_id'],  "select" => "" ,"texto" => $row['gru_descripcion']);
            if($this->primerGrupo == ''){ $this->primerGrupo=$row['gru_id']; }
        }
        return $lista;
    }

    public function getGruposAgrupExcluyendo($idExcluir) {
        $sql = "call sp_selectGruposAgrupExcluyendo('$idExcluir')";
        return parent::getConsultar($sql);
    }

    public function getGruposA($idExcluir) {
        $resultset = $this->getGruposAgrupExcluyendo($idExcluir);
        $lista = array();
        while ($row = $resultset->fetch_assoc()) {
            $lista[] = $row['gru_id'];
        }
        return $lista;
    }

    public function getListaGruposSede($idUser='', $idSeleccionado='',$list= array()) {           
        $resultset= $this->getGruposSede($idUser);
        if($idSeleccionado!=''){
            while($row = $resultset->fetch_assoc()) { 
                if($row['gru_id'] == $idSeleccionado){
                     $list['lista_'.$row['gru_id']] = array( "value" => $row['gru_id'],  "select" => "selected" ,"texto" => $row['gru_descripcion']);
                     if($this->primerGrupo == ''){ $this->primerGrupo=$row['gru_id']; }
                }else{
                     $list['lista_'.$row['gru_id']] = array( "value" => $row['gru_id'],  "select" => "" ,"texto" => $row['gru_descripcion']);
                     if($this->primerGrupo == ''){ $this->primerGrupo=$row['gru_id']; }
                }
            }
        }  else {
            while($row = $resultset->fetch_assoc()) { 
                $list['lista_'.$row['gru_id']] = array( "value" => $row['gru_id'],  "select" => "" ,"texto" => $row['gru_descripcion']);
                if($this->primerGrupo == ''){ $this->primerGrupo=$row['gru_id']; }
            }
       }
        return $list;
    }

    public function getListaGruposSede2($idUser='', $idSeleccionado='',$list= array(), $agrup = "") {           
        $resultset= $this->getGrupoByUsuario($idUser, $agrup);
        if($idSeleccionado!=''){
            while($row = $resultset->fetch_assoc()) { 
                if($row['gru_id'] == $idSeleccionado){
                     $list['lista_'.$row['gru_id']] = array( "value" => $row['gru_id'],  "select" => "selected" ,"texto" => $row['gru_descripcion']);
                     if($this->primerGrupo == ''){ $this->primerGrupo=$row['gru_id']; }
                }else{
                     $list['lista_'.$row['gru_id']] = array( "value" => $row['gru_id'],  "select" => "" ,"texto" => $row['gru_descripcion']);
                     if($this->primerGrupo == ''){ $this->primerGrupo=$row['gru_id']; }
                }
            }
        }  else {
            while($row = $resultset->fetch_assoc()) { 
                $list['lista_'.$row['gru_id']] = array( "value" => $row['gru_id'],  "select" => "" ,"texto" => $row['gru_descripcion']);
                if($this->primerGrupo == ''){ $this->primerGrupo=$row['gru_id']; }
            }
       }
        return $list;
    }
    
    public function getListaGruposForum($idForum='', $idSeleccionado='',$list= array()) {           
        $resultset= $this->getGruposForum($idForum);
        if($idSeleccionado!=''){
            while($row = $resultset->fetch_assoc()) { 
                if($row['gru_id'] == $idSeleccionado){
                     $list['lista_'.$row['gru_id']] = array( "value" => $row['gru_id'],  "select" => "selected" ,"texto" => $row['gru_descripcion']);
                     if($this->primerGrupo == ''){ $this->primerGrupo=$row['gru_id']; }
                }else{
                     $list['lista_'.$row['gru_id']] = array( "value" => $row['gru_id'],  "select" => "" ,"texto" => $row['gru_descripcion']);
                     if($this->primerGrupo == ''){ $this->primerGrupo=$row['gru_id']; }
                }
            }
        }  else {
            while($row = $resultset->fetch_assoc()) { 
                $list['lista_'.$row['gru_id']] = array( "value" => $row['gru_id'],  "select" => "" ,"texto" => $row['gru_descripcion']);
                if($this->primerGrupo == ''){ $this->primerGrupo=$row['gru_id']; }
            }
       }
        return $list;
    }

     public function getListaGruposForum2($idForum='', $idSeleccionado='',$list= array(), $agrup) {           
        $resultset= $this->getGruposForumByAgrup($idForum);
        if($idSeleccionado!=''){
            while($row = $resultset->fetch_assoc()) { 
                if($row['gru_id'] == $idSeleccionado){
                     $list['lista_'.$row['gru_id']] = array( "value" => $row['gru_id'],  "select" => "selected" ,"texto" => $row['gru_descripcion']);
                     if($this->primerGrupo == ''){ $this->primerGrupo=$row['gru_id']; }
                }else{
                     $list['lista_'.$row['gru_id']] = array( "value" => $row['gru_id'],  "select" => "" ,"texto" => $row['gru_descripcion']);
                     if($this->primerGrupo == ''){ $this->primerGrupo=$row['gru_id']; }
                }
            }
        }  else {
            while($row = $resultset->fetch_assoc()) { 
                $list['lista_'.$row['gru_id']] = array( "value" => $row['gru_id'],  "select" => "" ,"texto" => $row['gru_descripcion']);
                if($this->primerGrupo == ''){ $this->primerGrupo=$row['gru_id']; }
            }
       }
        return $list;
    }
    
    
	
	public function getGruposForumSede($idForum) {
        $sql="call sp_selectGrupoKey('$idForum', '6')";
        return parent::getConsultar($sql);   
    }

    public function getGruposSede($idUser) {
        $sql="call sp_selectGrupoKey('$idUser', '7')";
        return parent::getConsultar($sql);   
    }

    public function getGruposAndForumLeaders($agrup = "") {
        $sql="call sp_selectGruposAndForumLeaders('$agrup')";
        return parent::getConsultar($sql);
    }

    public function getGruposAndForumLeadersByUser($idUser) {
        $sql="call sp_selectGruposAndForumLeadersByUser('$idUser')";
        return parent::getConsultar($sql);
    }

    public function getListaGruposAndForumLeaders() {
        $resultset = $this->getGruposAndForumLeaders();
        $lista = array();
        $i = 0;
        while ($row = $resultset->fetch_assoc()) {
            $lista[$i]['id'] = $row['gru_id'];
            $lista[$i]['nombre'] = $row['usu_user'];
            $i++;
        }
        return $lista;
    }

    public function getListaGruposAndForumLeadersByUser($idUser) {
        $resultset = $this->getGruposAndForumLeadersByUser($idUser);
        $lista = array();
        $i = 0;
        while ($row = $resultset->fetch_assoc()) {
            $lista[$i]['id'] = $row['gru_id'];
            $lista[$i]['nombre'] = $row['usu_user'];
            $i++;
        }
        return $lista;
    }
    
	
	 public function getListaGruposForum_by_Sede($idForum='', $idSeleccionado='',$list= array()) {  
         
        $resultset= $this->getGruposForumSede($idForum);
        if($idSeleccionado!=''){
            while($row = $resultset->fetch_assoc()) { 
                if($row['gru_id'] == $idSeleccionado){
                     $list['lista_'.$row['gru_id']] = array( "value" => $row['gru_id'],  "select" => "selected" ,"texto" => $row['gru_descripcion']);
                     if($this->primerGrupo == ''){ $this->primerGrupo=$row['gru_id']; }
                }else{
                     $list['lista_'.$row['gru_id']] = array( "value" => $row['gru_id'],  "select" => "" ,"texto" => $row['gru_descripcion']);
                     if($this->primerGrupo == ''){ $this->primerGrupo=$row['gru_id']; }
                }
            }
        }  else {
            while($row = $resultset->fetch_assoc()) { 
                $list['lista_'.$row['gru_id']] = array( "value" => $row['gru_id'],  "select" => "" ,"texto" => $row['gru_descripcion']);
                if($this->primerGrupo == ''){ $this->primerGrupo=$row['gru_id']; }
            }
       }
        return $list;
    }
    
    
    
    
    
     public function getMiembrosPorGrupo( $idGrupo, $key) {
        $sql="call sp_selectMiembrosxGrupo1('$idGrupo', $key)";
        return parent::getConsultar($sql);   
    }
    
     public function getGrupoForumLeaderCorreo( $idGrupo) {
        $sql="call sp_selectGrupoForumLeaderCorreo('$idGrupo')";
        return parent::getConsultar($sql);   
    }

}
