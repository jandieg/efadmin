<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tarea
 *
 * @author Benito
 */
class Tarea extends Conexion{ 

    public function __construct(){
        parent:: __construct();       
    }

   
    public function setGrabarTareaProspecto($tipoGestion, $titular, $asunto, $fv, $estado ,$costo, $descripcion, $prioridad,$prospecto_miembro,
            $noti, $id_user) {
        $fecha= date("Y-m-d H:i:s");
        $sql="INSERT INTO gestionprospecto( tipogestion_id, gespro_responsable, gespro_asunto, gespro_fechavencimiento,gespro_fechafinalización, "
                . " gespro_notificacionporcorreo, gespro_costo, gespro_descripcion, "
                . "prospecto_pro_id,prioridad_prio_id, estado_tarea_est_tar_id,  gespro_fecharegistro, gespro_fechamodificacion, gespro_id_usuario,gespro_identificador_tabla) "
                . "VALUES ('$tipoGestion', '$id_user', '$asunto','$fv','$fv','$noti',  '$costo' , "
                . "'$descripcion' ,   '$prospecto_miembro', '$prioridad','$estado','$fecha','$fecha', '$id_user','1')";  
        return parent::setSqlSp($sql);
        
    }
    public function setGrabarTareaMiembro($tipoGestion, $titular, $asunto, $fv, $estado ,$costo, $descripcion, $prioridad,$prospecto_miembro,
            $noti, $id_user) {
        $fecha= date("Y-m-d H:i:s");
        $sql="INSERT INTO tarea_miembro(tipogestion_id, tarmie_responsable, tarmie_asunto, tarmie_fechavencimiento, tarmie_fechafinalización, "
                . "tarmie_notificacionporcorreo, tarmie_costo, tarmie_descripcion,  prioridad_prio_id, estado_tarea_est_tar_id, miembro_mie_id, "
                . "tarmie_fecharegistro, tarmie_fechamodificacion, tarmie_id_usuario,tarmie_identificador_tabla) VALUES "
                . "('$tipoGestion', '$id_user', '$asunto','$fv','$fv','$noti',  '$costo' , "
                . "'$descripcion', '$prioridad','$estado', '$prospecto_miembro','$fecha','$fecha', '$id_user','2')";  
        return parent::setSqlSp($sql);    
    }  
    public function getTareas() {
        $sql="call sp_selectAllTareas()";  
        return parent::getConsultar($sql);    
    }
    
