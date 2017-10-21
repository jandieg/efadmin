CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectEventosByYearPeriodByUser`(IN _anho_inicial int(11),IN _anho_final int(11), IN _id_usuario int)
BEGIN

declare v_sede int;

select sede_id into v_sede from usuario where usu_id = _id_usuario limit 1;

select year(evento.eve_fechainicio) as anho, month(evento.eve_fechainicio) as mes, 
evento_grupo.grupos_gru_id, 
(case evento.tipo_evento_id = 2 when true 
then evento.eve_descripcion 
else concat('<strong>',evento.eve_nombre,'</strong>') end) as ocasion,
evento.eve_puntaje 
from evento join evento_grupo 
on (evento.eve_id = evento_grupo.evento_eve_id)
 where year(evento.eve_fechainicio) between _anho_inicial and _anho_final
 and evento_grupo.grupos_gru_id in (select gru_id from grupos where sede_id = v_sede);
END;