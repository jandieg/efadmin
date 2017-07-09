CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectGrupoByForumLeaderPersona`(_id_persona int(11))
BEGIN
select * from grupos where gru_forum = (select usu_id from usuario where Persona_per_id = _id_persona);
END;
