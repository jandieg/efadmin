CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectMiembrosPendientesxForumLeader`(_id_user int(11))
BEGIN
select miembro.mie_id, (case count(asistencia.asis_id) = 0 when true then 0 
else max(cast(date_format(evento.eve_fechainicio,"%Y%m%d") as unsigned)) end),
miembro.grupo_id 
from miembro 
join miembro_inscripcion on (miembro_inscripcion.miembro_id = miembro.mie_id 
and (datediff(curdate(),miembro_inscripcion.mie_ins_fecha_ingreso) > 90)) 
left join asistencia on (asistencia.miembro_mie_id=miembro.mie_id and asistencia.asis_estado = 1)
left join evento on (asistencia.evento_eve_id=evento.eve_id)
where miembro.grupo_id in (select gru_id from grupos where gru_forum = _id_user) 
group by miembro.mie_id 
order by 3,2 asc;
END;
