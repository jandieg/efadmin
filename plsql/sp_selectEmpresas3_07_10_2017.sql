CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectEmpresas3`(IN `_id_forum` INT, IN _id_user int)
BEGIN



    if _id_forum <> '' then
        SELECT 
        persona.per_id ,  
        persona.per_id, 
        persona.per_nombre, 
        persona.per_apellido,
        miembro.mie_id,
        miembro.empresalocal_emp_id as 'emp_id',
        (SELECT emp_nombre FROM empresalocal WHERE emp_id = miembro.empresalocal_emp_id) as 'nombre_empresa',
        (SELECT emp_fecharegistro FROM empresalocal WHERE emp_id = miembro.empresalocal_emp_id) as 'fecha_registro',
        (SELECT emp_fechamodificacion FROM empresalocal WHERE emp_id = miembro.empresalocal_emp_id) as 'fecha_modificación'
        FROM  miembro  
        INNER join persona on miembro.Persona_per_id = persona.per_id 
        inner join usuario on miembro.forum_usu_id = usuario.usu_id
        where miembro.forum_usu_id=_id_forum
        and usuario.sede_id = (select sede_id from usuario where usu_id=_id_user)
        ORDER BY nombre_empresa;

    else
       SELECT 
        persona.per_id ,  
        persona.per_id, 
        persona.per_nombre, 
        persona.per_apellido,
        miembro.mie_id,
        miembro.empresalocal_emp_id as 'emp_id',
        (SELECT emp_nombre FROM empresalocal WHERE emp_id = miembro.empresalocal_emp_id) as 'nombre_empresa',
        (SELECT emp_fecharegistro FROM empresalocal WHERE emp_id = miembro.empresalocal_emp_id) as 'fecha_registro',
        (SELECT emp_fechamodificacion FROM empresalocal WHERE emp_id = miembro.empresalocal_emp_id) as 'fecha_modificación'
        FROM  miembro  
        INNER join persona on miembro.Persona_per_id = persona.per_id 
        inner join usuario on miembro.forum_usu_id = usuario.usu_id
        where miembro.forum_usu_id=usuario.usu_id
        and usuario.sede_id = (select sede_id from usuario where usu_id=_id_user)
        ORDER BY nombre_empresa;


    end if;
END;
