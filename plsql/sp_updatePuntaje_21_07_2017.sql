CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_updatePuntaje`(_id_evento int(11), _puntaje varchar(10))
BEGIN
update evento set eve_puntaje = _puntaje where eve_id = _id_evento;
END;
