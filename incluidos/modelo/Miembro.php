<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Miembro
 *
 * @author PRUEBAS
 */
class Miembro extends Conexion{ 
    private $objDesafios;
    private $objhobbies;
    
    public function __construct(){
        parent:: __construct();       
    }
    
    public function getMiembros1() {
        $sql="call sp_selectMiembros1()";
        return parent::getConsultar($sql);   
    }
    public function getForumMiembros1($idForum) {
        $sql="call sp_selectForumMiembros1('$idForum')";
        return parent::getConsultar($sql);   
    }
    public function getMiembro1($id) {
        $sql="call sp_selectMiembro1('$id')";
        return parent::getConsultar($sql);   
    }
	public function getMiembro2($id) {
        $sql="call sp_selectMiembro2('$id')";
        return parent::getConsultar($sql);   
    }
    
    public function getMiembroDesafios($id) {
        $sql="call sp_selectMiembroDesafio('$id')";
        return parent::getConsultar($sql);   
    } 
     public function getDesafioMiembroSeleccionado($id) {
        $sql="call sp_selectMiembroDesafioID('$id')";
        return parent::getConsultar($sql);   
    }
    
     function getMultiListaDesafiosMiembros($idMiembros) {
        $resultset_desafio_selecionadas= $this->getDesafioMiembroSeleccionado($idMiembros); 
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
        $sql="call sp_selectMiembroHobbiesID('$id')";
        return parent::getConsultar($sql);   
    }
    
