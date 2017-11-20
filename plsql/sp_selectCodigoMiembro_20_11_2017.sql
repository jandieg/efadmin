CREATE DEFINER=`root`@`%` PROCEDURE `sp_selectCodigoMiembro`(_user varchar(100), _codigo varchar(100))
BEGIN

select usu_user from usuario 
where usu_user in (_user) and substr(usu_pass,1,6) in (_codigo);

END;
