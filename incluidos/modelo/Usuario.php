<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Usuario
 *
 * @author Benito
 */
class Usuario extends Conexion{ 

    public function __construct(){
        parent:: __construct();        
    }

    public function getPersonaByForumLeader($idUser) {
        $sql = "call sp_selectPersonaByForumLeader('$idUser')";
        return parent::getConsultar($sql);
    }

    public function getForumLeaderByPersona($idPersona) {
        $sql = "call sp_selectForumLeaderByPersona('$idPersona')";
        return parent::getConsultar($sql);
    }
    function getNombreUser($id) {
        $resultset= $this->getUser($id, 'A');
        if ($row = $resultset->fetch_assoc()) { //usuario.usu_id , persona.per_nombre, persona.per_apellido
            return $row['per_nombre'].' '.$row['per_apellido'];
        }
    }
     public function getExisteUsuario($usuario) {
        $sql="call sp_selectExisteUsuario('$usuario')";
        return parent::getConsultar($sql);   
    }
    public function getGlobalExisteUsuario($usuario) {
        $bases= $_SESSION['databases'];
        $sql="call sp_globalSelectExisteUsuario('$usuario', '$bases')";
        return parent::getConsultar($sql);   
    }
    
     function getExisteUsuario_($usuario) {
        $resultset= $this->getGlobalExisteUsuario($usuario);
        if ($row = $resultset->fetch_assoc()){
            if($row['existe']=="0"){
                return "NO";
            }  else {
                return "SI";
            }
            
        }
    }
    
//    public function setGrabarUsuario($n, $a, $tipo,$ident, $fn, $genero, $user, $pass, $id_perfil, $estado, $id_user, $correo, $telefono, $celular,$salt, $sede) {
//        //$hash= password_hash($pass, PASSWORD_DEFAULT);
//        $fecha= date("Y-m-d H:i:s");
//        $sql="call sp_createUsuario('$n', '$a', '$tipo','$ident', '$fn' , "
//                . "'$genero' , '$user', '$pass', '$id_perfil','$fecha', '$estado', '$id_user', '$correo','$telefono','$celular', '$salt', '$sede')";  
//        $resultset= parent::getConsultar($sql);
//        if ($row = $resultset->fetch_assoc()) { 
//            return $row['_key'];  
//        }  
//    }
     public function setGrabarUsuario($n, $a, $tipo,$ident, $fn, $genero, $user, $pass, $id_perfil, $estado, $id_user, $correo = '', $telefono = '', $celular,$salt, $sede, $pais, $sede) {
        //$hash= password_hash($pass, PASSWORD_DEFAULT);
        $fecha= date("Y-m-d H:i:s");
        $bases= $_SESSION['databases'];
        $sql="call sp_globalCreateUsuario('$n', '$a', '$tipo','$ident', '$fn' , "
                . "'$genero' , '$user', '$pass', '$id_perfil','$fecha', '$estado',"
                . " '$id_user', '$correo','$telefono','$celular', '$salt', '$sede', '$bases', '$pais', '$sede')";  
        $resultset= parent::getConsultar($sql);
        if ($row = $resultset->fetch_assoc()) { 
            return $row['_key'];  
        }  
    }

    public function getCiudadByUsuario($idUsuario) {
        $sql = "call sp_selectCiudadByUsuario('$idUsuario')";
        return parent::getConsultar($sql);
    }

    public function getUsuarioByPersona($idPersona) {
        $sql ="call sp_selectUsuarioByPersona('$idPersona')";
        return parent::getConsultar($sql);
    }

    public function getDatosUsuario($idUsuario) {
        $sql = "call sp_selectDatosUsuario('$idUsuario')";
        return parent::getConsultar($sql);
    }

    public function setActualizarUsuario($id ,$n, $a, $tipo,$ident, $fn, $genero, $id_perfil, $estado, $id_user, $correo, $telefono, $celular, $sede, $pais) {
        $sql="call sp_updateUsuario('$id','$n', '$a', '$tipo','$ident', '$fn' , '$genero' , '$id_perfil', '$estado', '$id_user', '$correo', '$telefono','$celular', '$sede', '$pais')"; 
        return parent::setSqlSp($sql);        
    }

    public function setActualizarUsuario2($id ,$n, $a, $tipo,$ident, $fn, $genero, $id_perfil, $estado, $id_user, $correo, $telefono = '', $celular = '', $sede, $pais, $esposa, $hijos, $sede_id) {
        $sql="call sp_updateUsuario2('$id','$n', '$a', '$tipo','$ident', '$fn' , '$genero' , '$id_perfil', '$estado', '$id_user', '$correo', '$telefono','$celular', '$sede', '$pais','$esposa', '$hijos', '$sede_id')"; 
        return parent::setSqlSp($sql);
        
    }
    public function getUsuarios() {
        $sql="call sp_selectUsuario()";
        return parent::getConsultar($sql);   
    }

    public function getCredencialesUsuario($idUser) {
        $sql = "call sp_selectCredencialesUsuario('$idUser')";
        return parent::getConsultar($sql);
    }

    public function getUsuariosBySede($sede) {
        $sql="call sp_selectUsuarioBySede('$sede')";
        return parent::getConsultar($sql);   
    }
    
     public function getUser($id, $estado= '') {
        $sql="call sp_selectUsuario1('$id', '$estado')";
        return parent::getConsultar($sql);   
    }
    
//     public function setActualizarUserPassUsuario($idPerosna ,$user, $pass, $modificador,$salt) {
//        //$hash= password_hash($pass, PASSWORD_DEFAULT);
//        $sql="call sp_updateUsuarioPassUser('$idPerosna','$user', '$pass', '$modificador','$salt')"; 
//        $resultset= parent::getConsultar($sql);
//        if ($row = $resultset->fetch_assoc()) { 
//            return $row['_key'];  
//        }
//        
//    }
    
  public function setActualizarUserPassUsuario($idPerosna ,$user, $pass, $modificador,$salt) {
        //$hash= password_hash($pass, PASSWORD_DEFAULT);
        $sql="call sp_globalUpdateUsuarioPassUser('$idPerosna','$user', '$pass', '$modificador','$salt')"; 
        $resultset= parent::getConsultar($sql);
        if ($row = $resultset->fetch_assoc()) { 
            return $row['_key'];  
        }
        
    }
    public function getUsuarioLogin($usuario) {
      $sql="call sp_selectUsuarioLogin('$usuario')";
      return parent::getConsultar($sql);   
    }
   
     public function getRouterLogin($usuario) {
        $bases= $_SESSION['databases'];
        $sql="call sp_globalSelectRouterLogin('$usuario', '$bases')";
        return parent::getConsultar($sql);   
    }
}
