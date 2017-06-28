CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_updateProspecto`(IN `_id_prospecto` INT, IN `_id_persona` INT, IN `_propietario` INT, IN `_nombre` VARCHAR(50), IN `_apellido` VARCHAR(50), IN `_titulo` INT, IN `_correo` VARCHAR(50), IN `_correo_2` VARCHAR(50), IN `_telefono` VARCHAR(50), IN `_celular` VARCHAR(50), IN `_correoparticipacion` INT, IN `_fn` DATE, IN `_fuente` INT, IN `_estado_propietario` INT, IN `_id_skype` VARCHAR(50), IN `_id_Twitter` VARCHAR(50), IN `_calle` TEXT, IN `_ciudad` TEXT, IN `_categoria` INT, IN `_id_usuario` VARCHAR(50), IN `_identificacion` VARCHAR(50), IN `_genero` VARCHAR(50), IN `_tipo_p` VARCHAR(50), IN `_lista_hobbies` TEXT, IN `_lista_desafios` TEXT, IN `_status` INT, IN `_observacion` TEXT, IN `_fecharegistro` TIMESTAMP, IN `_codigo` TEXT, IN `_lafuente` TEXT, IN `_id_empresa` TEXT)
BEGIN

set @esaplicante= (SELECT  `prosp_esaplicante` FROM `prospecto` WHERE pro_id=_id_prospecto);
if @esaplicante = '1' then

    set @ultimoforum= (SELECT  `forum_usu_id`FROM `prospecto` WHERE pro_id=_id_prospecto);
    if @ultimoforum <> _propietario then
        UPDATE `prospecto` SET `prosp_fechacambioforum`=_fecharegistro WHERE `pro_id`=_id_prospecto;
    end if;
     
if _estado_propietario = '0' then  
    UPDATE `prospecto` SET 
    `fuente_fue_id`=_fuente,
    `forum_usu_id`=_propietario,
    `categoria_cat_id`=_categoria,
    `Profesion_prof_id`=_titulo,
    `participacion_correo`=_correoparticipacion,
     prospecto.status_member_id = _status,
     prosp_usu_id=_id_usuario,
     prospecto.prosp_observacion =_observacion,
     prosp_codigo= _codigo,
     prosp_txtadicional= _lafuente,
     prosp_empresa= _id_empresa
     WHERE prospecto.pro_id=_id_prospecto;
else

     UPDATE `prospecto` SET 
    `fuente_fue_id`=_fuente,
    `forum_usu_id`=_propietario,
    `categoria_cat_id`=_categoria,
    `estadoprospecto_estpro_id`=_estado_propietario,
    `Profesion_prof_id`=_titulo,
    `participacion_correo`=_correoparticipacion,
     prospecto.status_member_id = _status,
     prosp_usu_id=_id_usuario,
     prospecto.prosp_observacion =_observacion,
     prosp_codigo= _codigo,
     prosp_txtadicional= _lafuente,
     prosp_empresa= _id_empresa
    WHERE prospecto.pro_id=_id_prospecto;
end if;
    
    



else

   UPDATE `prospecto` SET 
    `fuente_fue_id`=_fuente,
    `categoria_cat_id`=_categoria,
    `Profesion_prof_id`=_titulo,
    `participacion_correo`=_correoparticipacion,
     prospecto.status_member_id = _status,
     prosp_usu_id=_id_usuario,
     prospecto.prosp_observacion =_observacion,
     prosp_codigo= _codigo,
     prosp_txtadicional= _lafuente,
     prospecto.forum_usu_id=_propietario,
     prosp_empresa= _id_empresa
    WHERE prospecto.pro_id=_id_prospecto;
       
end if;
    
  UPDATE `persona` SET 
    `per_nombre`=_nombre,
    `per_apellido`=_apellido,
    `per_fechanacimiento`=_fn ,
    `per_tipo`=_tipo_p,
    `per_identificacion`=_identificacion
    ,`per_genero`=_genero WHERE `per_id`=_id_persona;


    if (SELECT COUNT(tel_id) FROM `telefono` WHERE `Persona_per_id`=_id_persona and `tel_tipo`='C') > 0  then
        UPDATE `telefono` SET `tel_descripcion`=_telefono WHERE `Persona_per_id`=_id_persona and `tel_tipo`='C';
    else
        INSERT INTO `telefono`( `tel_descripcion`, `tel_fecharegistro`,`Persona_per_id`, `tel_tipo`, `tel_id_usuario`, `tel_estado`) VALUES 
    (_telefono,_fecharegistro,_id_persona,'C',_id_usuario,'A'); 
    end if;  

    if (SELECT COUNT(tel_id) FROM `telefono` WHERE `Persona_per_id`=_id_persona and `tel_tipo`='M') > 0  then
        UPDATE `telefono` SET `tel_descripcion`=_celular WHERE `Persona_per_id`=_id_persona and `tel_tipo`='M';
    else
        INSERT INTO `telefono`( `tel_descripcion`, `tel_fecharegistro`,`Persona_per_id`, `tel_tipo`, `tel_id_usuario`, `tel_estado`) VALUES 
    (_celular,_fecharegistro,_id_persona,'M',_id_usuario,'A'); 
    end if;  


   if (SELECT COUNT(red_id) FROM `redsocial_prospecto` WHERE `prospecto_pro_id`=_id_prospecto and `red_tipo`='skype') > 0  then
        UPDATE `redsocial_prospecto` SET `red_descripcion`=_id_skype WHERE `prospecto_pro_id`=_id_prospecto and `red_tipo`='skype';
    else
        INSERT INTO `redsocial_prospecto`(`red_descripcion`, `red_tipo`, `prospecto_pro_id`) VALUES (_id_skype,'skype',_id_prospecto);
    end if;  

    if (SELECT COUNT(red_id) FROM `redsocial_prospecto` WHERE `prospecto_pro_id`=_id_prospecto and `red_tipo`='twitter') > 0  then
        UPDATE `redsocial_prospecto` SET `red_descripcion`=_id_Twitter WHERE `prospecto_pro_id`=_id_prospecto and `red_tipo`='twitter';
    else
        INSERT INTO `redsocial_prospecto`(`red_descripcion`, `red_tipo`, `prospecto_pro_id`) VALUES (_id_Twitter,'twitter',_id_prospecto);
    end if; 

    if (SELECT COUNT(dir_id) FROM `direccion` WHERE  Persona_per_id=_id_persona Limit 1) > 0  then
        UPDATE `direccion` SET `dir_calleprincipal`=_calle,`ciudad_ciu_id`=_ciudad WHERE Persona_per_id=_id_persona;
    else
         INSERT INTO `direccion`(`dir_calleprincipal`, `dir_callesecundaria`, `ciudad_ciu_id`, `Persona_per_id`,`dir_fecharegistro`, `dir_usu_id`) VALUES 
       (_calle,'',_ciudad,_id_persona,_fecharegistro,_id_usuario);
    end if;  
       
    if (SELECT COUNT(cor_id) FROM `correo` WHERE Persona_per_id=_id_persona and cor_tipo = 'Personal' LIMIT 1) > 0  then
            UPDATE `correo` SET `cor_descripcion`=_correo WHERE `Persona_per_id`=_id_persona and cor_tipo = 'Personal';
    else
        INSERT INTO `correo`( cor_tipo,`cor_descripcion`, `cor_fecharegistro`, `Persona_per_id`, `cor_id_usuario`, `cor_estado`) 
        VALUES ('Personal',_correo,_fecharegistro,_id_persona,_id_usuario,'A');  
    end if;  

    if (SELECT COUNT(cor_id) FROM `correo` WHERE Persona_per_id=_id_persona and cor_tipo = 'Secundario' LIMIT 1) > 0  then
            UPDATE `correo` SET `cor_descripcion`=_correo_2 WHERE `Persona_per_id`=_id_persona and cor_tipo = 'Secundario';
    else
        INSERT INTO `correo`( cor_tipo,`cor_descripcion`, `cor_fecharegistro`, `Persona_per_id`, `cor_id_usuario`, `cor_estado`) 
        VALUES ('Secundario',_correo_2,_fecharegistro,_id_persona,_id_usuario,'A');  
    end if;  


    DELETE FROM `prospecto_desafio` WHERE prospecto_pro_id=_id_prospecto;
    if _lista_desafios <> '' then      
        WHILE (LOCATE(',', _lista_desafios) > 0)
        DO
            SET @value = ELT(1, _lista_desafios);
            SET _lista_desafios= SUBSTRING(_lista_desafios, LOCATE(',',_lista_desafios) + 1);
            INSERT INTO `prospecto_desafio`( `prospecto_pro_id`, `desafio_des_id`) VALUES (_id_prospecto,@value);
        END WHILE;
    end if;
    

    DELETE FROM prospecto_hobbies WHERE prospecto_pro_id= _id_prospecto;
    if _lista_hobbies <> '' then      
        WHILE (LOCATE(',', _lista_hobbies) > 0)
        DO
            SET @value = ELT(1, _lista_hobbies);
            SET _lista_hobbies= SUBSTRING(_lista_hobbies, LOCATE(',',_lista_hobbies) + 1);

            INSERT INTO `prospecto_hobbies`( `hobbies_hob_id`, `prospecto_pro_id`) VALUES (@value,_id_prospecto);
        END WHILE;
    end if;

END;
