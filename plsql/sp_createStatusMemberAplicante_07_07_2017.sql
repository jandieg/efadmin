CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_createStatusMemberAplicante`(IN `_codigo` VARCHAR(200), IN `_descripcion` VARCHAR(200), IN `_usuario` INT, IN `_fecharegistro` TIMESTAMP)
BEGIN
    INSERT INTO `member_status`( `mem_sta_codigo`, `mem_sta_descripcion`, `mem_sta_estado`, `mem_sta_id_usuario`, `mem_sta_fecharegistro`, `mem_sta_fechamodificacion`, mem_sta_ismiembroaplicante)
     VALUES (_codigo,_descripcion,'A',_usuario,_fecharegistro,_fecharegistro, 0);
END;
