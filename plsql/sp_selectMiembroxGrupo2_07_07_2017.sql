CREATE DEFINER=execforums@localhost PROCEDURE `sp_selectMiembroxGrupo2`(_id_grupo int(11))
BEGIN
select * from miembro where grupo_id = _id_grupo;
END;