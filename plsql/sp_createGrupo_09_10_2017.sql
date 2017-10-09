CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_createGrupo`(IN `_nombre` VARCHAR(100), IN `_idForum` INT, IN `_fr` TIMESTAMP, 
IN `_usuario` VARCHAR(10), IN _sede INT)
BEGIN

INSERT INTO `grupos`( gru_estado,`gru_descripcion`, `gru_forum`, `gru_fecharegistro`, `gru_fechamodificacion`, `gru_id_usuario`, sede_id, agrup) 
VALUES ('A',_nombre,_idForum,_fr,_fr,_usuario, _sede, 'A');
   
END;
