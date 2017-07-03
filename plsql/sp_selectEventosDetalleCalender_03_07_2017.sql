CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectEventosDetalleCalendar`(IN `_id` INT)
BEGIN

    SELECT evento.eve_nombre, evento.eve_id,  evento.eve_responsable, evento.eve_todoeldia, evento.eve_fechainicio, evento.eve_fechafin, evento.eve_fecharegistro,
    evento.eve_fechamodificacion, evento.eve_id_usuario,  evento.direccion_id, evento.eve_descripcion, evento.eve_mis_grupos,
    evento.eve_todos_grupos, evento.tipo_evento_id, evento.evento_acompanado,
    tipo_evento.tip_eve_descripcion,
    tipo_evento.tip_eve_opcion_contacto, 
    tipo_evento.tip_eve_opcion_acompanado, 
    tipo_evento.tip_eve_opcion_invitado, 
    tipo_evento.tip_eve_opcion_empresario_mes,
    tipo_evento.tip_eve_opcion_direccion,
    evento.direccion_id as 'direccion',
    (SELECT `eve_aco_descripcion` FROM `evento_acompanado` WHERE eve_aco_id = evento.evento_acompanado) as 'acompanado'
    FROM evento,  tipo_evento WHERE eve_id=_id  and tipo_evento.tip_eve_id = evento.tipo_evento_id;
END;
