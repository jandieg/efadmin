CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectEventos2ByUser`(IN `_id_usuario` INT)
BEGIN
declare v_sede int;
select sede_id into v_sede from usuario where usu_id = _id_usuario limit 1;
select miembro.mie_id, month(evento.eve_fechainicio) as mes, year(evento.eve_fechainicio) as anho,
concat(persona.per_nombre,' ',persona.per_apellido) as nombre, miembro.grupo_id 
from miembro 
join evento_empresario_mes on (evento_empresario_mes.miembro_mie_id=miembro.mie_id)
join evento on (evento_empresario_mes.evento_eve_id=evento.eve_id)
join persona on (persona.per_id = miembro.Persona_per_id)
where miembro.grupo_id in (select gru_id from grupos where sede_id = v_sede and agrup in ('A'))
order by miembro.grupo_id;
END;