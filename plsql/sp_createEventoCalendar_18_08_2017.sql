CREATE DEFINER=`execforums`@`localhost` PROCEDURE `sp_createEventoCalendar`(IN `_responsable` VARCHAR(100), 
IN `_toeldia` INT, IN `_fi` TIMESTAMP, IN `_ff` TIMESTAMP, 
IN `_descripcion` VARCHAR(200), IN `_fr` TIMESTAMP, IN `_usuario` INT, 
IN `_lista_invitados` VARCHAR(250), IN `_lista_grupos` VARCHAR(250), 
IN `_lista_miembros` VARCHAR(250), IN `_mis_grupos` INT, IN `_todos_grupos` INT, 
IN `_id_tipo_evento` INT, IN `_id_direccion` varchar(200), IN `_id_acompanado` INT, 
IN `_lista_contactos` VARCHAR(250), IN `_lista_empresarios_mes` VARCHAR(250), 
IN `_nombre` VARCHAR(100), IN `_generador_id` INT, IN `_lista_todos_grupos` VARCHAR(250), IN _ciudad int)
BEGIN


DECLARE _LID_EVENTO int;


INSERT INTO evento(	eve_nombre, eve_responsable, eve_todoeldia, eve_fechainicio, eve_fechafin, eve_fecharegistro, eve_fechamodificacion, eve_id_usuario,
                 tipo_evento_id, direccion_id, eve_descripcion, eve_mis_grupos, eve_todos_grupos,generador_id, ciudad_ciu_id) 
VALUES (_nombre,_responsable,_toeldia,_fi,_ff,_fr,_fr,_usuario,_id_tipo_evento,_id_direccion,_descripcion,_mis_grupos,_todos_grupos, _generador_id, _ciudad);

    SET _LID_EVENTO = LAST_INSERT_ID();

INSERT INTO evento_grupo( evento_eve_id, grupos_gru_id) VALUES (_LID_EVENTO,_lista_grupos);
    if _id_acompanado <> '' then
        UPDATE evento SET evento_acompanado=_id_acompanado  WHERE eve_id=_LID_EVENTO;
		
    end if;
	

    if _lista_miembros <> '' then
        WHILE (LOCATE(',', _lista_miembros) > 0)
        DO
            SET @value = ELT(1, _lista_miembros);
            SET _lista_miembros= SUBSTRING(_lista_miembros, LOCATE(',',_lista_miembros) + 1);
            INSERT INTO evento_miembro( evento_eve_id, miembro_mie_id) VALUES (_LID_EVENTO,@value);

        END WHILE;
    end if;

    if _lista_todos_grupos <> '' then
        WHILE (LOCATE(',', _lista_todos_grupos) > 0)
        DO
            SET @value = ELT(1, _lista_todos_grupos);
            SET _lista_todos_grupos= SUBSTRING(_lista_todos_grupos, LOCATE(',',_lista_todos_grupos) + 1);
            INSERT INTO evento_grupo( evento_eve_id, grupos_gru_id) VALUES (_LID_EVENTO,@value);

        END WHILE;
    end if;


    if _lista_invitados <> '' then
        WHILE (LOCATE(',', _lista_invitados) > 0)
        DO
            SET @value = ELT(1, _lista_invitados);
            SET _lista_invitados= SUBSTRING(_lista_invitados, LOCATE(',',_lista_invitados) + 1);

            INSERT INTO evento_participante( participante_part_id, evento_eve_id) VALUES (@value,_LID_EVENTO);
        END WHILE;
    end if;



     if _lista_contactos <> '' then
        WHILE (LOCATE(',', _lista_contactos) > 0)
        DO
            SET @value = ELT(1, _lista_contactos);
            SET _lista_contactos= SUBSTRING(_lista_contactos, LOCATE(',',_lista_contactos) + 1);

            INSERT INTO evento_participante( participante_part_id, evento_eve_id)  VALUES (@value,_LID_EVENTO);
        END WHILE;
    end if;
    
    if _lista_empresarios_mes <> '' then
        WHILE (LOCATE(',', _lista_empresarios_mes) > 0)
        DO
            SET @value = ELT(1, _lista_empresarios_mes);
            SET _lista_empresarios_mes= SUBSTRING(_lista_empresarios_mes, LOCATE(',',_lista_empresarios_mes) + 1);

            INSERT INTO `evento_empresario_mes`( `miembro_mie_id`, `evento_eve_id`, `eve_emp_estado`, `eve_emp_fecharegistro`, `eve_emp_fechamodificacion`, `eve_emp_id_usuario`)
             VALUES (@value,_LID_EVENTO,'1',_fr,_fr,_usuario);
          
        END WHILE;
    end if;
    SELECT MAX(eve_id) as 'eve_id' FROM evento;
 
END;
