CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectUsuario1`(IN `_id` INT, IN `_estado` VARCHAR(200))
BEGIN
	 if _estado = '' then 
        SELECT persona.per_id, persona.per_nombre, persona.per_apellido, persona.per_tipo, persona.per_identificacion, persona.per_fechanacimiento,  
        case persona.per_genero
            when 'M' then 'MASCULINO'
            when 'f' then 'FEMENINO'
            end per_genero ,
        usuario.usu_id, usuario.usu_user, usuario.usu_pass, usuario.perfil_per_id, usuario.usu_fecharegistro, usuario.usu_fechamodificacion,  usuario.usu_estado
        ,usuario.sede_id,usuario.pais_id
        , usuario.Persona_per_id 
        , persona.per_hijos
        , persona.per_esposa
        ,(SELECT  cor_descripcion  FROM correo WHERE Persona_per_id=persona.per_id LIMIT 1) as 'correo'
        ,(SELECT  tel_descripcion FROM telefono WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil'
        ,(SELECT  tel_descripcion FROM telefono WHERE Persona_per_id=persona.per_id and tel_tipo= 'C' LIMIT 1 ) as 'fijo'
        ,perfil.per_id as 'perfil_id', perfil.per_descripcion as 'perfil_des', perfil.per_estado as 'perfil_estado', perfil.per_fecharegistro, perfil.per_fechamodificacion, perfil.per_id_usuario 
        ,(SELECT  concat(persona.per_nombre, ' ' , persona.per_apellido) as 'nombre' FROM usuario u, persona WHERE u.usu_id= usuario.per_id_usuario and u.Persona_per_id = persona.per_id) as 'modificador'
     
        FROM usuario 
        join perfil on usuario.perfil_per_id = perfil.per_id
        join persona on usuario.Persona_per_id  = persona.per_id
        WHERE usuario.usu_id=_id  and perfil.per_estado='A';

    else

        SELECT persona.per_id, persona.per_nombre, persona.per_apellido, persona.per_tipo, persona.per_identificacion, persona.per_fechanacimiento,  
        case persona.per_genero
            when 'M' then 'MASCULINO'
            when 'f' then 'FEMENINO'
            end per_genero ,
        usuario.usu_id, usuario.usu_user, usuario.usu_pass, usuario.perfil_per_id, usuario.usu_fecharegistro, usuario.usu_fechamodificacion,  usuario.usu_estado
        ,usuario.sede_id,usuario.pais_id
        , persona.per_hijos
        , persona.per_esposa
        , usuario.Persona_per_id 
        ,(SELECT  cor_descripcion  FROM correo WHERE Persona_per_id=persona.per_id LIMIT 1) as 'correo'
        ,(SELECT  tel_descripcion FROM telefono WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil'
        ,(SELECT  tel_descripcion FROM telefono WHERE Persona_per_id=persona.per_id and tel_tipo= 'C' LIMIT 1 ) as 'fijo'
        ,perfil.per_id as 'perfil_id', perfil.per_descripcion as 'perfil_des', perfil.per_estado as 'perfil_estado', perfil.per_fecharegistro, perfil.per_fechamodificacion, perfil.per_id_usuario 
        ,(SELECT  concat(persona.per_nombre, ' ' , persona.per_apellido) as 'nombre' FROM usuario u, persona WHERE u.usu_id= usuario.per_id_usuario and u.Persona_per_id = persona.per_id) as 'modificador'

        FROM usuario 
        join perfil on usuario.perfil_per_id = perfil.per_id
        join persona on usuario.Persona_per_id  = persona.per_id
        WHERE usuario.usu_id=_id   and perfil.per_estado='A' and binary usuario.usu_estado = _estado;


    end if;
END;
