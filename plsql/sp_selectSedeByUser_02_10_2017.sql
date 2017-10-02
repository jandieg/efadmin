CREATE DEFINER='execforums'@'localhost' PROCEDURE `sp_selectSedeByUser`(_usuario int(11))
BEGIN
select sede_id from usuario where usu_id = _usuario;
END;