    public function getTareaProspecto($id) {
        $sql="SELECT gespro_id as 'id_tarea', 
                tipogestion_id  as 'id_tipo_gestion',
                gespro_responsable as 'id_responsable',
                (SELECT Concat(persona.per_nombre,' ' ,persona.per_apellido) as 'Usuario' FROM usuario , persona WHERE usuario.Persona_per_id=persona.per_id and usuario.usu_id=gestionprospecto.gespro_responsable) as 'responsable',
                gespro_asunto as 'asunto', 
                gespro_fechavencimiento as 'fecha_vencimiento', 
                gespro_notificacionporcorreo as 'participacion_correo', 
                gespro_costo as 'costo', 
                gespro_descripcion as 'descripcion', 
                recordatorio_rec_id as 'recordatorio', 
                prospecto_pro_id as 'id_prospecto_miembro',
                ( SELECT  CONCAT( persona.per_nombre,' ', persona.per_apellido)  FROM  prospecto INNER join persona on prospecto.Persona_per_id = persona.per_id where  prospecto.pro_id=gestionprospecto.prospecto_pro_id ) as 'nombre_prospecto_miembro',  
                (SELECT (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id LIMIT 1)  
FROM  prospecto INNER join persona on prospecto.Persona_per_id = persona.per_id 
where  prospecto.pro_id=gestionprospecto.prospecto_pro_id ) as 'correo',

                prioridad_prio_id as 'id_prioridad',
                estado_tarea_est_tar_id as 'id_estado',
                `gespro_identificador_tabla` as 'tabla'
                FROM gestionprospecto WHERE gestionprospecto.gespro_id='$id'";  
        return parent::getConsultar($sql);   
    
    }
     public function getTareaMiembro($id) {
        $sql="SELECT tarmie_id as 'id_tarea', 
            tipogestion_id as 'id_tipo_gestion',
            tarmie_responsable as 'id_responsable',
            (SELECT Concat(persona.per_nombre,' ' ,persona.per_apellido) as 'Usuario' FROM usuario , persona WHERE usuario.Persona_per_id=persona.per_id and usuario.usu_id=tarea_miembro.tarmie_responsable) as 'responsable',
            tarmie_asunto as 'asunto',
            tarmie_fechavencimiento as 'fecha_vencimiento',  
            tarmie_notificacionporcorreo as 'participacion_correo', 
            tarmie_costo as 'costo',  
            tarmie_descripcion as 'descripcion',  
            recordatorio_rec_id as 'recordatorio',  
            miembro_mie_id as 'id_prospecto_miembro', 
            ( SELECT  CONCAT( persona.per_nombre,' ', persona.per_apellido)  FROM  miembro INNER join persona on  miembro.Persona_per_id = persona.per_id where  miembro.mie_id= tarea_miembro.miembro_mie_id  ) as 'nombre_prospecto_miembro',
            (SELECT  
            (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id LIMIT 1)  
             FROM  miembro INNER join persona on  miembro.Persona_per_id = persona.per_id 
             WHERE miembro.mie_id= tarea_miembro.miembro_mie_id ) as 'correo',            
            prioridad_prio_id as 'id_prioridad',
            estado_tarea_est_tar_id as 'id_estado',
            `tarmie_identificador_tabla`  as 'tabla'
            FROM tarea_miembro where tarmie_id='$id'";  
        return parent::getConsultar($sql);   
    
    }
    public function setActualizarTareaProspecto($idTarea, $tipoGestion,  $asunto, $fv, $estado ,$costo, $descripcion, $prioridad,$prospecto_miembro,
            $noti, $id_user) {
        $sql="UPDATE gestionprospecto SET tipogestion_id='$tipoGestion',gespro_asunto='$asunto',gespro_fechavencimiento='$fv',
            gespro_notificacionporcorreo='$noti',gespro_costo='$costo',gespro_descripcion='$descripcion',prospecto_pro_id='$prospecto_miembro',
            prioridad_prio_id='$prioridad',estado_tarea_est_tar_id='$estado',gespro_id_usuario='$id_user' WHERE gespro_id='$idTarea'";  
        return parent::setSqlSp($sql);    
    } 
     public function setActualizarTareaMiembro($idTarea, $tipoGestion,  $asunto, $fv, $estado ,$costo, $descripcion, $prioridad,$prospecto_miembro,
            $noti, $id_user) {
        $sql="UPDATE `tarea_miembro` SET `tipogestion_id`='$tipoGestion',`tarmie_asunto`='$asunto',`tarmie_fechavencimiento`='$fv',"
                . "`tarmie_notificacionporcorreo`='$noti',`tarmie_costo`='$costo',`tarmie_descripcion`='$descripcion',`prioridad_prio_id`='$prioridad',"
                . "`estado_tarea_est_tar_id`='$estado',`miembro_mie_id`='$prospecto_miembro',`tarmie_id_usuario`='$id_user' WHERE `tarmie_id`='$idTarea'";  
        return parent::setSqlSp($sql);    
    }
    
     public function getCalendarTareasMiembros($idMiembro) {
        $sql="call  sp_selectSmCalendarTareas('$idMiembro')";  
        return parent::getConsultar($sql);   
    
    }
    
    
    public function getJSONCalendarTareasMiembro($idMiembro){
        $resultset= $this->getCalendarTareasMiembros($idMiembro);
        $response = array();
        while ($row = $resultset->fetch_assoc()) { 

            array_push($response, $row);     
        } 
        return json_encode($response); 
    }
   
}
