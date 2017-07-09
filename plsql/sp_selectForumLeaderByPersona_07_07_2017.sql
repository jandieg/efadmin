CREATE DEFINER=`root`@`%` PROCEDURE `sp_selectForumLeaderByPersona`(IN _id_persona int(11))
BEGIN
select * from usuario where Persona_per_id = _id_persona;
END;
