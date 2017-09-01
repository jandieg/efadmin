CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectMiembros2`(IN _id_user int)
BEGIN

SELECT  
                miembro.mie_id,
                miembro.grupo_id,
                miembro.mie_codigo,
                miembro.precio_esp,
                miembro.prospecto_pro_id as 'id_prospecto',
                miembro.empresalocal_emp_id,
                (SELECT `emp_nombre` FROM `empresalocal` WHERE emp_id = miembro.empresalocal_emp_id) as 'nombre_empresa',
                miembro.mie_fechamodificacion, 
                miembro.mie_fecharegistro, 
                miembro.mie_id_usuario, 
                miembro.mie_descripcion_desafio,
                miembro.mie_participacion_correo,               
                miembro.Profesion_prof_id,
                miembro.categoria_cat_id, 
                persona.per_id ,  
                persona.per_nombre, 
                persona.per_apellido, 
                (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id LIMIT 1) as 'correo',
                (SELECT  `tel_descripcion` FROM `telefono` WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil',
                (SELECT  concat (persona.per_nombre ,' ', persona.per_apellido) as 'nombre_forum'  
                 FROM persona, perfil, usuario  
                 WHERE usuario.usu_id= miembro.forum_usu_id 
                 and usuario.Persona_per_id= persona.per_id and usuario.perfil_per_id= perfil.per_id LIMIT 1) as 'nombre_forum'
                 
                FROM  miembro  
                INNER join persona on miembro.Persona_per_id = persona.per_id 
                inner join grupos on grupos.gru_id = miembro.grupo_id 
                where grupos.sede_id = (select sede_id from usuario where usu_id = _id_user)
                ORDER BY nombre_forum;
END;
