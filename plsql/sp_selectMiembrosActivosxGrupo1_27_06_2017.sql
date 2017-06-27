CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectMiembrosActivosxGrupo1`(IN `_id` INT(6), IN `_key` INT)
BEGIN

if _key = '1' then

    SELECT  
    miembro.mie_id,
    miembro.grupo_id,
    miembro.mie_codigo,
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
    (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id and BINARY cor_tipo='Personal' LIMIT 1) as 'correo',
    (SELECT  `tel_descripcion` FROM `telefono` WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil',
    (SELECT  concat (persona.per_nombre ,' ', persona.per_apellido) as 'nombre_forum'  
     FROM persona, perfil, usuario 
     WHERE usuario.usu_id= miembro.forum_usu_id 
     and usuario.Persona_per_id= persona.per_id and usuario.perfil_per_id= perfil.per_id LIMIT 1) as 'nombre_forum'

    FROM  miembro  
    INNER join persona on miembro.Persona_per_id = persona.per_id 
    where miembro.grupo_id= _id and miembro.cancelled = 0 
    ORDER BY nombre_forum;
end if;
if _key = '2' then

    SELECT  
    miembro.mie_id,
    (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id and BINARY cor_tipo='Personal' LIMIT 1) as 'correo',
    (SELECT  `tel_descripcion` FROM `telefono` WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil'
    FROM  miembro  
     INNER join persona on miembro.Persona_per_id = persona.per_id 
    where miembro.grupo_id in  (SELECT `gru_id` FROM `grupos` WHERE gru_forum = _id) 
    and miembro.cancelled = 0;
end if;
if _key = '3' then

    SELECT  
    miembro.mie_id,
    (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id and BINARY cor_tipo='Personal' LIMIT 1) as 'correo',
    (SELECT  `tel_descripcion` FROM `telefono` WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil'
    FROM  miembro  
     INNER join persona on miembro.Persona_per_id = persona.per_id 
    where miembro.grupo_id > 0 and miembro.cancelled = 0;
end if;

END;
