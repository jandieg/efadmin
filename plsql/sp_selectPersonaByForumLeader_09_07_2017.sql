CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectPersonaByForumLeader`(IN _id_usuario int(11))
BEGIN
select usuario.*, persona.* from usuario 
join persona on (usuario.Persona_per_id=persona.per_id)
where usuario.usu_id = _id_usuario;
END;
