CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectGrupoByIndustriaAndUser`(IN _id_industria int(11),IN _id_user INT)
BEGIN
select * from grupos where gru_id in 
(select grupo_id from miembro where empresalocal_emp_id in 
(select empresalocal_emp_id from empresa_industria where industria_ind_id = _id_industria))
and grupos.sede_id = (select sede_id from usuario where usu_id = _id_user);

END;
