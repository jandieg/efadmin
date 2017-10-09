CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectEmpresaLocalFiltros3`(IN `_id` INT, IN `_key` INT, IN `_permiso` INT, IN _mostrar_todas INT, IN _id_user INT)
BEGIN
declare v_sede int;
select sede_id into v_sede from usuario where usu_id = _id_user;

if _mostrar_todas = '1' then
  if _permiso = '' then  
        if _key = '' then  
            SELECT emp_id, emp_nombre as 'nombre_empresa', emp_fecharegistro as 'fecha_registro', emp_fechamodificacion as 'fecha_modificación', emp_id_usuario, emp_estado 
                , emp_ruc, emp_imgresos, emp_num_empleados, emp_fax, emp_sitio_web
            FROM empresalocal 
            where emp_id in (SELECT  `empresalocal_emp_id` FROM `miembro` WHERE grupo_id in (select gru_id from grupos where sede_id = v_sede))
            ORDER BY nombre_empresa;
        end if;
       if _key = '1' then 
            SELECT emp_id, emp_nombre as 'nombre_empresa', emp_fecharegistro as 'fecha_registro', emp_fechamodificacion as 'fecha_modificación', emp_id_usuario, emp_estado 
                , emp_ruc, emp_imgresos, emp_num_empleados, emp_fax, emp_sitio_web
            FROM empresalocal 
            where emp_id in (SELECT  `empresalocal_emp_id` FROM `miembro` WHERE grupo_id = _id)
            ORDER BY nombre_empresa;       
        end if;
        if _key = '2' then 
            SELECT emp_id, emp_nombre as 'nombre_empresa', emp_fecharegistro as 'fecha_registro', emp_fechamodificacion as 'fecha_modificación', emp_id_usuario, emp_estado 
                , emp_ruc, emp_imgresos, emp_num_empleados, emp_fax, emp_sitio_web
            FROM empresalocal 
            where emp_id in (SELECT  `empresalocal_emp_id` FROM `miembro` WHERE miembro.forum_usu_id = _id)
            ORDER BY nombre_empresa;
        end if;
 
        if _key = '4' then 
            SELECT emp_id, emp_nombre as 'nombre_empresa', emp_fecharegistro as 'fecha_registro', emp_fechamodificacion as 'fecha_modificación', emp_id_usuario, emp_estado 
                , emp_ruc, emp_imgresos, emp_num_empleados, emp_fax, emp_sitio_web
            FROM empresalocal 
            where emp_id in (SELECT  `empresalocal_emp_id` FROM `empresa_industria` WHERE industria_ind_id= _id)
            and emp_id in (SELECT  `empresalocal_emp_id` FROM `miembro` WHERE grupo_id in (select gru_id from grupos where sede_id = v_sede))
            ORDER BY nombre_empresa;
        end if;
    
    else 
        if _key = '' then 
            SELECT emp_id, emp_nombre as 'nombre_empresa', emp_fecharegistro as 'fecha_registro', emp_fechamodificacion as 'fecha_modificación', emp_id_usuario, emp_estado 
                , emp_ruc, emp_imgresos, emp_num_empleados, emp_fax, emp_sitio_web
            FROM empresalocal 
            where emp_id in (SELECT  `empresalocal_emp_id` FROM `miembro` WHERE miembro.forum_usu_id = _permiso)
            ORDER BY nombre_empresa; 

        end if;
        if _key = '1' then 
            SELECT emp_id, emp_nombre as 'nombre_empresa', emp_fecharegistro as 'fecha_registro', emp_fechamodificacion as 'fecha_modificación', emp_id_usuario, emp_estado 
                , emp_ruc, emp_imgresos, emp_num_empleados, emp_fax, emp_sitio_web
            FROM empresalocal 
            where emp_id in (SELECT  `empresalocal_emp_id` FROM `miembro` WHERE miembro.forum_usu_id = _permiso and grupo_id = _id)
            ORDER BY nombre_empresa; 
        end if;

        if _key = '4' then  
            SELECT emp_id, emp_nombre as 'nombre_empresa', emp_fecharegistro as 'fecha_registro', emp_fechamodificacion as 'fecha_modificación', emp_id_usuario, emp_estado 
                , emp_ruc, emp_imgresos, emp_num_empleados, emp_fax, emp_sitio_web
            FROM empresalocal 
            where emp_id in (SELECT  `empresalocal_emp_id` FROM `empresa_industria` WHERE industria_ind_id= _id) and emp_id in (SELECT  `empresalocal_emp_id` FROM `miembro` WHERE miembro.forum_usu_id = _permiso )
            ORDER BY nombre_empresa;
        end if;
  
    
    end if;
else 

  if _permiso = '' then  
        if _key = '' then  
            SELECT emp_id, emp_nombre as 'nombre_empresa', emp_fecharegistro as 'fecha_registro', emp_fechamodificacion as 'fecha_modificación', emp_id_usuario, emp_estado 
                , emp_ruc, emp_imgresos, emp_num_empleados, emp_fax, emp_sitio_web
            FROM empresalocal 
            where emp_id in (select empresalocal_emp_id from miembro where cancelled = 0)
            and emp_id in (SELECT  `empresalocal_emp_id` FROM `miembro` WHERE grupo_id in (select gru_id from grupos where sede_id = v_sede))
            ORDER BY nombre_empresa;
        end if;
       if _key = '1' then 
            SELECT emp_id, emp_nombre as 'nombre_empresa', emp_fecharegistro as 'fecha_registro', emp_fechamodificacion as 'fecha_modificación', emp_id_usuario, emp_estado 
                , emp_ruc, emp_imgresos, emp_num_empleados, emp_fax, emp_sitio_web
            FROM empresalocal 
            where emp_id in (SELECT  `empresalocal_emp_id` FROM `miembro` WHERE grupo_id = _id and cancelled = 0)
            ORDER BY nombre_empresa;       
        end if;
        if _key = '2' then 
            SELECT emp_id, emp_nombre as 'nombre_empresa', emp_fecharegistro as 'fecha_registro', emp_fechamodificacion as 'fecha_modificación', emp_id_usuario, emp_estado 
                , emp_ruc, emp_imgresos, emp_num_empleados, emp_fax, emp_sitio_web
            FROM empresalocal 
            where emp_id in (SELECT  `empresalocal_emp_id` FROM `miembro` WHERE miembro.forum_usu_id = _id and  cancelled = 0)
            ORDER BY nombre_empresa;
        end if;
 
        if _key = '4' then 
            SELECT emp_id, emp_nombre as 'nombre_empresa', emp_fecharegistro as 'fecha_registro', emp_fechamodificacion as 'fecha_modificación', emp_id_usuario, emp_estado 
                , emp_ruc, emp_imgresos, emp_num_empleados, emp_fax, emp_sitio_web
            FROM empresalocal 
            where emp_id in (SELECT  `empresalocal_emp_id` FROM `empresa_industria` WHERE industria_ind_id= _id)
            and emp_id in (select empresalocal_emp_id from miembro where   cancelled = 0)
            and emp_id in (SELECT  `empresalocal_emp_id` FROM `miembro` WHERE grupo_id in (select gru_id from grupos where sede_id = v_sede))
            ORDER BY nombre_empresa;
        end if;
    
    else 
        if _key = '' then 
            SELECT emp_id, emp_nombre as 'nombre_empresa', emp_fecharegistro as 'fecha_registro', emp_fechamodificacion as 'fecha_modificación', emp_id_usuario, emp_estado 
                , emp_ruc, emp_imgresos, emp_num_empleados, emp_fax, emp_sitio_web
            FROM empresalocal 
            where emp_id in (SELECT  `empresalocal_emp_id` FROM `miembro` WHERE miembro.forum_usu_id = _permiso  and  cancelled = 0)
            ORDER BY nombre_empresa; 

        end if;
        if _key = '1' then 
            SELECT emp_id, emp_nombre as 'nombre_empresa', emp_fecharegistro as 'fecha_registro', emp_fechamodificacion as 'fecha_modificación', emp_id_usuario, emp_estado 
                , emp_ruc, emp_imgresos, emp_num_empleados, emp_fax, emp_sitio_web
            FROM empresalocal 
            where emp_id in (SELECT  `empresalocal_emp_id` FROM `miembro` WHERE miembro.forum_usu_id = _permiso and grupo_id = _id  and  cancelled = 0)
            ORDER BY nombre_empresa; 
        end if;

        if _key = '4' then  
            SELECT emp_id, emp_nombre as 'nombre_empresa', emp_fecharegistro as 'fecha_registro', emp_fechamodificacion as 'fecha_modificación', emp_id_usuario, emp_estado 
                , emp_ruc, emp_imgresos, emp_num_empleados, emp_fax, emp_sitio_web
            FROM empresalocal 
            where emp_id in (SELECT  `empresalocal_emp_id` FROM `empresa_industria` WHERE industria_ind_id= _id)          
            and emp_id in (SELECT  `empresalocal_emp_id` FROM `miembro` 
            WHERE miembro.forum_usu_id = _permiso and  cancelled = 0)
            
            ORDER BY nombre_empresa;
        end if;
  
    
    end if;

end if;

END;
