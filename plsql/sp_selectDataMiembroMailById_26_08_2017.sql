CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectDataMiembroMailById`(_id_miembro int(11))
BEGIN
        select persona.per_nombre, persona.per_apellido, miembro.mie_codigo,
        grupos.gru_descripcion, 
        (select concat(persona.per_nombre, ' ', persona.per_apellido) 
        from persona join usuario on (persona.per_id = usuario.Persona_per_id) 
        where usuario.usu_id = grupos.gru_forum) as 'forum_leader',
        (select correo.cor_descripcion  
        from persona join usuario on (persona.per_id = usuario.Persona_per_id) 
        join correo on (persona.per_id = correo.Persona_per_id)
        where usuario.usu_id = grupos.gru_forum) as 'mail_forum_leader',
        (select correo.cor_descripcion  
        from persona join usuario on (persona.per_id = usuario.Persona_per_id) 
        join correo on (persona.per_id = correo.Persona_per_id)
        where usuario.sede_id = grupos.sede_id and usuario.perfil_per_id=19 limit 1) as 'mail_asistente',
        correo.cor_descripcion 
        from miembro join persona on (miembro.Persona_per_id = persona.per_id)
        join correo on (correo.Persona_per_id = persona.per_id)
        join grupos on (grupos.gru_id = miembro.grupo_id)
        where miembro.mie_id = _id_miembro
        limit 1;
END;
