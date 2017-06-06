CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_createProspecto`(IN `_esaplicante` INT, IN `_propietario` INT, IN `_nombre` VARCHAR(50), IN `_apellido` VARCHAR(50), IN `_titulo` INT, IN `_correo` VARCHAR(50), IN `_correo_2` VARCHAR(50), IN `_telefono` VARCHAR(50), IN `_celular` VARCHAR(50), IN `_correoparticipacion` INT, IN `_fn` DATE, IN `_fuente` INT, IN `_estado_propietario` INT, IN `_id_skype` VARCHAR(50), IN `_id_Twitter` VARCHAR(50), IN `_calle` TEXT, IN `_ciudad` TEXT, IN `_categoria` INT, IN `_id_usuario` VARCHAR(50), IN `_identificacion` VARCHAR(50), IN `_genero` VARCHAR(50), IN `_tipo_p` VARCHAR(50), IN `_lista_hobbies` TEXT, IN `_lista_desafios` TEXT, IN `_status` INT, IN `_observacion` TEXT, IN `_fecharegistro` TIMESTAMP, IN `_codigo` TEXT, IN `_lafuente` TEXT, IN `_id_empresa` INT)
BEGIN
    DECLARE _LID_PERSONA int;
    DECLARE _LID_PROSPECTO int;

    INSERT INTO `persona`(`per_nombre`, `per_apellido`, `per_tipo`, `per_identificacion`, `per_fechanacimiento`, `per_genero`) 
    VALUES (_nombre,_apellido,_tipo_p,_identificacion,_fn,_genero);

    SET _LID_PERSONA = LAST_INSERT_ID();

        if _estado_propietario = '0' then

            INSERT INTO `prospecto`( `fuente_fue_id`, `Persona_per_id`, `forum_usu_id`, `categoria_cat_id`,  
                                    `prosp_fechamodificacion`, `prosp_fecharegistro`, `prosp_usu_id`, `Profesion_prof_id`, `participacion_correo`, 
                                    `prosp_codigo`, `prosp_esaplicante`, `status_member_id`, `prosp_observacion`, `prosp_esaplicanteesmiembro`,
                                     `prospecto_id`, `prosp_aprobado`,prosp_esprospectoaplicante,prosp_txtadicional,prosp_fechacambioforum,empresalocal_emp_id) 
                                    VALUES (_fuente,_LID_PERSONA,_propietario,_categoria,_fecharegistro,_fecharegistro,_id_usuario,
                                    _titulo,_correoparticipacion,_codigo,_esaplicante,_status,_observacion,'0','0','0','0',_lafuente,_fecharegistro,_id_empresa);
        else
            INSERT INTO `prospecto`( `fuente_fue_id`, `Persona_per_id`, `forum_usu_id`, `categoria_cat_id`, `estadoprospecto_estpro_id`, 
                                    `prosp_fechamodificacion`, `prosp_fecharegistro`, `prosp_usu_id`, `Profesion_prof_id`, `participacion_correo`, 
                                    `prosp_codigo`, `prosp_esaplicante`, `status_member_id`, `prosp_observacion`, `prosp_esaplicanteesmiembro`,
                                     `prospecto_id`, `prosp_aprobado`,prosp_esprospectoaplicante,prosp_txtadicional,prosp_fechacambioforum,empresalocal_emp_id) 
                                    VALUES (_fuente,_LID_PERSONA,_propietario,_categoria,_estado_propietario,_fecharegistro,_fecharegistro,_id_usuario,
                                    _titulo,_correoparticipacion,_codigo,_esaplicante,_status,_observacion,'0','0','0','0',_lafuente,_fecharegistro,_id_empresa);
        end if;

        

    SET _LID_PROSPECTO = LAST_INSERT_ID();

    if _correo <> '' then
        INSERT INTO `correo`(cor_tipo, `cor_descripcion`, `cor_fecharegistro`, `Persona_per_id`, `cor_id_usuario`, `cor_estado`) 
        VALUES ('Personal',_correo,_fecharegistro,_LID_PERSONA,_id_usuario,'A');
    end if;

    if _correo_2 <> '' then
        INSERT INTO `correo`(cor_tipo, `cor_descripcion`, `cor_fecharegistro`, `Persona_per_id`, `cor_id_usuario`, `cor_estado`) 
        VALUES ('Secundario',_correo_2,_fecharegistro,_LID_PERSONA,_id_usuario,'A');    
    end if;

    if _telefono <> '' then
        INSERT INTO `telefono`( `tel_descripcion`, `tel_fecharegistro`,`Persona_per_id`, `tel_tipo`, `tel_id_usuario`, `tel_estado`) VALUES 
        (_telefono,_fecharegistro,_LID_PERSONA,'C',_id_usuario,'A');
    end if;

    if _celular <> '' then
        INSERT INTO `telefono`( `tel_descripcion`, `tel_fecharegistro`,`Persona_per_id`, `tel_tipo`, `tel_id_usuario`, `tel_estado`) VALUES 
        (_celular,_fecharegistro,_LID_PERSONA,'M',_id_usuario,'A');
    end if;

    if  _ciudad <> '' then
    
        INSERT INTO `direccion`(`dir_calleprincipal`, `dir_callesecundaria`, `ciudad_ciu_id`, `Persona_per_id`,`dir_fecharegistro`, `dir_usu_id`) VALUES 
        (_calle,'',_ciudad,_LID_PERSONA,_fecharegistro,_id_usuario);
    end if;

    if _id_skype <> '' then
        INSERT INTO `redsocial_prospecto`(`red_descripcion`, `red_tipo`, `prospecto_pro_id`) VALUES (_id_skype,'skype',_LID_PROSPECTO);
    
    end if;


    if _id_Twitter <> '' then
   
        INSERT INTO `redsocial_prospecto`(`red_descripcion`, `red_tipo`, `prospecto_pro_id`) VALUES (_id_Twitter,'twitter',_LID_PROSPECTO);
    end if;

  
    if _lista_desafios <> '' then      
        WHILE (LOCATE(',', _lista_desafios) > 0)
        DO
            SET @value = ELT(1, _lista_desafios);
            SET _lista_desafios= SUBSTRING(_lista_desafios, LOCATE(',',_lista_desafios) + 1);
            INSERT INTO `prospecto_desafio`( `prospecto_pro_id`, `desafio_des_id`) VALUES (_LID_PROSPECTO,@value);
        END WHILE;
    end if;
    

    if _lista_hobbies <> '' then      
        WHILE (LOCATE(',', _lista_hobbies) > 0)
        DO
            SET @value = ELT(1, _lista_hobbies);
            SET _lista_hobbies= SUBSTRING(_lista_hobbies, LOCATE(',',_lista_hobbies) + 1);

            INSERT INTO `prospecto_hobbies`( `hobbies_hob_id`, `prospecto_pro_id`) VALUES (@value,_LID_PROSPECTO);
        END WHILE;
    end if;

END;
