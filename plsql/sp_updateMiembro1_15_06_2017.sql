CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_updateMiembro1`(IN `_id_miembro` INT, IN `_id_persona` INT, IN `_propietario` INT, IN `_nombre` VARCHAR(50), IN `_apellido` VARCHAR(50), IN `_titulo` INT, IN `_correo` VARCHAR(50), IN `_correo_2` VARCHAR(50), IN `_telefono` VARCHAR(50), IN `_celular` VARCHAR(50), IN `_correoparticipacion` INT, IN `_fn` DATE, IN `_id_skype` VARCHAR(50), IN `_id_Twitter` VARCHAR(50), IN `_calle` VARCHAR(50), IN `_ciudad` VARCHAR(50), IN `_categoria` INT, IN `_desafios` TEXT, IN `_identificacion` VARCHAR(50), IN `_genero` VARCHAR(50), IN `_tipo_p` VARCHAR(50), IN `_lista_hobbies` VARCHAR(250), IN `_lista_desafios` VARCHAR(250), IN `_id_grupo` INT, IN `_mie_codigo` VARCHAR(50), IN `_id_usuario` VARCHAR(10), IN `_fecharegistro` TIMESTAMP, IN `_id_membresia` INT, IN `_id_status` INT, IN `_modificadoglobal` INT, IN `_observacion` TEXT, IN `_id_empresa` INT, IN `_precio_esp` VARCHAR(50))
BEGIN




if _id_status = 2 then
UPDATE miembro 
SET 
miembro.precio_esp=_precio_esp,
miembro.empresalocal_emp_id=_id_empresa,
miembro.mie_observacion= _observacion,
miembro.modificado_global = _modificadoglobal,
mie_id_usuario=_id_usuario,
grupo_id=_id_grupo,mie_codigo=_mie_codigo,categoria_cat_id=_categoria,
forum_usu_id=_propietario,Profesion_prof_id=_titulo,mie_descripcion_desafio=_desafios,
mie_participacion_correo=_correoparticipacion ,
status_member_id=_id_status, cancelled = 1, mie_fecha_cambio_status = now() 
WHERE mie_id=_id_miembro;
else 
UPDATE miembro 
SET 
miembro.precio_esp=_precio_esp,
miembro.empresalocal_emp_id=_id_empresa,
miembro.mie_observacion= _observacion,
miembro.modificado_global = _modificadoglobal,
mie_id_usuario=_id_usuario,
grupo_id=_id_grupo,mie_codigo=_mie_codigo,categoria_cat_id=_categoria,
forum_usu_id=_propietario,Profesion_prof_id=_titulo,mie_descripcion_desafio=_desafios,
mie_participacion_correo=_correoparticipacion ,
status_member_id=_id_status, cancelled = 0 
WHERE mie_id=_id_miembro;
end if;

UPDATE persona SET 
    per_nombre=_nombre,
    per_apellido=_apellido,
    per_fechanacimiento=_fn ,
    per_tipo=_tipo_p,
    per_identificacion=_identificacion
    ,per_genero=_genero WHERE per_id=_id_persona;

     if (SELECT COUNT(tel_id) FROM telefono WHERE Persona_per_id=_id_persona and tel_tipo='C') > 0  then
             UPDATE telefono SET tel_descripcion=_telefono WHERE Persona_per_id=_id_persona and tel_tipo='C';
        else
             INSERT INTO telefono( tel_descripcion, tel_fecharegistro,Persona_per_id, tel_tipo, tel_id_usuario, tel_estado) VALUES 
        (_telefono,_fecharegistro,_id_persona,'C',_id_usuario,'A'); 
        end if;  

        if (SELECT COUNT(tel_id) FROM telefono WHERE Persona_per_id=_id_persona and tel_tipo='M') > 0  then
            UPDATE telefono SET tel_descripcion=_celular WHERE Persona_per_id=_id_persona and tel_tipo='M';
        else
            INSERT INTO telefono( tel_descripcion, tel_fecharegistro,Persona_per_id, tel_tipo, tel_id_usuario, tel_estado) VALUES 
        (_celular,_fecharegistro,_id_persona,'M',_id_usuario,'A'); 
        end if;  

        if (SELECT COUNT(redmi_id) FROM redsocial_miembro WHERE miembro_mie_id=_id_miembro and redmi_tipo='skype') > 0  then
            UPDATE redsocial_miembro SET redmi_descripcion=_id_skype WHERE miembro_mie_id=_id_miembro and redmi_tipo='skype';
        else
            INSERT INTO redsocial_miembro(redmi_descripcion, redmi_tipo, miembro_mie_id, redmi_fecharegistro, redmi_id_usuario) VALUES 
        (_id_skype,'skype',_id_miembro,_fecharegistro,_id_usuario);
        end if;  

        if (SELECT COUNT(redmi_id) FROM redsocial_miembro WHERE miembro_mie_id=_id_miembro and redmi_tipo='twitter') > 0  then
            UPDATE redsocial_miembro SET redmi_descripcion=_id_Twitter WHERE miembro_mie_id=_id_miembro and redmi_tipo='twitter';
        else
            INSERT INTO redsocial_miembro(redmi_descripcion, redmi_tipo, miembro_mie_id, redmi_fecharegistro, redmi_id_usuario) VALUES 
        (_id_Twitter,'twitter',_id_miembro,_fecharegistro,_id_usuario);
        end if; 

        if (SELECT COUNT(dir_id) FROM direccion WHERE  Persona_per_id=_id_persona Limit 1) > 0  then
            UPDATE direccion SET dir_calleprincipal=_calle,ciudad_ciu_id=_ciudad WHERE Persona_per_id=_id_persona;
        else
             INSERT INTO direccion(dir_calleprincipal, dir_callesecundaria, ciudad_ciu_id, Persona_per_id,dir_fecharegistro, dir_usu_id) VALUES 
           (_calle,'',_ciudad,_id_persona,_fecharegistro,_id_usuario);
        end if;  

    
    
        if (SELECT COUNT(cor_id) FROM correo WHERE Persona_per_id=_id_persona and cor_tipo = 'Personal' LIMIT 1) > 0  then
                UPDATE correo SET cor_descripcion=_correo WHERE Persona_per_id=_id_persona and cor_tipo = 'Personal';
        else
            INSERT INTO correo( cor_tipo,cor_descripcion, cor_fecharegistro, Persona_per_id, cor_id_usuario, cor_estado) 
            VALUES ('Personal',_correo,_fecharegistro,_id_persona,_id_usuario,'A');  
        end if;  

        if (SELECT COUNT(cor_id) FROM correo WHERE Persona_per_id=_id_persona and cor_tipo = 'Secundario' LIMIT 1) > 0  then
                UPDATE correo SET cor_descripcion=_correo_2 WHERE Persona_per_id=_id_persona and cor_tipo = 'Secundario';
        else
            INSERT INTO correo( cor_tipo,cor_descripcion, cor_fecharegistro, Persona_per_id, cor_id_usuario, cor_estado) 
            VALUES ('Secundario',_correo_2,_fecharegistro,_id_persona,_id_usuario,'A');  
        end if;

  


    DELETE FROM miembro_desafio WHERE miembro_mie_id= _id_miembro;
    if _lista_desafios <> '' then      
        WHILE (LOCATE(',', _lista_desafios) > 0)
        DO
            SET @value = ELT(1, _lista_desafios);
            SET _lista_desafios= SUBSTRING(_lista_desafios, LOCATE(',',_lista_desafios) + 1);
            INSERT INTO miembro_desafio( miembro_mie_id, desafio_des_id, mie_des_estado) 
            VALUES (_id_miembro,@value,'A');
        END WHILE;
    end if;

    DELETE FROM miembro_hobbises WHERE miembro_mie_id= _id_miembro;
    if _lista_hobbies <> '' then      
        WHILE (LOCATE(',', _lista_hobbies) > 0)
        DO
            SET @value = ELT(1, _lista_hobbies);
            SET _lista_hobbies= SUBSTRING(_lista_hobbies, LOCATE(',',_lista_hobbies) + 1);

            INSERT INTO miembro_hobbises( hobbies_hob_id, miembro_mie_id) 
            VALUES (@value,_id_miembro);
        END WHILE;
    end if;

    
END;
