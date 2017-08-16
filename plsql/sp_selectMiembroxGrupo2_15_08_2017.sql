CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectMiembroxGrupo2`(_id_grupo int(11))
BEGIN
select miembro.*, persona.per_nombre, persona.per_apellido from miembro 
join persona  
where miembro.grupo_id = _id_grupo and miembro.cancelled = 0 and 
persona.per_id=miembro.Persona_per_id;
END;