     function getMultiListaHobbies($idMiembro) {
  
        $resultset_hobby_selecionadas= $this->getHobbySeleccionado($idMiembro); 
        $lista_hobby_selecionadas=array();
        while ($row_hobby_selecionada = $resultset_hobby_selecionadas->fetch_assoc()) { 
            $lista_hobby_selecionadas[$row_hobby_selecionada['hobbies_hob_id']]=$row_hobby_selecionada['hobbies_hob_id'];        
       
        }
        $this->objhobbies= new Hobby();
        $resultset_hobby= $this->objhobbies->getHobby(); //mie_hob_id
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
    
    
    
    
    
    

public function setActualizarMiembro($idMiembro, $id_persona, $propietario, $nombre, $apellido, $titulo, $correo,
        $correo_2, $telefono, $celular,$participacion_correo, $fn, $id_skype , $id_Twitter, $calle,$ciudad ,
        $categoria , $desafios,$identificacion,$genero,$tipo_p, $listaHobbies, $listaDesafios ,
        $id_grupo,$codigo, $id_usuario, $idMembresia , $status, $modificadoglobal, $observacion, $empresa, $precio_esp) {
        $fecha= date("Y-m-d H:i:s");
        $sql="call sp_updateMiembro1('$idMiembro', '$id_persona','$propietario', '$nombre', '$apellido','$titulo',"
                . "'$correo' ,'$correo_2' , '$telefono','$celular', '$participacion_correo', '$fn',"
                . "'$id_skype','$id_Twitter','$calle','$ciudad','$categoria','$desafios','$identificacion','$genero',"
                . "'$tipo_p','$listaHobbies','$listaDesafios','$id_grupo','$codigo','$id_usuario','$fecha',"
                . " '$idMembresia','$status', '$modificadoglobal', '$observacion','$empresa','$precio_esp')";  
        return parent::setSqlSp($sql);
        
    }
  
    
      public function getMiembroHobbies($id) {
        $sql="call sp_selectMiembroHobbies('$id')";
        return parent::getConsultar($sql);   
    }
    
  

    
    
    public function getMiembroGrupo($idMiembroGrupo) {
        $sql="call sp_selectMiembroSuGrupo('$idMiembroGrupo')";
        return parent::getConsultar($sql);   
    }
    function getNombreGrupo($idMiembroGrupo) {
        $resultset= $this->getMiembroGrupo($idMiembroGrupo); 
        $nombreGrupo='';
        if ($row = $resultset->fetch_assoc()) { //usuario.usu_id , persona.per_nombre, persona.per_apellido
           $nombreGrupo=$row['gru_descripcion'];

        }
        return $nombreGrupo;
    }
    
    public function getMiembrosCorreoMovil($idMiembro) {
        $sql="call sp_selectMiembrosCorreoMovil1('$idMiembro')";
        return parent::getConsultar($sql);   
    }
     public function getMiembrosCorreoMovilxTodosxForum($id) {
        $sql="call sp_selectMiembroCorreos('$id')";
        return parent::getConsultar($sql);   
    }
    
    
    
//    function x($a1,$a2,$a3,$a4,$a5,$a6 ) {
//        $sql="UPDATE `miembro` SET 
//            `Persona_per_id`='$a1',
//            `categoria_cat_id`='$a2',
//            `forum_usu_id`='$a3',
//            `Profesion_prof_id`='$a4',
//            `mie_participacion_correo`='$a5' 
//            WHERE `prospecto_pro_id`='$a6'";
//        return parent::setSqlSp($sql);   
//    }
//    
//    
//    public function x2() {
//        $sql="SELECT `pro_id`,  `Persona_per_id`,participacion_correo, `forum_usu_id`, `categoria_cat_id`, `Profesion_prof_id` FROM `prospecto`";
//        return parent::setSqlSentence($sql);   
//    }
//    
//     public function getx() {
//        $sql="SELECT `pro_id`,  `Persona_per_id`,participacion_correo, `forum_usu_id`, `categoria_cat_id`, `Profesion_prof_id` FROM `prospecto`";
//        return parent::getConsultar($sql);   
//    } 
    
    
    
    
    public function getFiltros($id, $key, $permiso, $incluyecanceladas) {
        $sql="call sp_selectMiembroFiltros('$id','$key', '$permiso', '$incluyecanceladas')";
        return parent::getConsultar($sql);   
    }

    public function getMiembrosByGrupo($idGrupo) {
        $sql = "call sp_selectMiembrosByGrupo('$idGrupo');";
        return parent::getConsultar($sql);
    }

    public function getListaMiembrosByGrupo($lista = array(), $idGrupo) {
        $resultset = $this->getMiembrosByGrupo($idGrupo);
         while ($row = $resultset->fetch_assoc()) { 
            $lista['lista_'.$row['mie_id']] = array("value" => $row['mie_id'],  "select" => "" ,"texto" => $row['per_nombre']." ".$row['per_apellido']);
        }
        return $lista;
    }

    public function getMiembrosByEmpresa($idEmpresa) {
        $sql = "call sp_selectMiembrosByEmpresa('$idEmpresa');";
        return parent::getConsultar($sql);
    }

    public function getListaMiembrosByEmpresa($lista = array(), $idEmpresa) {
        $resultset = $this->getMiembrosByEmpresa($idEmpresa);
         while ($row = $resultset->fetch_assoc()) { 
            $lista['lista_'.$row['mie_id']] = array("value" => $row['mie_id'],  "select" => "" ,"texto" => $row['per_nombre']." ".$row['per_apellido']);
        }
        return $lista;
    }
    
    public function getListaMiembros($idSeleccionado='', $lista= array(),$id_forum="", $is_todos_seleccionado= FALSE) {   
        if($id_forum == ""){
            $resultset= $this->getMiembros1(); 
        }else{
            $resultset= $this->getForumMiembros1($id_forum); 
        }
        
        
        if($is_todos_seleccionado == FALSE){
            if($idSeleccionado!=''){
                while ($row = $resultset->fetch_assoc()) {
                    if($row['mie_id'] == $idSeleccionado){
                        $lista['lista_'.$row['mie_id']] = array("value" => $row['mie_id'],  "select" => "selected" ,"texto" => $row['per_nombre']." ".$row['per_apellido']);

                    }else{
                        $lista['lista_'.$row['mie_id']] = array("value" => $row['mie_id'],  "select" => "" ,"texto" => $row['per_nombre']." ".$row['per_apellido']);
                    }

                }
            }  else {
               while ($row = $resultset->fetch_assoc()) { 
                    $lista['lista_'.$row['mie_id']] = array("value" => $row['mie_id'],  "select" => "" ,"texto" => $row['per_nombre']." ".$row['per_apellido']);
               }
            }
        }else{
            while ($row = $resultset->fetch_assoc()) { 
                    $lista['lista_'.$row['mie_id']] = array("value" => $row['mie_id'],  "select" => "selected" ,"texto" => $row['per_nombre']." ".$row['per_apellido']);
            }
        }
        return $lista;
    }
     
    public function getPresupuesto($id, $year) {
        $sql="call sp_selectMiembroPresupuesto('$id','$year')";
        return parent::getConsultar($sql);   
    }
     public function setMiembroUserPass( $id_persona, $user, $pass, $modificador, $salt) {
        $fecha= date("Y-m-d H:i:s");
        $sql="call sp_globalUpdateMiembroUserPass('$id_persona', '$user', '$pass', '$modificador', '$salt','$fecha')";  
         $resultset= parent::getConsultar($sql);
        if ($row = $resultset->fetch_assoc()) { 
            return $row['_key'];  
        }
        
    }
    
//    public function setMiembroUserPass( $id_persona, $user, $pass, $modificador, $salt) {
//        $fecha= date("Y-m-d H:i:s");
//        $sql="call sp_updateMiembroUserPass('$id_persona', '$user', '$pass', '$modificador', '$salt','$fecha')";  
//         $resultset= parent::getConsultar($sql);
//        if ($row = $resultset->fetch_assoc()) { 
//            return $row['_key'];  
//        }
//        
//    }
    public function getEstadoCuenta($id, $year, $estado) {
        $sql="call sp_selectMiembroEstadoCuenta('$id','$year','$estado')";
        return parent::getConsultar($sql);   
    }
    public function getEmcabezadoEstadoCuenta($id, $year) {
        $sql="call sp_selectMiembroDatosEstadoCuenta('$id','$year')";
        return parent::getConsultar($sql);   
    }
    //sp_selectMiembroEventosCalendarioForum
     public function getMisEventos($id) {
        $sql="call sp_selectMiembroEventosCalendarioForum('$id')";  
        return parent::getConsultar($sql);

    }
      
    public function getJSONEventosCalendar($id){
        $resultset= $this->getMisEventos($id);
        $response = array();
        while ($row = $resultset->fetch_assoc()) { 

            array_push($response, $row);     
        } 
        return json_encode($response); 
    }
     public function getCorreosMiGrupo($id) {
        $sql="call sp_selectMiembroCorreosMiGrupo('$id')";  
        return parent::getConsultar($sql);

    }
    
     public function getSmAgregarDatos($id , $key) {
        $sql="call sp_selectSmAgregarDatos('$id', '$key')";  
        return parent::getConsultar($sql);

    }
    
     public function getMiembroIdWithIdUser($user) {
        $sql="call sp_selectMiembroIdWithIdUser( '$user')";  
         $resultset= parent::getConsultar($sql);
        if ($row = $resultset->fetch_assoc()) { 
            return $row['mie_id'];  
        }
        
    }
    
     public function gettMiembroActualizarUserPassCorreos($id) {
        $sql="call sp_selectMiembroActualizarUserPassCorreos('$id')";
        return parent::getConsultar($sql);   
    }
    
    function getDetalleDesafios($idMiembro, $tabla_desafios=array()) {
    global $lblDesafios;
    $resultset_desafios= $this->getMiembroDesafios($idMiembro);     
    $con=1;

    while ($row_desafios = $resultset_desafios->fetch_assoc()) {
        if($con==1){
            $tabla_desafios['b_'.$con] = array("t_1" =>generadorNegritas($lblDesafios) , "t_2" => $row_desafios['des_descripcion']);
        }  else {
            $tabla_desafios['b_'.$con] = array("t_1" =>"" ,                "t_2" => $row_desafios['des_descripcion']);
        }

        $con=$con+1;
    } 
    return $tabla_desafios;
}
function getDetalleHobbies($idMiembro) {
    global $lblHobbies;
    $resultset_hobbies= $this->getMiembroHobbies($idMiembro);     
    $tabla_hobbies= array();
    $con=1;
    while ($row_hobbies = $resultset_hobbies->fetch_assoc()) {
        if($con==1){
            $tabla_hobbies['b_'.$con] = array("t_1" =>  generadorNegritas($lblHobbies) , "t_2" => $row_hobbies['hob_descripcion']);
        }  else {
            $tabla_hobbies['b_'.$con] = array("t_1" =>"" ,                "t_2" => $row_hobbies['hob_descripcion']);
        }

        $con=$con+1;
    } 
    return $tabla_hobbies;
}

}