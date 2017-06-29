CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_selectProspectoFiltros`(IN `_id` INT, IN `_key` INT, IN `_esaplicante` INT)
BEGIN
  if _key = '' then  
    	if _esaplicante = '0' then 
            SELECT   
            persona.per_id, 
            persona.per_nombre, 
            persona.per_apellido,  
            prospecto.pro_id as '_id_prospecto',
            prospecto.prosp_codigo,
            prospecto.prosp_fechamodificacion, 
            prospecto.prosp_fecharegistro, 
            prospecto.prosp_usu_id, 
            prospecto.participacion_correo,
            prospecto.prosp_observacion,
            case prospecto.prosp_aprobado when '0' then 'NO'
            when '1' then 'SI'
            end aprobado,
            prospecto.prosp_esaplicante,  prospecto.prosp_esaplicanteesmiembro, prospecto.prospecto_id, prospecto.prosp_aprobado,
            (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id and cor_tipo='Personal' LIMIT 1) as 'correo',
            (SELECT  `tel_descripcion` FROM `telefono` WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil',
            (SELECT  concat (persona.per_nombre ,' ', persona.per_apellido) as 'nombre_forum'  FROM persona, perfil, usuario 
                WHERE usuario.usu_id= prospecto.forum_usu_id and usuario.Persona_per_id= persona.per_id and usuario.perfil_per_id= perfil.per_id LIMIT 1) as 'nombre_forum' 
            FROM  prospecto  
            INNER join persona on prospecto.Persona_per_id = persona.per_id
            where prosp_esaplicante = _esaplicante 
            and prosp_esprospectoaplicante = '0'
            ORDER BY TRIM(persona.per_apellido);
            
        else
            SELECT   
            persona.per_id, 
            persona.per_nombre, 
            persona.per_apellido,  
            prospecto.pro_id as '_id_prospecto',
            prospecto.prosp_codigo,
            prospecto.prosp_fechamodificacion, 
            prospecto.prosp_fecharegistro, 
            prospecto.prosp_usu_id, 
            prospecto.participacion_correo,
            prospecto.prosp_observacion,
            prospecto.prosp_esaplicante, 
            member_status.mem_sta_descripcion,
            member_status.mem_sta_codigo,
            prospecto.prosp_esaplicanteesmiembro, prospecto.prospecto_id, prospecto.prosp_aprobado,
            (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id and cor_tipo='Personal' LIMIT 1) as 'correo',
            (SELECT  `tel_descripcion` FROM `telefono` WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil',
            (SELECT  concat (persona.per_nombre ,' ', persona.per_apellido) as 'nombre_forum'  FROM persona, perfil, usuario 
                WHERE usuario.usu_id= prospecto.forum_usu_id and usuario.Persona_per_id= persona.per_id and usuario.perfil_per_id= perfil.per_id LIMIT 1) as 'nombre_forum' 
            FROM  prospecto  
            INNER join persona on prospecto.Persona_per_id = persona.per_id
            left join member_status on (member_status.mem_sta_id=prospecto.status_member_id)
            where prosp_esaplicante = _esaplicante 
            and prosp_esaplicanteesmiembro = '0'
            ORDER BY TRIM(persona.per_apellido);
          end if;  
        end if;
        

        if _key = '2' then  
            if _esaplicante = '0' then 
                SELECT   
                persona.per_id, 
                persona.per_nombre, 
                persona.per_apellido,  
                prospecto.pro_id as '_id_prospecto',
                prospecto.prosp_codigo,
                prospecto.prosp_fechamodificacion, 
                prospecto.prosp_fecharegistro, 
                prospecto.prosp_usu_id, 
                prospecto.participacion_correo,
                prospecto.prosp_observacion,
                case prospecto.prosp_aprobado when '0' then 'NO'
                when '1' then 'SI'
                end aprobado,
                prospecto.prosp_esaplicante,  prospecto.prosp_esaplicanteesmiembro, prospecto.prospecto_id, prospecto.prosp_aprobado,
                (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id and cor_tipo='Personal' LIMIT 1) as 'correo',
                (SELECT  `tel_descripcion` FROM `telefono` WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil',
                (SELECT  concat (persona.per_nombre ,' ', persona.per_apellido) as 'nombre_forum'  FROM persona, perfil, usuario 
                    WHERE usuario.usu_id= prospecto.forum_usu_id and usuario.Persona_per_id= persona.per_id and usuario.perfil_per_id= perfil.per_id LIMIT 1) as 'nombre_forum' 
                FROM  prospecto  
                INNER join persona on prospecto.Persona_per_id = persona.per_id
                where prosp_esaplicante = _esaplicante 
                and prosp_esprospectoaplicante = '0'
                and prospecto.forum_usu_id = _id
                ORDER BY TRIM(persona.per_apellido);

            else
                SELECT   
                persona.per_id, 
                persona.per_nombre, 
                persona.per_apellido,  
                prospecto.pro_id as '_id_prospecto',
                prospecto.prosp_codigo,
                prospecto.prosp_fechamodificacion, 
                prospecto.prosp_fecharegistro, 
                prospecto.prosp_usu_id, 
                prospecto.participacion_correo,
                prospecto.prosp_observacion,
                prospecto.prosp_esaplicante, 
                prospecto.prosp_esaplicanteesmiembro, prospecto.prospecto_id, prospecto.prosp_aprobado,
                member_status.mem_sta_codigo,
                (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id and cor_tipo='Personal' LIMIT 1) as 'correo',
                (SELECT  `tel_descripcion` FROM `telefono` WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil',
                (SELECT  concat (persona.per_nombre ,' ', persona.per_apellido) as 'nombre_forum'  FROM persona, perfil, usuario 
                    WHERE usuario.usu_id= prospecto.forum_usu_id and usuario.Persona_per_id= persona.per_id and usuario.perfil_per_id= perfil.per_id LIMIT 1) as 'nombre_forum' 
                FROM  prospecto  
                INNER join persona on prospecto.Persona_per_id = persona.per_id
                left join member_status on (member_status.mem_sta_id=prospecto.status_member_id)
                where prosp_esaplicante = _esaplicante 
                and prosp_esaplicanteesmiembro = '0'
                and prospecto.forum_usu_id = _id
                ORDER BY TRIM(persona.per_apellido);
              end if;  
        end if;
        if _key = '3' then  
               if _esaplicante = '0' then 
                SELECT   DISTINCT
                persona.per_id, 
                persona.per_nombre, 
                persona.per_apellido,  
                prospecto.pro_id as '_id_prospecto',
                prospecto.prosp_codigo,
                prospecto.prosp_fechamodificacion, 
                prospecto.prosp_fecharegistro, 
                prospecto.prosp_usu_id, 
                prospecto.participacion_correo,
                prospecto.prosp_observacion,
                case prospecto.prosp_aprobado when '0' then 'NO'
                when '1' then 'SI'
                end aprobado,
                prospecto.prosp_esaplicante,  prospecto.prosp_esaplicanteesmiembro, prospecto.prospecto_id, prospecto.prosp_aprobado,
                (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id and cor_tipo='Personal' LIMIT 1) as 'correo',
                (SELECT  `tel_descripcion` FROM `telefono` WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil',
                (SELECT  concat (persona.per_nombre ,' ', persona.per_apellido) as 'nombre_forum'  FROM persona, perfil, usuario 
                    WHERE usuario.usu_id= prospecto.forum_usu_id and usuario.Persona_per_id= persona.per_id and usuario.perfil_per_id= perfil.per_id LIMIT 1) as 'nombre_forum' 
                FROM  prospecto  
                INNER join persona on prospecto.Persona_per_id = persona.per_id
                where prosp_esaplicante = _esaplicante 
                and prosp_esprospectoaplicante = '0'
                and (prospecto.pro_id in (SELECT  `prospecto_prosp_id` FROM `prospecto_empresa` WHERE empresalocal_emp_id= _id) or prospecto.empresalocal_emp_id = _id)
                ORDER BY TRIM(persona.per_apellido);

            else
                SELECT   DISTINCT
                persona.per_id, 
                persona.per_nombre, 
                persona.per_apellido,  
                prospecto.pro_id as '_id_prospecto',
                prospecto.prosp_codigo,
                prospecto.prosp_fechamodificacion, 
                prospecto.prosp_fecharegistro, 
                prospecto.prosp_usu_id, 
                prospecto.participacion_correo,
                prospecto.prosp_observacion,
                prospecto.prosp_esaplicante, 
                member_status.mem_sta_codigo,
                prospecto.prosp_esaplicanteesmiembro, prospecto.prospecto_id, prospecto.prosp_aprobado,
                (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id and cor_tipo='Personal' LIMIT 1) as 'correo',
                (SELECT  `tel_descripcion` FROM `telefono` WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil',
                (SELECT  concat (persona.per_nombre ,' ', persona.per_apellido) as 'nombre_forum'  FROM persona, perfil, usuario 
                    WHERE usuario.usu_id= prospecto.forum_usu_id and usuario.Persona_per_id= persona.per_id and usuario.perfil_per_id= perfil.per_id LIMIT 1) as 'nombre_forum' 
                FROM  prospecto  
                INNER join persona on prospecto.Persona_per_id = persona.per_id
                 left join member_status on (member_status.mem_sta_id=prospecto.status_member_id)
                where prosp_esaplicante = _esaplicante 
                and prosp_esaplicanteesmiembro = '0'
                 and (prospecto.pro_id in (SELECT  `prospecto_prosp_id` FROM `prospecto_empresa` WHERE empresalocal_emp_id= _id) or prospecto.empresalocal_emp_id = _id)
                ORDER BY TRIM(persona.per_apellido);
              end if;
        end if;

        if _key = '4' then  
               if _esaplicante = '0' then 
                SELECT   
                persona.per_id, 
                persona.per_nombre, 
                persona.per_apellido,  
                prospecto.pro_id as '_id_prospecto',
                prospecto.prosp_codigo,
                prospecto.prosp_fechamodificacion, 
                prospecto.prosp_fecharegistro, 
                prospecto.prosp_usu_id, 
                prospecto.participacion_correo,
                prospecto.prosp_observacion,
                case prospecto.prosp_aprobado when '0' then 'NO'
                when '1' then 'SI'
                end aprobado,
                prospecto.prosp_esaplicante,  prospecto.prosp_esaplicanteesmiembro, prospecto.prospecto_id, prospecto.prosp_aprobado,
                (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id and cor_tipo='Personal' LIMIT 1) as 'correo',
                (SELECT  `tel_descripcion` FROM `telefono` WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil',
                (SELECT  concat (persona.per_nombre ,' ', persona.per_apellido) as 'nombre_forum'  FROM persona, perfil, usuario 
                    WHERE usuario.usu_id= prospecto.forum_usu_id and usuario.Persona_per_id= persona.per_id and usuario.perfil_per_id= perfil.per_id LIMIT 1) as 'nombre_forum' 
                FROM  prospecto  
                INNER join persona on prospecto.Persona_per_id = persona.per_id
                where prosp_esaplicante = _esaplicante 
                and prosp_esprospectoaplicante = '0'
                and (prospecto.pro_id in (SELECT  `prospecto_prosp_id` FROM `prospecto_empresa` WHERE empresalocal_emp_id in (SELECT `empresalocal_emp_id` FROM `empresa_industria` WHERE industria_ind_id= _id)) 
                        or  prospecto.empresalocal_emp_id in (SELECT `empresalocal_emp_id` FROM `empresa_industria` WHERE industria_ind_id= _id))
                ORDER BY TRIM(persona.per_apellido);

            else
                SELECT   
                persona.per_id, 
                persona.per_nombre, 
                persona.per_apellido,  
                prospecto.pro_id as '_id_prospecto',
                prospecto.prosp_codigo,
                prospecto.prosp_fechamodificacion, 
                prospecto.prosp_fecharegistro, 
                prospecto.prosp_usu_id, 
                prospecto.participacion_correo,
                prospecto.prosp_observacion,
                prospecto.prosp_esaplicante, 
                member_status.mem_sta_codigo,
                prospecto.prosp_esaplicanteesmiembro, prospecto.prospecto_id, prospecto.prosp_aprobado,
                (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id and cor_tipo='Personal' LIMIT 1) as 'correo',
                (SELECT  `tel_descripcion` FROM `telefono` WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil',
                (SELECT  concat (persona.per_nombre ,' ', persona.per_apellido) as 'nombre_forum'  FROM persona, perfil, usuario 
                    WHERE usuario.usu_id= prospecto.forum_usu_id and usuario.Persona_per_id= persona.per_id and usuario.perfil_per_id= perfil.per_id LIMIT 1) as 'nombre_forum' 
                FROM  prospecto  
                INNER join persona on prospecto.Persona_per_id = persona.per_id
                left join member_status on (member_status.mem_sta_id=prospecto.status_member_id)
                where prosp_esaplicante = _esaplicante 
                and prosp_esaplicanteesmiembro = '0'
                and (prospecto.pro_id in (SELECT  `prospecto_prosp_id` FROM `prospecto_empresa` WHERE empresalocal_emp_id in (SELECT `empresalocal_emp_id` FROM `empresa_industria` WHERE industria_ind_id= _id)) 
                        or  prospecto.empresalocal_emp_id in (SELECT `empresalocal_emp_id` FROM `empresa_industria` WHERE industria_ind_id= _id))
                ORDER BY TRIM(persona.per_apellido);
              end if;
        end if; 
        
        
        if _key = '5' then  
               if _esaplicante = '0' then 
                SELECT   
                persona.per_id, 
                persona.per_nombre, 
                persona.per_apellido,  
                prospecto.pro_id as '_id_prospecto',
                prospecto.prosp_codigo,
                prospecto.prosp_fechamodificacion, 
                prospecto.prosp_fecharegistro, 
                prospecto.prosp_usu_id, 
                prospecto.participacion_correo,
                prospecto.prosp_observacion,
                case prospecto.prosp_aprobado when '0' then 'NO'
                when '1' then 'SI'
                end aprobado,
                prospecto.prosp_esaplicante,  prospecto.prosp_esaplicanteesmiembro, prospecto.prospecto_id, prospecto.prosp_aprobado,
                (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id and cor_tipo='Personal' LIMIT 1) as 'correo',
                (SELECT  `tel_descripcion` FROM `telefono` WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil',
                (SELECT  concat (persona.per_nombre ,' ', persona.per_apellido) as 'nombre_forum'  FROM persona, perfil, usuario 
                    WHERE usuario.usu_id= prospecto.forum_usu_id and usuario.Persona_per_id= persona.per_id and usuario.perfil_per_id= perfil.per_id LIMIT 1) as 'nombre_forum' 
                FROM  prospecto  
                INNER join persona on prospecto.Persona_per_id = persona.per_id
                where prosp_esaplicante = _esaplicante 
                and prosp_esprospectoaplicante = '0'
                and status_member_id = _id
                ORDER BY TRIM(persona.per_apellido);

            else
                SELECT   
                persona.per_id, 
                persona.per_nombre, 
                persona.per_apellido,  
                prospecto.pro_id as '_id_prospecto',
                prospecto.prosp_codigo,
                prospecto.prosp_fechamodificacion, 
                prospecto.prosp_fecharegistro, 
                prospecto.prosp_usu_id, 
                prospecto.participacion_correo,
                prospecto.prosp_observacion,
                prospecto.prosp_esaplicante, 
                member_status.mem_sta_codigo,
                prospecto.prosp_esaplicanteesmiembro, prospecto.prospecto_id, prospecto.prosp_aprobado,
                (SELECT  `cor_descripcion`  FROM `correo` WHERE Persona_per_id=persona.per_id and cor_tipo='Personal' LIMIT 1) as 'correo',
                (SELECT  `tel_descripcion` FROM `telefono` WHERE Persona_per_id=persona.per_id and tel_tipo= 'M' LIMIT 1 ) as 'movil',
                (SELECT  concat (persona.per_nombre ,' ', persona.per_apellido) as 'nombre_forum'  FROM persona, perfil, usuario 
                    WHERE usuario.usu_id= prospecto.forum_usu_id and usuario.Persona_per_id= persona.per_id and usuario.perfil_per_id= perfil.per_id LIMIT 1) as 'nombre_forum' 
                FROM  prospecto  
                INNER join persona on prospecto.Persona_per_id = persona.per_id
                left join member_status on (member_status.mem_sta_id=prospecto.status_member_id)
                where prosp_esaplicante = _esaplicante 
                and prosp_esaplicanteesmiembro = '0'
                and status_member_id = _id
                ORDER BY TRIM(persona.per_apellido);
              end if;
        end if; 
END;
