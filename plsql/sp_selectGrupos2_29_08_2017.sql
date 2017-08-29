CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectGrupos2`(IN _id_user INT)
BEGIN
    SELECT grupos.gru_id, grupos.gru_descripcion, grupos.gru_estado, grupos.gru_forum , 
        grupos.gru_fecharegistro, grupos.gru_fechamodificacion,
            (SELECT Concat(persona.per_nombre,' ' ,persona.per_apellido) as 'Usuario Modificador' 
            FROM usuario , persona WHERE usuario.Persona_per_id=persona.per_id and usuario.usu_id=grupos.gru_id_usuario) as 'modificador' ,
        persona.per_id, persona.per_nombre, persona.per_apellido, 
        usuario.Persona_per_id 
    FROM grupos, usuario 
        join perfil on usuario.perfil_per_id = perfil.per_id
        join persona on usuario.Persona_per_id  = persona.per_id
    WHERE  usuario.usu_estado = 'A' and usuario.usu_estado='A' and perfil.per_estado='A' and
        grupos.gru_forum= usuario.usu_id
        and usuario.sede_id = (select sede_id from usuario where usu_id = _id_user);
END;