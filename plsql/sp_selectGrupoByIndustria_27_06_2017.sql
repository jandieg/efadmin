CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectGrupoByIndustria`(_id_industria int(11))
BEGIN
select * from grupos where gru_id in 
(select grupo_id from miembro where empresalocal_emp_id in 
(select empresalocal_emp_id from empresa_industria where industria_ind_id = _id_industria));
END;
