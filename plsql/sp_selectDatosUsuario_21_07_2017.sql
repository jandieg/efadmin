CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectDatosUsuario`(_id_usuario int(11))
BEGIN
select * from usuario where usu_id = _id_usuario;
END;
