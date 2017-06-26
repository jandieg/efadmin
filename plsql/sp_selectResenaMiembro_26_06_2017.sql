CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectResenaEmpresaMiembro`(_id_empresa int(11))
BEGIN
        select * from miembro where empresalocal_emp_id = _id_empresa limit 1;
END;
