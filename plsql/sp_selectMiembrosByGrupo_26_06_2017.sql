CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectMiembrosByGrupo`(_id_grupo int(11))
BEGIN
select * from miembro inner join persona on (miembro.Persona_per_id = persona.per_id) 
where miembro.grupo_id = _id_grupo;
END;
