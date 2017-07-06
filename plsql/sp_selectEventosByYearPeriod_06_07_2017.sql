CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectEventosByYearPeriod`(IN _anho_inicial int(11),IN _anho_final int(11))
BEGIN
select year(evento.eve_fechainicio) as anho, month(evento.eve_fechainicio) as mes, 
evento_grupo.grupos_gru_id, 
(case evento.tipo_evento_id = 2 when true 
then evento.eve_descripcion 
else concat('<strong>',evento.eve_nombre,'</strong>') end) as ocasion
from evento join evento_grupo 
on (evento.eve_id = evento_grupo.evento_eve_id)
 where year(evento.eve_fechainicio) between _anho_inicial and _anho_final;
END;
