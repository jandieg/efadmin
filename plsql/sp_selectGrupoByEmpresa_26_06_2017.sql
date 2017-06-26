CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectGrupoByEmpresa`(_id_empresa int(11))
BEGIN
select * from grupos where gru_id in (select grupo_id from miembro where empresalocal_emp_id = _id_empresa);
END;
