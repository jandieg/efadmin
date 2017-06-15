CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectGrupoByTipoEvento`(IN `_tipo_evento_id` INT)
BEGIN
   SELECT *
   FROM `grupos` WHERE gru_id 
   in (select evento_grupo.grupos_gru_id 
   from evento_grupo 
   join evento 
   on (evento_grupo.evento_eve_id = evento.eve_id)
   where evento.tipo_evento_id = _tipo_evento_id);
END;
