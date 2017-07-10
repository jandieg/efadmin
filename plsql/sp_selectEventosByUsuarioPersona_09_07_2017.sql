CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectEventosByUsuarioPersona`(IN `_id` INT)
BEGIN
	
if _id <> '' then
            	SELECT DISTINCT
                    evento.eve_id as 'id',
                    evento.eve_nombre as 'title'
                    ,tipo_evento.tip_eve_tododia as 'tododia'
                    ,tipo_evento.tip_eve_dia_rango_fin as 'dia_fin'
                    ,tipo_evento.tip_eve_hora_rango_inicio as 'hora_inicio'
                    ,tipo_evento.tip_eve_hora_rango_fin as 'hora_fin'
                    ,evento.eve_fechainicio as 'start',
                    evento.eve_fechafin as 'end', 
                    'true' as 'allDay',
                    tipo_evento.tip_eve_codigo_color as 'backgroundColor'
                    ,'#0073b7' as 'borderColor'
                    FROM evento , tipo_evento, usuario 
                    
                WHERE evento.tipo_evento_id =tipo_evento.tip_eve_id 
                and evento.eve_responsable = usuario.Persona_per_id 
                and usuario.usu_id = _id;      
        else
                SELECT 
                    evento.eve_id as 'id',
                    evento.eve_nombre as 'title'
                    ,tipo_evento.tip_eve_tododia as 'tododia'
                    ,tipo_evento.tip_eve_dia_rango_fin as 'dia_fin'
                    ,tipo_evento.tip_eve_hora_rango_inicio as 'hora_inicio'
                    ,tipo_evento.tip_eve_hora_rango_fin as 'hora_fin'
                    ,evento.eve_fechainicio as 'start',
                    evento.eve_fechafin as 'end', 
                    'true' as 'allDay',
                    tipo_evento.tip_eve_codigo_color as 'backgroundColor'
                    ,'#0073b7' as 'borderColor'
                FROM evento , tipo_evento 
                WHERE evento.tipo_evento_id =tipo_evento.tip_eve_id;

        end if;

END;
