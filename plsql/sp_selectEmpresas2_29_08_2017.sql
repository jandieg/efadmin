CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectEmpresas2`(IN `_id_forum` INT, IN _id_user int)
BEGIN
    if _id_forum <> '' then
        SELECT 
        persona.per_id ,  
        persona.per_id, 
        persona.per_nombre, 
        persona.per_apellido,
        prospecto.pro_id,
        miembro.mie_id,
        miembro.empresalocal_emp_id as 'emp_id',
        (SELECT emp_nombre FROM empresalocal WHERE emp_id = miembro.empresalocal_emp_id) as 'nombre_empresa',
        (SELECT emp_fecharegistro FROM empresalocal WHERE emp_id = miembro.empresalocal_emp_id) as 'fecha_registro',
        (SELECT emp_fechamodificacion FROM empresalocal WHERE emp_id = miembro.empresalocal_emp_id) as 'fecha_modificación'
        FROM  miembro, prospecto  
        INNER join persona on prospecto.Persona_per_id = persona.per_id 
        inner join usuario on prospecto.forum_usu_id = usuario.usu_id
        where prospecto.prosp_esmiembro ='1' and miembro.prospecto_pro_id= prospecto.pro_id and prospecto.forum_usu_id=_id_forum
        and usuario.sede_id = (select sede_id from usuario where usu_id=_id_usar)
        ORDER BY nombre_empresa;

    else
        SELECT empresalocal.emp_id, empresalocal.emp_nombre as 'nombre_empresa', 
        empresalocal.emp_fecharegistro as 'fecha_registro', 
        empresalocal.emp_fechamodificacion as 'fecha_modificación', 
        empresalocal.emp_id_usuario, empresalocal.emp_estado FROM empresalocal 
        join usuario on empresalocal.emp_id_usuario = usuario.usu_id 
        where usuario.sede_id = (select sede_id from usuario where usu_id=_id_user)
        ORDER BY nombre_empresa;

    end if;
END;
