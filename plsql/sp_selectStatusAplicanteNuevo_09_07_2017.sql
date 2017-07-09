CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectStatusAplicanteNuevo`(IN `_estado` VARCHAR(10), IN `_ismiembroaplicante` INT)
BEGIN
        SELECT `mem_sta_id`, `mem_sta_codigo`, `mem_sta_descripcion`, 
        `mem_sta_estado`, `mem_sta_id_usuario`, `mem_sta_fecharegistro`, `mem_sta_fechamodificacion` 
        FROM `member_status` where binary mem_sta_estado = _estado 
        and member_status.mem_sta_ismiembroaplicante = _ismiembroaplicante and mem_sta_id in (5,10,11);
END;
