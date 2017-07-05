CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectEstadosAplicantes`(IN `_estado` VARCHAR(10))
BEGIN

   SELECT * FROM member_status where mem_sta_estado = _estado 
   and mem_sta_ismiembroaplicante = 0;
END;
