CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectMiembroFiltros`(IN `_id` TEXT, IN `_key` INT, IN `_permiso` INT, IN `_canceladas` INT)
BEGIN
 
if _canceladas = 0  then 
if _permiso = '' then  
    if _key = '' then  
            SELECT  
            miembro.mie_id,
            miembro.grupo_id,
            miembro.mie_codigo,
            miembro.prospecto_pro_id as 'id_prospecto',
            miembro.empresalocal_emp_id,
            (SELECT `emp_nombre` FROM `empresalocal` WHERE emp_id = miembro.empresalocal_emp_id) as 'nombre_empresa',
            miembro.mie_fechamodificacion, 
            miembro.mie_fecharegistro, 
            miembro.mie_id_usuario, 
            miembro.mie_descripcion_desafio,
            miembro.mie_participacion_correo,               
            miembro.Profesion_prof_id,
            miembro.categoria_cat_id, 
            miembro.cancelled,
            persona.per_id ,  
            persona.per_nombre, 
            member_status.mem_sta_descripcion,
            persona.per_apellido, 
            (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id LIMIT 1) as 'correo',
            (SELECT  `tel_descripcion` FROM `telefono` WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil',
            (SELECT  concat (persona.per_nombre ,' ', persona.per_apellido) as 'nombre_forum'  
             FROM persona, perfil, usuario 
             WHERE usuario.usu_id= miembro.forum_usu_id 
             and usuario.Persona_per_id= persona.per_id and usuario.perfil_per_id= perfil.per_id LIMIT 1) as 'nombre_forum'
            FROM  miembro  
            INNER join persona on miembro.Persona_per_id = persona.per_id 
            INNER join member_status on miembro.status_member_id = member_status.mem_sta_id
            where miembro.cancelled = 0 
            ORDER BY TRIM(miembro.mie_codigo);
        end if;
       if _key = '1' then  
            SELECT  
            miembro.mie_id,
            miembro.grupo_id,
            miembro.mie_codigo,
            miembro.prospecto_pro_id as 'id_prospecto',
            miembro.empresalocal_emp_id,
            (SELECT `emp_nombre` FROM `empresalocal` WHERE emp_id = miembro.empresalocal_emp_id) as 'nombre_empresa',
            miembro.mie_fechamodificacion, 
            miembro.mie_fecharegistro, 
            miembro.mie_id_usuario, 
            miembro.mie_descripcion_desafio,
            miembro.mie_participacion_correo,               
            miembro.Profesion_prof_id,
            miembro.categoria_cat_id, 
            miembro.cancelled,
            persona.per_id ,  
            persona.per_nombre, 
            persona.per_apellido, 
            member_status.mem_sta_descripcion,
            (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id LIMIT 1) as 'correo',
            (SELECT  `tel_descripcion` FROM `telefono` WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil',
            (SELECT  concat (persona.per_nombre ,' ', persona.per_apellido) as 'nombre_forum'  
             FROM persona, perfil, usuario 
             WHERE usuario.usu_id= miembro.forum_usu_id 
             and usuario.Persona_per_id= persona.per_id and usuario.perfil_per_id= perfil.per_id LIMIT 1) as 'nombre_forum'

            FROM  miembro  
            INNER join persona on miembro.Persona_per_id = persona.per_id 
            INNER join member_status on miembro.status_member_id = member_status.mem_sta_id
            where miembro.grupo_id = _id and miembro.cancelled = 0 
            ORDER BY TRIM(miembro.mie_codigo);
        end if;
        if _key = '2' then  
            SELECT  
            miembro.mie_id,
            miembro.grupo_id,
            miembro.mie_codigo,
            miembro.prospecto_pro_id as 'id_prospecto',
            miembro.empresalocal_emp_id,
            (SELECT `emp_nombre` FROM `empresalocal` WHERE emp_id = miembro.empresalocal_emp_id) as 'nombre_empresa',
            miembro.mie_fechamodificacion, 
            miembro.mie_fecharegistro, 
            miembro.mie_id_usuario, 
            miembro.mie_descripcion_desafio,
            miembro.mie_participacion_correo,               
            miembro.Profesion_prof_id,
            miembro.categoria_cat_id, 
            miembro.cancelled,
            member_status.mem_sta_descripcion,
            persona.per_id ,  
            persona.per_nombre, 
            persona.per_apellido, 
            (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id LIMIT 1) as 'correo',
            (SELECT  `tel_descripcion` FROM `telefono` WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil',
            (SELECT  concat (persona.per_nombre ,' ', persona.per_apellido) as 'nombre_forum'  
             FROM persona, perfil, usuario 
             WHERE usuario.usu_id= miembro.forum_usu_id 
             and usuario.Persona_per_id= persona.per_id and usuario.perfil_per_id= perfil.per_id LIMIT 1) as 'nombre_forum'

            FROM  miembro  
            INNER join persona on miembro.Persona_per_id = persona.per_id 
            INNER join member_status on miembro.status_member_id = member_status.mem_sta_id
            where miembro.forum_usu_id = _id and miembro.cancelled = 0
            ORDER BY TRIM(miembro.mie_codigo);
        end if;
        if _key = '3' then  
            SELECT  Distinct
            miembro.mie_id,
            miembro.grupo_id,
            miembro.mie_codigo,
            miembro.prospecto_pro_id as 'id_prospecto',
            miembro.empresalocal_emp_id,
            (SELECT `emp_nombre` FROM `empresalocal` WHERE emp_id = miembro.empresalocal_emp_id) as 'nombre_empresa',
            miembro.mie_fechamodificacion, 
            miembro.mie_fecharegistro, 
            miembro.mie_id_usuario, 
            miembro.mie_descripcion_desafio,
            member_status.mem_sta_descripcion,
            miembro.mie_participacion_correo,               
            miembro.Profesion_prof_id,
            miembro.categoria_cat_id, 
            miembro.cancelled,
            persona.per_id ,  
            persona.per_nombre, 
            persona.per_apellido, 
            (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id LIMIT 1) as 'correo',
            (SELECT  `tel_descripcion` FROM `telefono` WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil',
            (SELECT  concat (persona.per_nombre ,' ', persona.per_apellido) as 'nombre_forum'  
             FROM persona, perfil, usuario 
             WHERE usuario.usu_id= miembro.forum_usu_id 
             and usuario.Persona_per_id= persona.per_id and usuario.perfil_per_id= perfil.per_id LIMIT 1) as 'nombre_forum'

            FROM  miembro  
            INNER join persona on miembro.Persona_per_id = persona.per_id 
            INNER join member_status on miembro.status_member_id = member_status.mem_sta_id
            where (miembro.mie_id in (SELECT  `miembro_mie_id` FROM `miembro_empresa` WHERE empresalocal_emp_id=_id) 
            or miembro.empresalocal_emp_id =_id) and miembro.cancelled = 0 
            ORDER BY TRIM(miembro.mie_codigo);
        end if;
 
        if _key = '4' then  
            SELECT  Distinct
            miembro.mie_id,
            miembro.grupo_id,
            miembro.mie_codigo,
            miembro.prospecto_pro_id as 'id_prospecto',
            miembro.empresalocal_emp_id,
            (SELECT `emp_nombre` FROM `empresalocal` WHERE emp_id = miembro.empresalocal_emp_id) as 'nombre_empresa',
            miembro.mie_fechamodificacion, 
            miembro.mie_fecharegistro, 
            miembro.mie_id_usuario, 
            miembro.mie_descripcion_desafio,
            miembro.mie_participacion_correo,               
            miembro.Profesion_prof_id,
            miembro.categoria_cat_id, 
            miembro.cancelled,
            member_status.mem_sta_descripcion,
            persona.per_id ,  
            persona.per_nombre, 
            persona.per_apellido, 
            (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id LIMIT 1) as 'correo',
            (SELECT  `tel_descripcion` FROM `telefono` WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil',
            (SELECT  concat (persona.per_nombre ,' ', persona.per_apellido) as 'nombre_forum'  
             FROM persona, perfil, usuario 
             WHERE usuario.usu_id= miembro.forum_usu_id 
             and usuario.Persona_per_id= persona.per_id and usuario.perfil_per_id= perfil.per_id LIMIT 1) as 'nombre_forum'

            FROM  miembro  
            INNER join persona on miembro.Persona_per_id = persona.per_id 
            INNER join member_status on miembro.status_member_id = member_status.mem_sta_id
            where 
            (miembro.mie_id in (SELECT  `miembro_mie_id` FROM `miembro_empresa` WHERE empresalocal_emp_id in (SELECT  `empresalocal_emp_id` FROM `empresa_industria` WHERE industria_ind_id = _id))
            or miembro.empresalocal_emp_id in (SELECT  `empresalocal_emp_id` FROM `empresa_industria` WHERE industria_ind_id = _id))
            and miembro.cancelled = 0 
            ORDER BY TRIM(miembro.mie_codigo);
        end if;
        if _key = '5' then  
          if _id = '2' then 
           SELECT  
            miembro.mie_id,
            miembro.grupo_id,
            miembro.mie_codigo,
            miembro.prospecto_pro_id as 'id_prospecto',
            miembro.empresalocal_emp_id,
            (SELECT `emp_nombre` FROM `empresalocal` WHERE emp_id = miembro.empresalocal_emp_id) as 'nombre_empresa',
            miembro.mie_fechamodificacion, 
            miembro.mie_fecharegistro, 
            miembro.mie_id_usuario, 
            miembro.mie_descripcion_desafio,
            miembro.mie_participacion_correo,               
            miembro.Profesion_prof_id,
            miembro.categoria_cat_id, 
            miembro.cancelled,
            persona.per_id ,  
            persona.per_nombre, 
            persona.per_apellido, 
            member_status.mem_sta_descripcion,
            (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id LIMIT 1) as 'correo',
            (SELECT  `tel_descripcion` FROM `telefono` WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil',
            (SELECT  concat (persona.per_nombre ,' ', persona.per_apellido) as 'nombre_forum'  
             FROM persona, perfil, usuario 
             WHERE usuario.usu_id= miembro.forum_usu_id 
             and usuario.Persona_per_id= persona.per_id and usuario.perfil_per_id= perfil.per_id LIMIT 1) as 'nombre_forum'

            FROM  miembro  
            INNER join persona on miembro.Persona_per_id = persona.per_id 
            INNER join member_status on miembro.status_member_id = member_status.mem_sta_id
            where miembro.cancelled = 1 
            ORDER BY TRIM(miembro.mie_codigo);
          else 
           SELECT  
            miembro.mie_id,
            miembro.grupo_id,
            miembro.mie_codigo,
            miembro.prospecto_pro_id as 'id_prospecto',
            miembro.empresalocal_emp_id,
            (SELECT `emp_nombre` FROM `empresalocal` WHERE emp_id = miembro.empresalocal_emp_id) as 'nombre_empresa',
            miembro.mie_fechamodificacion, 
            miembro.mie_fecharegistro, 
            miembro.mie_id_usuario, 
            miembro.mie_descripcion_desafio,
            miembro.mie_participacion_correo,               
            miembro.Profesion_prof_id,
            miembro.categoria_cat_id, 
            miembro.cancelled,
            persona.per_id ,  
            persona.per_nombre, 
            persona.per_apellido, 
            member_status.mem_sta_descripcion,
            (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id LIMIT 1) as 'correo',
            (SELECT  `tel_descripcion` FROM `telefono` WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil',
            (SELECT  concat (persona.per_nombre ,' ', persona.per_apellido) as 'nombre_forum'  
             FROM persona, perfil, usuario 
             WHERE usuario.usu_id= miembro.forum_usu_id 
             and usuario.Persona_per_id= persona.per_id and usuario.perfil_per_id= perfil.per_id LIMIT 1) as 'nombre_forum'

            FROM  miembro  
            INNER join persona on miembro.Persona_per_id = persona.per_id 
            INNER join member_status on miembro.status_member_id = member_status.mem_sta_id
            where member_status.mem_sta_id = _id and miembro.cancelled = 0 
            ORDER BY TRIM(miembro.mie_codigo);
          end if;
           
        end if;
        if _key = '6' then  
            SELECT  
            miembro.mie_id,
            miembro.grupo_id,
            miembro.mie_codigo,
            miembro.prospecto_pro_id as 'id_prospecto',
            miembro.empresalocal_emp_id,
            (SELECT `emp_nombre` FROM `empresalocal` WHERE emp_id = miembro.empresalocal_emp_id) as 'nombre_empresa',
            miembro.mie_fechamodificacion, 
            miembro.mie_fecharegistro, 
            miembro.mie_id_usuario, 
            miembro.mie_descripcion_desafio,
            miembro.mie_participacion_correo,               
            miembro.Profesion_prof_id,
            miembro.categoria_cat_id, 
            miembro.cancelled,
            persona.per_id ,  
            persona.per_nombre, 
            persona.per_apellido, 
            member_status.mem_sta_descripcion,
            (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id LIMIT 1) as 'correo',
            (SELECT  `tel_descripcion` FROM `telefono` WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil',
            (SELECT  concat (persona.per_nombre ,' ', persona.per_apellido) as 'nombre_forum'  
             FROM persona, perfil, usuario 
             WHERE usuario.usu_id= miembro.forum_usu_id 
             and usuario.Persona_per_id= persona.per_id and usuario.perfil_per_id= perfil.per_id LIMIT 1) as 'nombre_forum'
            FROM  miembro  
            INNER join persona on miembro.Persona_per_id = persona.per_id 
            INNER join member_status on miembro.status_member_id = member_status.mem_sta_id
            INNER join grupos on miembro.grupo_id = grupos.gru_id 
            where grupos.agrup in (_id) and miembro.cancelled = 0 
            ORDER BY TRIM(miembro.mie_codigo);
        end if;
    else
        if _key = '' then  
            SELECT  
            miembro.mie_id,
            miembro.grupo_id,
            miembro.mie_codigo,
            miembro.prospecto_pro_id as 'id_prospecto',
            miembro.empresalocal_emp_id,
            (SELECT `emp_nombre` FROM `empresalocal` WHERE emp_id = miembro.empresalocal_emp_id) as 'nombre_empresa',
            miembro.mie_fechamodificacion, 
            miembro.mie_fecharegistro, 
            miembro.mie_id_usuario, 
            miembro.mie_descripcion_desafio,
            miembro.mie_participacion_correo,               
            miembro.Profesion_prof_id,
            miembro.categoria_cat_id, 
            miembro.cancelled,
            member_status.mem_sta_descripcion,
            persona.per_id ,  
            persona.per_nombre, 
            persona.per_apellido, 
            (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id LIMIT 1) as 'correo',
            (SELECT  `tel_descripcion` FROM `telefono` WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil',
            (SELECT  concat (persona.per_nombre ,' ', persona.per_apellido) as 'nombre_forum'  
             FROM persona, perfil, usuario 
             WHERE usuario.usu_id= miembro.forum_usu_id 
             and usuario.Persona_per_id= persona.per_id and usuario.perfil_per_id= perfil.per_id LIMIT 1) as 'nombre_forum'

            FROM  miembro  
            INNER join persona on miembro.Persona_per_id = persona.per_id 
            INNER join member_status on miembro.status_member_id = member_status.mem_sta_id
            where miembro.forum_usu_id = _permiso and miembro.cancelled  = 0
            ORDER BY TRIM(miembro.mie_codigo);
        end if;
        if _key = '3' then  
            SELECT  Distinct
            miembro.mie_id,
            miembro.grupo_id,
            miembro.mie_codigo,
            miembro.prospecto_pro_id as 'id_prospecto',
            miembro.empresalocal_emp_id,
            (SELECT `emp_nombre` FROM `empresalocal` WHERE emp_id = miembro.empresalocal_emp_id) as 'nombre_empresa',
            miembro.mie_fechamodificacion, 
            miembro.mie_fecharegistro, 
            miembro.mie_id_usuario, 
            miembro.mie_descripcion_desafio,
            miembro.mie_participacion_correo,               
            miembro.Profesion_prof_id,
            miembro.categoria_cat_id, 
            miembro.cancelled,
            member_status.mem_sta_descripcion,
            persona.per_id ,  
            persona.per_nombre, 
            persona.per_apellido, 
            (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id LIMIT 1) as 'correo',
            (SELECT  `tel_descripcion` FROM `telefono` WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil',
            (SELECT  concat (persona.per_nombre ,' ', persona.per_apellido) as 'nombre_forum'  
             FROM persona, perfil, usuario 
             WHERE usuario.usu_id= miembro.forum_usu_id 
             and usuario.Persona_per_id= persona.per_id and
             usuario.perfil_per_id= perfil.per_id LIMIT 1) as 'nombre_forum'

            FROM  miembro  
            INNER join persona on miembro.Persona_per_id = persona.per_id 
            INNER join member_status on miembro.status_member_id = member_status.mem_sta_id
            where miembro.forum_usu_id = _permiso and 
             miembro.empresalocal_emp_id =_id and miembro.cancelled  = 0
            ORDER BY TRIM(miembro.mie_codigo);
        end if;

        if _key = '4' then  
            SELECT  Distinct
            miembro.mie_id,
            miembro.grupo_id,
            miembro.mie_codigo,
            miembro.prospecto_pro_id as 'id_prospecto',
            miembro.empresalocal_emp_id,
            (SELECT `emp_nombre` FROM `empresalocal` WHERE emp_id = miembro.empresalocal_emp_id) as 'nombre_empresa',
            miembro.mie_fechamodificacion, 
            miembro.mie_fecharegistro, 
            miembro.mie_id_usuario, 
            miembro.mie_descripcion_desafio,
            miembro.mie_participacion_correo,               
            miembro.Profesion_prof_id,
            miembro.categoria_cat_id, 
            miembro.cancelled,
            member_status.mem_sta_descripcion,
            persona.per_id ,  
            persona.per_nombre, 
            persona.per_apellido, 
            (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id LIMIT 1) as 'correo',
            (SELECT  `tel_descripcion` FROM `telefono` WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil',
            (SELECT  concat (persona.per_nombre ,' ', persona.per_apellido) as 'nombre_forum'  
             FROM persona, perfil, usuario 
             WHERE usuario.usu_id= miembro.forum_usu_id 
             and usuario.Persona_per_id= persona.per_id and usuario.perfil_per_id= perfil.per_id LIMIT 1) as 'nombre_forum'

            FROM  miembro  
            INNER join persona on miembro.Persona_per_id = persona.per_id 
            INNER join member_status on miembro.status_member_id = member_status.mem_sta_id
            where miembro.forum_usu_id = _permiso and 
            miembro.empresalocal_emp_id in (SELECT  `empresalocal_emp_id` FROM `empresa_industria` WHERE industria_ind_id = _id)
            and miembro.cancelled = 0 
            ORDER BY TRIM(miembro.mie_codigo);
        end if;
        if _key = '6' then  
            SELECT  
            miembro.mie_id,
            miembro.grupo_id,
            miembro.mie_codigo,
            miembro.prospecto_pro_id as 'id_prospecto',
            miembro.empresalocal_emp_id,
            (SELECT `emp_nombre` FROM `empresalocal` WHERE emp_id = miembro.empresalocal_emp_id) as 'nombre_empresa',
            miembro.mie_fechamodificacion, 
            miembro.mie_fecharegistro, 
            miembro.mie_id_usuario, 
            miembro.mie_descripcion_desafio,
            miembro.mie_participacion_correo,               
            miembro.Profesion_prof_id,
            miembro.categoria_cat_id, 
            miembro.cancelled,
            member_status.mem_sta_descripcion,
            persona.per_id ,  
            persona.per_nombre, 
            persona.per_apellido, 
            (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id LIMIT 1) as 'correo',
            (SELECT  `tel_descripcion` FROM `telefono` WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil',
            (SELECT  concat (persona.per_nombre ,' ', persona.per_apellido) as 'nombre_forum'  
             FROM persona, perfil, usuario 
             WHERE usuario.usu_id= miembro.forum_usu_id 
             and usuario.Persona_per_id= persona.per_id and usuario.perfil_per_id= perfil.per_id LIMIT 1) as 'nombre_forum'

            FROM  miembro  
            INNER join persona on miembro.Persona_per_id = persona.per_id 
            INNER join member_status on miembro.status_member_id = member_status.mem_sta_id
            inner join grupos on (miembro.grupo_id = grupos.gru_id)
            where miembro.forum_usu_id = _permiso and miembro.cancelled  = 0
            and grupos.agrup in (_id)
            ORDER BY TRIM(miembro.mie_codigo);
        end if;
  
    
    end if;
    
else   
  
  
if _permiso = '' then  
    if _key = '' then  
            SELECT  
            miembro.mie_id,
            miembro.grupo_id,
            miembro.mie_codigo,
            miembro.prospecto_pro_id as 'id_prospecto',
            miembro.empresalocal_emp_id,
            (SELECT `emp_nombre` FROM `empresalocal` WHERE emp_id = miembro.empresalocal_emp_id) as 'nombre_empresa',
            miembro.mie_fechamodificacion, 
            miembro.mie_fecharegistro, 
            miembro.mie_id_usuario, 
            miembro.mie_descripcion_desafio,
            miembro.mie_participacion_correo,               
            miembro.Profesion_prof_id,
            miembro.categoria_cat_id, 
            miembro.cancelled,
            persona.per_id ,  
            persona.per_nombre, 
            member_status.mem_sta_descripcion,
            persona.per_apellido, 
            (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id LIMIT 1) as 'correo',
            (SELECT  `tel_descripcion` FROM `telefono` WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil',
            (SELECT  concat (persona.per_nombre ,' ', persona.per_apellido) as 'nombre_forum'  
             FROM persona, perfil, usuario 
             WHERE usuario.usu_id= miembro.forum_usu_id 
             and usuario.Persona_per_id= persona.per_id and usuario.perfil_per_id= perfil.per_id LIMIT 1) as 'nombre_forum'
            FROM  miembro  
            INNER join persona on miembro.Persona_per_id = persona.per_id 
            INNER join member_status on miembro.status_member_id = member_status.mem_sta_id
            ORDER BY TRIM(miembro.mie_codigo);
        end if;
       if _key = '1' then  
            SELECT  
            miembro.mie_id,
            miembro.grupo_id,
            miembro.mie_codigo,
            miembro.prospecto_pro_id as 'id_prospecto',
            miembro.empresalocal_emp_id,
            (SELECT `emp_nombre` FROM `empresalocal` WHERE emp_id = miembro.empresalocal_emp_id) as 'nombre_empresa',
            miembro.mie_fechamodificacion, 
            miembro.mie_fecharegistro, 
            miembro.mie_id_usuario, 
            miembro.mie_descripcion_desafio,
            miembro.mie_participacion_correo,               
            miembro.Profesion_prof_id,
            miembro.categoria_cat_id, 
            miembro.cancelled,
            persona.per_id ,  
            persona.per_nombre, 
            persona.per_apellido, 
            member_status.mem_sta_descripcion,
            (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id LIMIT 1) as 'correo',
            (SELECT  `tel_descripcion` FROM `telefono` WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil',
            (SELECT  concat (persona.per_nombre ,' ', persona.per_apellido) as 'nombre_forum'  
             FROM persona, perfil, usuario 
             WHERE usuario.usu_id= miembro.forum_usu_id 
             and usuario.Persona_per_id= persona.per_id and usuario.perfil_per_id= perfil.per_id LIMIT 1) as 'nombre_forum'

            FROM  miembro  
            INNER join persona on miembro.Persona_per_id = persona.per_id 
            INNER join member_status on miembro.status_member_id = member_status.mem_sta_id
            where miembro.grupo_id = _id
            ORDER BY TRIM(miembro.mie_codigo);
        end if;
        if _key = '2' then  
            SELECT  
            miembro.mie_id,
            miembro.grupo_id,
            miembro.mie_codigo,
            miembro.prospecto_pro_id as 'id_prospecto',
            miembro.empresalocal_emp_id,
            (SELECT `emp_nombre` FROM `empresalocal` WHERE emp_id = miembro.empresalocal_emp_id) as 'nombre_empresa',
            miembro.mie_fechamodificacion, 
            miembro.mie_fecharegistro, 
            miembro.mie_id_usuario, 
            miembro.mie_descripcion_desafio,
            miembro.mie_participacion_correo,               
            miembro.Profesion_prof_id,
            miembro.categoria_cat_id, 
            miembro.cancelled,
            member_status.mem_sta_descripcion,
            persona.per_id ,  
            persona.per_nombre, 
            persona.per_apellido, 
            (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id LIMIT 1) as 'correo',
            (SELECT  `tel_descripcion` FROM `telefono` WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil',
            (SELECT  concat (persona.per_nombre ,' ', persona.per_apellido) as 'nombre_forum'  
             FROM persona, perfil, usuario 
             WHERE usuario.usu_id= miembro.forum_usu_id 
             and usuario.Persona_per_id= persona.per_id and usuario.perfil_per_id= perfil.per_id LIMIT 1) as 'nombre_forum'

            FROM  miembro  
            INNER join persona on miembro.Persona_per_id = persona.per_id 
            INNER join member_status on miembro.status_member_id = member_status.mem_sta_id
            where miembro.forum_usu_id = _id
            ORDER BY TRIM(miembro.mie_codigo);
        end if;
        if _key = '3' then  
            SELECT  Distinct
            miembro.mie_id,
            miembro.grupo_id,
            miembro.mie_codigo,
            miembro.prospecto_pro_id as 'id_prospecto',
            miembro.empresalocal_emp_id,
            (SELECT `emp_nombre` FROM `empresalocal` WHERE emp_id = miembro.empresalocal_emp_id) as 'nombre_empresa',
            miembro.mie_fechamodificacion, 
            miembro.mie_fecharegistro, 
            miembro.mie_id_usuario, 
            miembro.mie_descripcion_desafio,
            member_status.mem_sta_descripcion,
            miembro.mie_participacion_correo,               
            miembro.Profesion_prof_id,
            miembro.categoria_cat_id, 
            miembro.cancelled,
            persona.per_id ,  
            persona.per_nombre, 
            persona.per_apellido, 
            (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id LIMIT 1) as 'correo',
            (SELECT  `tel_descripcion` FROM `telefono` WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil',
            (SELECT  concat (persona.per_nombre ,' ', persona.per_apellido) as 'nombre_forum'  
             FROM persona, perfil, usuario 
             WHERE usuario.usu_id= miembro.forum_usu_id 
             and usuario.Persona_per_id= persona.per_id and usuario.perfil_per_id= perfil.per_id LIMIT 1) as 'nombre_forum'

            FROM  miembro  
            INNER join persona on miembro.Persona_per_id = persona.per_id 
            INNER join member_status on miembro.status_member_id = member_status.mem_sta_id
            where miembro.mie_id in (SELECT  `miembro_mie_id` FROM `miembro_empresa` WHERE empresalocal_emp_id=_id) or miembro.empresalocal_emp_id =_id
            ORDER BY TRIM(miembro.mie_codigo);
        end if;
 
        if _key = '4' then  
            SELECT  Distinct
            miembro.mie_id,
            miembro.grupo_id,
            miembro.mie_codigo,
            miembro.prospecto_pro_id as 'id_prospecto',
            miembro.empresalocal_emp_id,
            (SELECT `emp_nombre` FROM `empresalocal` WHERE emp_id = miembro.empresalocal_emp_id) as 'nombre_empresa',
            miembro.mie_fechamodificacion, 
            miembro.mie_fecharegistro, 
            miembro.mie_id_usuario, 
            miembro.mie_descripcion_desafio,
            miembro.mie_participacion_correo,               
            miembro.Profesion_prof_id,
            miembro.categoria_cat_id, 
            miembro.cancelled,
            member_status.mem_sta_descripcion,
            persona.per_id ,  
            persona.per_nombre, 
            persona.per_apellido, 
            (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id LIMIT 1) as 'correo',
            (SELECT  `tel_descripcion` FROM `telefono` WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil',
            (SELECT  concat (persona.per_nombre ,' ', persona.per_apellido) as 'nombre_forum'  
             FROM persona, perfil, usuario 
             WHERE usuario.usu_id= miembro.forum_usu_id 
             and usuario.Persona_per_id= persona.per_id and usuario.perfil_per_id= perfil.per_id LIMIT 1) as 'nombre_forum'

            FROM  miembro  
            INNER join persona on miembro.Persona_per_id = persona.per_id 
            INNER join member_status on miembro.status_member_id = member_status.mem_sta_id
            where 
            miembro.mie_id in (SELECT  `miembro_mie_id` FROM `miembro_empresa` WHERE empresalocal_emp_id in (SELECT  `empresalocal_emp_id` FROM `empresa_industria` WHERE industria_ind_id = _id))
            or miembro.empresalocal_emp_id in (SELECT  `empresalocal_emp_id` FROM `empresa_industria` WHERE industria_ind_id = _id)
            ORDER BY TRIM(miembro.mie_codigo);
        end if;
        if _key = '5' then  
          if _id = '2' then
          SELECT  
            miembro.mie_id,
            miembro.grupo_id,
            miembro.mie_codigo,
            miembro.prospecto_pro_id as 'id_prospecto',
            miembro.empresalocal_emp_id,
            (SELECT `emp_nombre` FROM `empresalocal` WHERE emp_id = miembro.empresalocal_emp_id) as 'nombre_empresa',
            miembro.mie_fechamodificacion, 
            miembro.mie_fecharegistro, 
            miembro.mie_id_usuario, 
            miembro.mie_descripcion_desafio,
            miembro.mie_participacion_correo,               
            miembro.Profesion_prof_id,
            miembro.categoria_cat_id, 
            miembro.cancelled,
            persona.per_id ,  
            persona.per_nombre, 
            persona.per_apellido, 
            member_status.mem_sta_descripcion,
            (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id LIMIT 1) as 'correo',
            (SELECT  `tel_descripcion` FROM `telefono` WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil',
            (SELECT  concat (persona.per_nombre ,' ', persona.per_apellido) as 'nombre_forum'  
             FROM persona, perfil, usuario 
             WHERE usuario.usu_id= miembro.forum_usu_id 
             and usuario.Persona_per_id= persona.per_id and usuario.perfil_per_id= perfil.per_id LIMIT 1) as 'nombre_forum'

            FROM  miembro  
            INNER join persona on miembro.Persona_per_id = persona.per_id 
            INNER join member_status on miembro.status_member_id = member_status.mem_sta_id
            where miembro.cancelled = 1
            ORDER BY TRIM(miembro.mie_codigo);
          else 
          SELECT  
            miembro.mie_id,
            miembro.grupo_id,
            miembro.mie_codigo,
            miembro.prospecto_pro_id as 'id_prospecto',
            miembro.empresalocal_emp_id,
            (SELECT `emp_nombre` FROM `empresalocal` WHERE emp_id = miembro.empresalocal_emp_id) as 'nombre_empresa',
            miembro.mie_fechamodificacion, 
            miembro.mie_fecharegistro, 
            miembro.mie_id_usuario, 
            miembro.mie_descripcion_desafio,
            miembro.mie_participacion_correo,               
            miembro.Profesion_prof_id,
            miembro.categoria_cat_id, 
            miembro.cancelled,
            persona.per_id ,  
            persona.per_nombre, 
            persona.per_apellido, 
            member_status.mem_sta_descripcion,
            (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id LIMIT 1) as 'correo',
            (SELECT  `tel_descripcion` FROM `telefono` WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil',
            (SELECT  concat (persona.per_nombre ,' ', persona.per_apellido) as 'nombre_forum'  
             FROM persona, perfil, usuario 
             WHERE usuario.usu_id= miembro.forum_usu_id 
             and usuario.Persona_per_id= persona.per_id and usuario.perfil_per_id= perfil.per_id LIMIT 1) as 'nombre_forum'

            FROM  miembro  
            INNER join persona on miembro.Persona_per_id = persona.per_id 
            INNER join member_status on miembro.status_member_id = member_status.mem_sta_id
            where member_status.mem_sta_id = _id
            ORDER BY TRIM(miembro.mie_codigo);
          end if;
            
        end if;
        if _key = '6' then  
            SELECT  
            miembro.mie_id,
            miembro.grupo_id,
            miembro.mie_codigo,
            miembro.prospecto_pro_id as 'id_prospecto',
            miembro.empresalocal_emp_id,
            (SELECT `emp_nombre` FROM `empresalocal` WHERE emp_id = miembro.empresalocal_emp_id) as 'nombre_empresa',
            miembro.mie_fechamodificacion, 
            miembro.mie_fecharegistro, 
            miembro.mie_id_usuario, 
            miembro.mie_descripcion_desafio,
            miembro.mie_participacion_correo,               
            miembro.Profesion_prof_id,
            miembro.categoria_cat_id, 
            miembro.cancelled,
            persona.per_id ,  
            persona.per_nombre, 
            persona.per_apellido, 
            member_status.mem_sta_descripcion,
            (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id LIMIT 1) as 'correo',
            (SELECT  `tel_descripcion` FROM `telefono` WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil',
            (SELECT  concat (persona.per_nombre ,' ', persona.per_apellido) as 'nombre_forum'  
             FROM persona, perfil, usuario 
             WHERE usuario.usu_id= miembro.forum_usu_id 
             and usuario.Persona_per_id= persona.per_id and usuario.perfil_per_id= perfil.per_id LIMIT 1) as 'nombre_forum'
            FROM  miembro  
            INNER join persona on miembro.Persona_per_id = persona.per_id 
            INNER join member_status on miembro.status_member_id = member_status.mem_sta_id
            INNER join grupos on miembro.grupo_id = grupos.gru_id 
            where grupos.agrup in (_id) 
            ORDER BY TRIM(miembro.mie_codigo);
        end if;
    else
        if _key = '' then  
            SELECT  
            miembro.mie_id,
            miembro.grupo_id,
            miembro.mie_codigo,
            miembro.prospecto_pro_id as 'id_prospecto',
            miembro.empresalocal_emp_id,
            (SELECT `emp_nombre` FROM `empresalocal` WHERE emp_id = miembro.empresalocal_emp_id) as 'nombre_empresa',
            miembro.mie_fechamodificacion, 
            miembro.mie_fecharegistro, 
            miembro.mie_id_usuario, 
            miembro.mie_descripcion_desafio,
            miembro.mie_participacion_correo,               
            miembro.Profesion_prof_id,
            miembro.categoria_cat_id, 
            miembro.cancelled,
            member_status.mem_sta_descripcion,
            persona.per_id ,  
            persona.per_nombre, 
            persona.per_apellido, 
            (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id LIMIT 1) as 'correo',
            (SELECT  `tel_descripcion` FROM `telefono` WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil',
            (SELECT  concat (persona.per_nombre ,' ', persona.per_apellido) as 'nombre_forum'  
             FROM persona, perfil, usuario 
             WHERE usuario.usu_id= miembro.forum_usu_id 
             and usuario.Persona_per_id= persona.per_id and usuario.perfil_per_id= perfil.per_id LIMIT 1) as 'nombre_forum'

            FROM  miembro  
            INNER join persona on miembro.Persona_per_id = persona.per_id 
            INNER join member_status on miembro.status_member_id = member_status.mem_sta_id
            where miembro.forum_usu_id = _permiso
            ORDER BY TRIM(miembro.mie_codigo);
        end if;
        if _key = '3' then  
            SELECT  Distinct
            miembro.mie_id,
            miembro.grupo_id,
            miembro.mie_codigo,
            miembro.prospecto_pro_id as 'id_prospecto',
            miembro.empresalocal_emp_id,
            (SELECT `emp_nombre` FROM `empresalocal` WHERE emp_id = miembro.empresalocal_emp_id) as 'nombre_empresa',
            miembro.mie_fechamodificacion, 
            miembro.mie_fecharegistro, 
            miembro.mie_id_usuario, 
            miembro.mie_descripcion_desafio,
            miembro.mie_participacion_correo,               
            miembro.Profesion_prof_id,
            miembro.categoria_cat_id, 
            miembro.cancelled,
            member_status.mem_sta_descripcion,
            persona.per_id ,  
            persona.per_nombre, 
            persona.per_apellido, 
            (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id LIMIT 1) as 'correo',
            (SELECT  `tel_descripcion` FROM `telefono` WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil',
            (SELECT  concat (persona.per_nombre ,' ', persona.per_apellido) as 'nombre_forum'  
             FROM persona, perfil, usuario 
             WHERE usuario.usu_id= miembro.forum_usu_id 
             and usuario.Persona_per_id= persona.per_id and
             usuario.perfil_per_id= perfil.per_id LIMIT 1) as 'nombre_forum'

            FROM  miembro  
            INNER join persona on miembro.Persona_per_id = persona.per_id 
            INNER join member_status on miembro.status_member_id = member_status.mem_sta_id
            where miembro.forum_usu_id = _permiso and 
             miembro.empresalocal_emp_id =_id
            ORDER BY TRIM(miembro.mie_codigo);
        end if;

        if _key = '4' then  
            SELECT  Distinct
            miembro.mie_id,
            miembro.grupo_id,
            miembro.mie_codigo,
            miembro.prospecto_pro_id as 'id_prospecto',
            miembro.empresalocal_emp_id,
            (SELECT `emp_nombre` FROM `empresalocal` WHERE emp_id = miembro.empresalocal_emp_id) as 'nombre_empresa',
            miembro.mie_fechamodificacion, 
            miembro.mie_fecharegistro, 
            miembro.mie_id_usuario, 
            miembro.mie_descripcion_desafio,
            miembro.mie_participacion_correo,               
            miembro.Profesion_prof_id,
            miembro.categoria_cat_id, 
            miembro.cancelled,
            member_status.mem_sta_descripcion,
            persona.per_id ,  
            persona.per_nombre, 
            persona.per_apellido, 
            (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id LIMIT 1) as 'correo',
            (SELECT  `tel_descripcion` FROM `telefono` WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil',
            (SELECT  concat (persona.per_nombre ,' ', persona.per_apellido) as 'nombre_forum'  
             FROM persona, perfil, usuario 
             WHERE usuario.usu_id= miembro.forum_usu_id 
             and usuario.Persona_per_id= persona.per_id and usuario.perfil_per_id= perfil.per_id LIMIT 1) as 'nombre_forum'

            FROM  miembro  
            INNER join persona on miembro.Persona_per_id = persona.per_id 
            INNER join member_status on miembro.status_member_id = member_status.mem_sta_id
            where miembro.forum_usu_id = _permiso and 
            miembro.empresalocal_emp_id in (SELECT  `empresalocal_emp_id` FROM `empresa_industria` WHERE industria_ind_id = _id)
            ORDER BY TRIM(miembro.mie_codigo);
        end if;
        if _key = '6' then  
            SELECT  
            miembro.mie_id,
            miembro.grupo_id,
            miembro.mie_codigo,
            miembro.prospecto_pro_id as 'id_prospecto',
            miembro.empresalocal_emp_id,
            (SELECT `emp_nombre` FROM `empresalocal` WHERE emp_id = miembro.empresalocal_emp_id) as 'nombre_empresa',
            miembro.mie_fechamodificacion, 
            miembro.mie_fecharegistro, 
            miembro.mie_id_usuario, 
            miembro.mie_descripcion_desafio,
            miembro.mie_participacion_correo,               
            miembro.Profesion_prof_id,
            miembro.categoria_cat_id, 
            miembro.cancelled,
            member_status.mem_sta_descripcion,
            persona.per_id ,  
            persona.per_nombre, 
            persona.per_apellido, 
            (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id LIMIT 1) as 'correo',
            (SELECT  `tel_descripcion` FROM `telefono` WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil',
            (SELECT  concat (persona.per_nombre ,' ', persona.per_apellido) as 'nombre_forum'  
             FROM persona, perfil, usuario 
             WHERE usuario.usu_id= miembro.forum_usu_id 
             and usuario.Persona_per_id= persona.per_id and usuario.perfil_per_id= perfil.per_id LIMIT 1) as 'nombre_forum'

            FROM  miembro  
            INNER join persona on miembro.Persona_per_id = persona.per_id 
            INNER join member_status on miembro.status_member_id = member_status.mem_sta_id
            inner join grupos on (grupos.gru_id = miembro.grupo_id)
            where miembro.forum_usu_id = _permiso
            and grupos.agrup  in (_id) 
            ORDER BY TRIM(miembro.mie_codigo);
        end if;
  
    
    end if;
end if;  
    
END;
