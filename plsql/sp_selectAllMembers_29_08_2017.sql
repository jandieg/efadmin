CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectAllMembers`()
BEGIN
select * from miembro join persona on miembro.Persona_per_id= persona.per_id
and cancelled = 0
order by miembro.grupo_id, persona.per_nombre;
END;
