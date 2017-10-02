CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectUsuarioBySede`(IN _sede INT)
BEGIN



SELECT persona.per_id, 
    persona.per_nombre, 
    persona.per_apellido, 
    persona.per_tipo, 
    persona.per_identificacion, 
    usuario.usu_id, usuario.usu_user,
    usuario.perfil_per_id, 
    usuario.usu_fecharegistro, usuario.usu_fechamodificacion, case usuario.usu_estado
                when 'A' then 'ACTIVO'
                when 'I' then 'INACTIVO'
        end usu_estado 
    ,(SELECT  cor_descripcion  FROM correo WHERE Persona_per_id=persona.per_id LIMIT 1) as 'correo'
    , (SELECT  tel_descripcion FROM telefono WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil'
    , perfil.per_descripcion as 'perfil_des'
    FROM usuario 

    join perfil on usuario.perfil_per_id = perfil.per_id
    join persona on usuario.Persona_per_id  = persona.per_id
    WHERE 
    usuario.sede_id = _sede and
     perfil.per_estado='A'
    and perfil.per_id not in 
    (SELECT `perfil_per_id` FROM `rol_sistema` WHERE permiso_sistema_pso_id='5' and rol_estado='A');
END;
