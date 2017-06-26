CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectMiembrosByEmpresa`(_id_empresa int(11))
BEGIN
        select * from miembro inner join persona on (miembro.Persona_per_id = persona.per_id) 
        where miembro.empresalocal_emp_id = _id_empresa;
END;
