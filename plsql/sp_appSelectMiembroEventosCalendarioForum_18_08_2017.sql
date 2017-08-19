CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_appSelectMiembroEventosCalendarioForum`(IN `_id_user` INT, IN `_f_i` TIMESTAMP, IN `_f_f` TIMESTAMP)
BEGIN

            SELECT DISTINCT
                    evento.eve_id as 'id'
                    ,evento.eve_nombre as 'title'
                    ,evento.eve_responsable as 'responsable'
                    ,evento.eve_descripcion as 'descripcion'
                    ,(SELECT  dir_calleprincipal FROM direccion WHERE dir_id= direccion_id) as 'direccion'
					,evento.ciudad_ciu_id as 'idCiudad'
                    ,evento.eve_fechainicio as 'startTime'
                    ,evento.eve_fechafin as 'endTime'
                    ,DATE_FORMAT(evento.eve_fechainicio, '%m/%d/%Y %H:%i:%s') as 'fi'
                    ,DATE_FORMAT(evento.eve_fechafin, '%m/%d/%Y %H:%i:%s') as 'ff'
                    ,CASE eve_todoeldia
                        WHEN '1' THEN 'true'
                        WHEN '0' THEN 'false'
                     END as 'allDay'
                    ,tipo_evento.tip_eve_codigo_color as 'backgroundColor'
                    ,'#0073b7' as 'borderColor'
                ,CASE eve_mis_grupos
                    WHEN '1' THEN 'Mis Grupos'
                    WHEN '0' THEN ''
                 END as 'mis_grupos'
                 ,CASE eve_todos_grupos
                    WHEN '1' THEN 'Todos los Grupos'
                    WHEN '0' THEN (select g.gru_descripcion from evento_grupo eg,grupos g where eg.grupos_gru_id=g.gru_id and evento_eve_id=evento.eve_id limit 1 )
                 END as 'todos_grupos'
                 ,(SELECT `eve_aco_descripcion` FROM `evento_acompanado` WHERE eve_aco_id = evento.evento_acompanado) as 'acompanado',
tipo_evento_id as tipo
                FROM evento , tipo_evento ,  evento_grupo
               INNER JOIN  grupos on grupos.gru_id = evento_grupo.grupos_gru_id 
            WHERE evento.tipo_evento_id =tipo_evento.tip_eve_id 
            and evento.eve_id = evento_grupo.evento_eve_id 
            and evento_grupo.grupos_gru_id = grupos.gru_id
            and (evento.eve_fechainicio between _f_i and _f_f)
            and (_id_user=-1 OR grupos.gru_id = ( SELECT miembro.grupo_id FROM miembro  WHERE mie_id= _id_user LIMIT 1)  )    

union
           
            SELECT DISTINCT
                evento.eve_id as 'id'
                ,evento.eve_nombre as 'title'
                ,evento.eve_responsable as 'responsable'
                ,evento.eve_descripcion as 'descripcion'
                ,(SELECT  dir_calleprincipal FROM direccion WHERE dir_id= direccion_id) as 'direccion'
,22 as 'idCiudad'
                ,evento.eve_fechainicio as 'startTime'
                ,evento.eve_fechafin as 'endTime'
                ,DATE_FORMAT(evento.eve_fechainicio, '%m/%d/%Y %H:%i:%s') as 'fi'
                ,DATE_FORMAT(evento.eve_fechafin, '%m/%d/%Y %H:%i:%s') as 'ff'
                ,CASE eve_todoeldia
                    WHEN '1' THEN 'true'
                    WHEN '0' THEN 'false'
                 END as 'allDay'
                ,tipo_evento.tip_eve_codigo_color as 'backgroundColor'
                ,'#0073b7' as 'borderColor'
            ,CASE eve_mis_grupos
                WHEN '1' THEN 'Mis Grupos'
                WHEN '0' THEN ''
             END as 'mis_grupos'
             ,CASE eve_todos_grupos
                WHEN '1' THEN 'Todos los Grupos'
                WHEN '0' THEN ''
             END as 'todos_grupos'
             ,(SELECT `eve_aco_descripcion` FROM `evento_acompanado` WHERE eve_aco_id = evento.evento_acompanado) as 'acompanado',
tipo_evento_id as tipo
            FROM evento , tipo_evento 
            WHERE evento.tipo_evento_id = tipo_evento.tip_eve_id 
            and  evento.eve_mis_grupos = '1'
            and (evento.eve_fechainicio between _f_i and _f_f)
            and evento.eve_id_usuario = ( SELECT miembro.forum_usu_id FROM usuario, persona, perfil,miembro  
                                            WHERE usuario.usu_id= _id_user
                                            and evento.eve_fecharegistro >= miembro.mie_fecharegistro
                                            and usuario.Persona_per_id= persona.per_id and usuario.perfil_per_id= perfil.per_id 
                                            and miembro.Persona_per_id= persona.per_id LIMIT 1)


union

            SELECT DISTINCT
                evento.eve_id as 'id'
                ,evento.eve_nombre as 'title'
                ,evento.eve_responsable as 'responsable'
                ,evento.eve_descripcion as 'descripcion'
                ,(SELECT  dir_calleprincipal FROM direccion WHERE dir_id= direccion_id) as 'direccion'
,22 as 'idCiudad'
                ,evento.eve_fechainicio as 'startTime'
                ,evento.eve_fechafin as 'endTime'
                ,DATE_FORMAT(evento.eve_fechainicio, '%m/%d/%Y %H:%i:%s') as 'fi'
                ,DATE_FORMAT(evento.eve_fechafin, '%m/%d/%Y %H:%i:%s') as 'ff'
                ,CASE eve_todoeldia
                    WHEN '1' THEN 'true'
                    WHEN '0' THEN 'false'
                 END as 'allDay'
                ,tipo_evento.tip_eve_codigo_color as 'backgroundColor'
                ,'#0073b7' as 'borderColor'
            ,CASE eve_mis_grupos
                WHEN '1' THEN 'Mis Grupos'
                WHEN '0' THEN ''
             END as 'mis_grupos'
             ,CASE eve_todos_grupos
                WHEN '1' THEN 'Todos los Grupos'
                WHEN '0' THEN ''
             END as 'todos_grupos'
             ,(SELECT `eve_aco_descripcion` FROM `evento_acompanado` WHERE eve_aco_id = evento.evento_acompanado) as 'acompanado',
tipo_evento_id as tipo
                FROM evento , tipo_evento 
            WHERE evento.tipo_evento_id = tipo_evento.tip_eve_id 
            and  evento.eve_todos_grupos = '1'
            and (evento.eve_fechainicio between _f_i and _f_f)
            and evento.eve_fecharegistro >= ( SELECT miembro.mie_fecharegistro FROM miembro  
                                            WHERE mie_id= _id_user LIMIT 1); 

END;
