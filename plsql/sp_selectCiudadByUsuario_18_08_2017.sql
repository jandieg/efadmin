CREATE DEFINER='execforums'@'localhost' PROCEDURE `sp_selectCiudadByUsuario`(IN _id_usuario int(11))
BEGIN
select sede.* from usuario join sede 
where usuario.usu_id = _id_usuario 
and usuario.sede_id=sede.sede_id;
END;
