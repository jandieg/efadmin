CREATE DEFINER=execforums@localhost PROCEDURE `sp_selectGrupoByMiembro`(IN _id_miembro int(11))
BEGIN
select * from grupos where gru_id in (select grupo_id from miembro where mie_id = _id_miembro);
END;
