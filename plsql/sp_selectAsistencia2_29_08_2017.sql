CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectAsistencia2`(IN `_id_grupo` INT, IN `_f_i` TIMESTAMP, IN `_f_f` TIMESTAMP)
BEGIN

    SELECT 
    concat(persona.per_apellido,' ', persona.per_nombre) as 'nombre',  
     evento.eve_id,
     evento.eve_nombre,
     evento.eve_fechainicio,
     evento.eve_fechafin,
     evento.eve_descripcion,
     evento.eve_responsable,
	(SELECT  `dir_calleprincipal` FROM `direccion` WHERE dir_id= evento.direccion_id) as 'direccion',
     asistencia.asis_id,
     asistencia.asis_estado,
     asistencia.asis_tipo,
     asistencia.evento_eve_id,
     asistencia.miembro_mie_id,
     asistencia.participante_part_id,
     asistencia.asis_id_usuario,
     asistencia.asis_fecharegistro,
     asistencia.asis_fechamodificacion,
     miembro.mie_fecharegistro 
    FROM asistencia  , evento, miembro
    INNER join persona on miembro.Persona_per_id = persona.per_id
    WHERE 
    miembro.grupo_id= _id_grupo 
    and miembro.cancelled = 0 
    and miembro.mie_id = asistencia.miembro_mie_id
    and evento.eve_id = asistencia.evento_eve_id  
    and (evento.eve_fechainicio between _f_i and _f_f) 
    and ( evento.eve_fechafin between _f_i and _f_f) 
    ORDER by  trim(nombre), eve_fechafin;

END;
