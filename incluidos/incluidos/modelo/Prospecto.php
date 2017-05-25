<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Prospecto
 *
 * @author PRUEBAS
 */
class Prospecto extends Conexion{ 
    private $objDesafios;
    private $objhobbies;

    public function __construct(){
        parent:: __construct();       
    }
   
    
      
 
    
      public function setGrabarProspecto($esmiembro, $propietario, $nombre, $apellido, $titulo, $correo ,$correo_2, $telefono, $celular,$participacion_correo, $fn,
              $fuente, $estado_propietario,$id_skype , $id_Twitter, $calle,$ciudad , $categoria,$identificacion,$genero,$tipo_p,$id_usuario, $listahobbies, $listaDesafios ,
             $status,$observacion, $codigo, $lafuente,$id_empresa) {
        $fecha= date("Y-m-d H:i:s");
        $sql="call sp_createProspecto('$esmiembro','$propietario', '$nombre', '$apellido','$titulo', '$correo' ,'$correo_2' ,"
                . " '$telefono','$celular', '$participacion_correo', '$fn', '$fuente','$estado_propietario','$id_skype','$id_Twitter','$calle','$ciudad',"
                . "'$categoria','$id_usuario','$identificacion','$genero','$tipo_p','$listahobbies','$listaDesafios','$status','$observacion','$fecha',"
                . "'$codigo', '$lafuente','$id_empresa')";  
        return parent::setSqlSp($sql);
    }
    
     public function setActualizarProspecto($id_prospecto, $id_persona, $propietario, $nombre, $apellido, $titulo, $correo ,$correo_2, $telefono, $celular,$participacion_correo, $fn,
              $fuente, $estado_propietario,$id_skype , $id_Twitter, $calle,$ciudad , $categoria,$identificacion,$genero,$tipo_p,$id_usuario, $listahobbies, $listaDesafios ,
             $status,$observacion,$codigo, $lafuente, $id_empresa) {
         $fecha= date("Y-m-d H:i:s");
        $sql="call sp_updateProspecto('$id_prospecto', '$id_persona','$propietario', '$nombre', '$apellido','$titulo', '$correo' ,'$correo_2' ,"
                . " '$telefono','$celular', '$participacion_correo', '$fn', '$fuente','$estado_propietario','$id_skype','$id_Twitter','$calle','$ciudad',"
                . "'$categoria','$id_usuario','$identificacion','$genero','$tipo_p','$listahobbies','$listaDesafios','$status','$observacion','$fecha',"
                . "'$codigo', '$lafuente','$id_empresa')";  
        return parent::setSqlSp($sql);
        
    }


    
    public function getListaDetalleDesafios($id) {
        $sql="call sp_selectProspectoDesafios('$id')";
        return parent::getConsultar($sql);   
    }  

     public function setAplicanteConvertir( $id_prospecto= '',  $id_user= '', $grupo= '', $membresia= '', $status= '') {
        $fecha= date("Y-m-d H:i:s");
        $sql="call sp_updateAplicanteConvertir('$id_prospecto','$fecha','$id_user', '$status', '$membresia', '$status')";
        // IN _id_prospecto INT, IN _fecharegistro TIMESTAMP, IN _usuario INT, IN _grupo INT, IN _membresia INT,  IN _status INT)
        return parent::setSqlSp($sql);   
    }

//******************************************************************************
    
    public function getProspectosFiltros($id, $key,$esaplicante) {
        $sql="call sp_selectProspectoFiltros('$id', '$key', '$esaplicante')";
        return parent::getConsultar($sql);   
    }
    public function getProspecto($id) {
        $sql="call sp_selectProspecto1('$id')";
        return parent::getConsultar($sql);   
    }
    
    public function getDesafios($id, $tabla_desafios= array()) {
        global $lblDesafios;
        $resultset_desafios = $this->getListaDetalleDesafios($id);     
        $con=2;
        while ($row_desafios = $resultset_desafios->fetch_assoc()) {
            if($con==2){
                $tabla_desafios['b_'.$con] = array("t_1" =>generadorNegritas($lblDesafios) , "t_2" => $row_desafios['des_descripcion']);
            }  else {
                $tabla_desafios['b_'.$con] = array("t_1" =>"" ,                "t_2" => $row_desafios['des_descripcion']);
            }

            $con=$con+1;
        } 
        return $tabla_desafios;   
    }
    public function getMiembroHobbies($id) {
        $sql="call sp_selectProspectoHobbies1('$id')";
        return parent::getConsultar($sql);   
    }
    
