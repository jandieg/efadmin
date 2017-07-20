CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectMiembro1`(IN `_id_miembro` INT)
BEGIN
SELECT 
miembro.mie_observacion,
(SELECT  `usu_user` FROM `usuario` WHERE Persona_per_id=persona.per_id  ) as 'user',
persona.per_id ,  
persona.per_nombre, 
persona.per_apellido, 
persona.per_tipo, 
case persona.per_tipo
        when 'J' then 'Jurídica'
        when 'N' then 'Natural'
end persona_tipo,


persona.per_identificacion, 
persona.per_fechanacimiento,  
case persona.per_genero
        when 'M' then 'MASCULINO'
        when 'f' then 'FEMENINO'
end per_genero,
miembro.mie_id,
miembro.grupo_id,
miembro.mie_codigo,
miembro.cancelled,
miembro.mie_fecha_cambio_status,
miembro.precio_esp,
miembro.prospecto_pro_id as 'id_prospecto',
miembro.mie_fechamodificacion, 
miembro.mie_fecharegistro, 
miembro.mie_id_usuario, 
miembro.mie_descripcion_desafio,
miembro.mie_participacion_correo,               
miembro.Profesion_prof_id,
miembro.membresia_id,
miembro.status_member_id,
miembro.modificado_global,
(SELECT concat(`mem_sta_codigo`, ' - ',`mem_sta_descripcion`) as 'status' FROM `member_status` WHERE mem_sta_id = miembro.status_member_id) as 'status',
(SELECT  `memb_descripcion` FROM `membresia` WHERE membresia.memb_id= miembro.membresia_id) as 'memb_descripcion',
profesion.prof_descripcion, 
miembro.categoria_cat_id,
categoria.cat_descripcion,
miembro.forum_usu_id,
(SELECT  concat (persona.per_nombre ,' ', persona.per_apellido) 
                 FROM persona, perfil, usuario 
                 WHERE usuario.usu_id= miembro.forum_usu_id 
                 and usuario.Persona_per_id= persona.per_id and 						usuario.perfil_per_id= perfil.per_id LIMIT 1) 
                as 'nombre_forum',
(SELECT `mie_ins_id` FROM `miembro_inscripcion` WHERE miembro_id=miembro.mie_id) as 'inscripcion',
(SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id and cor_tipo = 'Personal' LIMIT 1) as 'correo',
        (SELECT  `tel_descripcion` FROM `telefono` WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil',
        (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id and cor_tipo = 'Secundario' LIMIT 1) as 'correo2',
        (SELECT  `tel_descripcion` FROM `telefono` WHERE Persona_per_id=persona.per_id and tel_tipo= 'C' LIMIT 1 ) as 'movil2',
        (SELECT  redmi_descripcion  FROM redsocial_miembro WHERE Binary redmi_tipo= 'skype' and miembro_mie_id= miembro.mie_id LIMIT 1) as 'skype',
        (SELECT  redmi_descripcion  FROM redsocial_miembro WHERE Binary redmi_tipo= 'twitter' and miembro_mie_id= miembro.mie_id  LIMIT 1) as 'twitter',
        grupos.gru_descripcion,
grupos.gru_nombre,
          (SELECT concat( persona.per_nombre,' ', persona.per_apellido)  FROM usuario join persona on usuario.Persona_per_id  = persona.per_id WHERE usuario.usu_id= miembro.mie_id_usuario and usuario.usu_estado = 'A') as 'modificador',
empresalocal.emp_id, 
empresalocal.emp_nombre, 
empresalocal.emp_ruc, 
empresalocal.emp_imgresos, 
empresalocal.emp_num_empleados, 
empresalocal.emp_fax, 
empresalocal.emp_sitio_web 
FROM miembro  
INNER join persona on miembro.Persona_per_id = persona.per_id
INNER join categoria on miembro.categoria_cat_id = categoria.cat_id
INNER join profesion on miembro.Profesion_prof_id = profesion.prof_id 
INNER join grupos on miembro.grupo_id = grupos.gru_id
Left join empresalocal on miembro.empresalocal_emp_id = empresalocal.emp_id 
where miembro.mie_id= _id_miembro;
END;
