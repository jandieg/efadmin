CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectMiembrosPendientesByUser`(IN _id_usuario int)
BEGIN
declare v_sede int;
select sede_id into v_sede from usuario where usu_id = _id_usuario limit 1;
select b.grupo_id, group_concat(b.mie_id) as mie_id from 
(select miembro.mie_id, (case count(evento.eve_id) = 0 when true then 0 
else max(cast(date_format(evento.eve_fechainicio,"%Y%m%d") as unsigned)) end) as valor,
miembro.grupo_id 
from miembro 
join miembro_inscripcion on (miembro_inscripcion.miembro_id = miembro.mie_id 
and (datediff(curdate(),miembro_inscripcion.mie_ins_fecha_ingreso) > 90)) 
left join evento_empresario_mes on (evento_empresario_mes.miembro_mie_id=miembro.mie_id)
left join evento on (evento_empresario_mes.evento_eve_id=evento.eve_id)
where miembro.grupo_id in (select gru_id from grupos where sede_id = v_sede) 
group by miembro.mie_id 
order by 3,2 asc) as b
group by b.grupo_id
order by b.grupo_id, b.valor asc;
END;
