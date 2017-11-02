CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectMiembrosPendientesxGrupo`(IN `_id_grupo` INT)
BEGIN
select miembro.mie_id, (case count(evento.eve_id) = 0 when true then 0 
else max(cast(date_format(evento.eve_fechainicio,"%Y%m%d") as unsigned)) end)
from miembro 
join miembro_inscripcion on (miembro_inscripcion.miembro_id = miembro.mie_id 
and (datediff(curdate(),miembro_inscripcion.mie_ins_fecha_ingreso) > 90)) 
left join evento_empresario_mes on (evento_empresario_mes.miembro_mie_id=miembro.mie_id)
left join evento on (evento_empresario_mes.evento_eve_id=evento.eve_id)
join grupos on (grupos.gru_id = miembro.grupo_id) 
where miembro.grupo_id = _id_grupo and miembro.cancelled = 0 
and grupos.agrup in ('A') 
group by miembro.mie_id 
order by 2 asc
limit 3;
END;