    function getListaDetalleHobbies($id) {
        global $lblHobbies;
        $resultset_hobbies= $this->getMiembroHobbies($id);     
        $tabla_hobbies= array();
        $con=1;
        while ($row_hobbies = $resultset_hobbies->fetch_assoc()) {
            if($con==1){
                $tabla_hobbies['b_'.$con] = array("t_1" =>  generadorNegritas($lblHobbies)  ,"t_2" => $row_hobbies['hob_descripcion']);
            }  else {
                $tabla_hobbies['b_'.$con] = array("t_1" => ""                               ,"t_2" => $row_hobbies['hob_descripcion']);
            }

            $con=$con+1;
        } 
        return $tabla_hobbies;
    }
    
    public function getDesafioSeleccionado($id) {
        $sql="SELECT  `desafio_des_id` FROM `prospecto_desafio` WHERE prospecto_pro_id='$id'";
        return parent::getConsultar($sql);   
    }
    
      function getMultiListaDesafios($id) {
        $resultset_desafio_selecionadas= $this->getDesafioSeleccionado($id); 
        $lista_desafio_selecionadas=array();
        while ($row_desafio_selecionada = $resultset_desafio_selecionadas->fetch_assoc()) { 
            $lista_desafio_selecionadas[$row_desafio_selecionada['desafio_des_id']]=$row_desafio_selecionada['desafio_des_id'];        
       
         }    
        $this->objDesafios= new Desafio();
        $resultset_desafio=  $this->objDesafios->getDesafio(); 
        $listadesafio=array();
        $bandera=FALSE;
        while ($row_desafio = $resultset_desafio->fetch_assoc()) { 
             foreach ($lista_desafio_selecionadas as $val){
            if($row_desafio['des_id']==$val){
                        $bandera=TRUE;
             }
        }                         
            if($bandera){
               $listadesafio['lista_'.$row_desafio['des_id']] = array("value" => $row_desafio['des_id'],  "select" => "selected" ,"texto" => $row_desafio['des_descripcion']);   
       
            }  else {
                $listadesafio['lista_'.$row_desafio['des_id']] = array("value" => $row_desafio['des_id'],  "select" => "" ,"texto" => $row_desafio['des_descripcion']);
     
            }
            $bandera=FALSE;
            
            
       } 
       return $listadesafio;
    }
    
     public function getHobbySeleccionado($id) {
        $sql="SELECT  `hobbies_hob_id` FROM `prospecto_hobbies` WHERE prospecto_pro_id = '$id'";
        return parent::getConsultar($sql);   
    }
    
     function getMultiListaHobbies($id) {
  
        $resultset_hobby_selecionadas= $this->getHobbySeleccionado($id); 
        $lista_hobby_selecionadas=array();
        while ($row_hobby_selecionada = $resultset_hobby_selecionadas->fetch_assoc()) { 
            $lista_hobby_selecionadas[$row_hobby_selecionada['hobbies_hob_id']]=$row_hobby_selecionada['hobbies_hob_id'];        
       
        }
        $this->objhobbies= new Hobby();
        $resultset_hobby= $this->objhobbies->getHobby();
        $listahobby=array();
        $bandera=FALSE;
        while ($row_hobby = $resultset_hobby->fetch_assoc()) { 
            foreach ($lista_hobby_selecionadas as $val){
                if($row_hobby['hob_id']==$val){
                    $bandera=TRUE;
                }
            }                         
            if($bandera){
               $listahobby['lista_'.$row_hobby['hob_id']] = array("value" => $row_hobby['hob_id'],  "select" => "selected" ,"texto" => $row_hobby['hob_descripcion']);   
            }  else {
                $listahobby['lista_'.$row_hobby['hob_id']] = array("value" => $row_hobby['hob_id'],  "select" => "" ,"texto" => $row_hobby['hob_descripcion']);


            }
            $bandera=FALSE;       
       }
       return $listahobby;  
    }
   
    public function setAprobarProspecto($idCan, $modificador) {
        $sql="call sp_updateProspectoAprobar('$idCan','$modificador')";  
        return parent::setSqlSp($sql);
        
    }

    public function setConvertirProspecto($idCan, $_id_user_forum, $id_user ) {
        $fecha= date("Y-m-d H:i:s");
        $sql="call sp_updateProspectoConvertir('$idCan','$fecha', '$id_user','$_id_user_forum')";  
        return parent::setSqlSp($sql);
       
    }
}