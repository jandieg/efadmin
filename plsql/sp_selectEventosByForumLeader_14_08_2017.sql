CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectEventosByForumLeader`(_id_user int(11))
BEGIN
select miembro.mie_id, month(evento.eve_fechainicio) as mes, year(evento.eve_fechainicio) as anho,
concat(persona.per_nombre,' ',persona.per_apellido) as nombre, miembro.grupo_id 
from miembro 
join asistencia on (asistencia.miembro_mie_id=miembro.mie_id and asistencia.asis_estado = 1)
join evento on (asistencia.evento_eve_id=evento.eve_id)
join persona on (persona.per_id = miembro.Persona_per_id)
where miembro.grupo_id in (select gru_id from grupos where gru_forum = _id_user) and miembro.cancelled = 0 
order by miembro.grupo_id;
END;