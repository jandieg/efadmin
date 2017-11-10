CREATE PROCEDURE `sp_selectGrupoByUser`(_id_usuario int(11))
BEGIN
    declare v_sede int;
    select sede_id into v_sede from usuario where usu_id = _id_usuario;
    select * from grupos where sede_id = v_sede;
END;